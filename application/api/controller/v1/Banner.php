<?php
namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\BannerMissException;
use app\lib\exception\MissException;

/**
 * Class Banner
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Banner
{
    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws MissException
     * @throws \app\lib\exception\ParameterException
     * 获取Banner信息
     */
    public function getBanner($id)
    {
        $validate = new IDMustBePostiveInt();
        $validate->goCheck();
        $banner = BannerModel::getBannerById($id);
        if (!$banner) {
            throw new MissException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
        }
        return $banner;
    }
}