<?php
namespace app\api\model;
/**
 * Class User
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class User extends BaseModel
{
    protected $autoWriteTimestamp = true;

    public function orders()
    {
        return $this-$this->hasMany('Order', 'user_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    /**
     * @param $openid
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
        $user = User::where('openid', '=', $openid)->find();
        return $user;
    }
}