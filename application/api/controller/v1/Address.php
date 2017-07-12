<?php
namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\api\model\UserAddress;
use app\api\service\Token;
use app\lib\exception\UserException;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\api\model\User;

/**
 * Class Address
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress']
    ];

    /**
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws UserException
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取用户地址信息
     */
    public function getUserAddress()
    {
        $uid = Token::getCurrentUid();
        $userAddress = UserAddress::where('user_id', $uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

    public function createOrUpdateAddress()
    {
        $validate = new AddressNew();
        $validate->goCheck();

        $uid = Token::getCurrentUid();
        $user = User::get($uid);
        if (!$user) {
            throw new UserException([
                'code' => 404,
                'msg'  => '用户收货地址不存在',
                'errorCode' => 60001
            ])；
        }
        $userAddress = $user->address;
        // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
        $data = $validate->getDataByRule(input('posts.'));
        if (!$userAddress) {
            $user->address()->save($data);
        } else {
            // 存在则更新
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系
            // 更新的save来自于模型
            $user->address->save($data);
        }
        return new SuccessMessage();
    }
}