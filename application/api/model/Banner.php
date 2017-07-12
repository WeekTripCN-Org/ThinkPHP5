<?php
namespace app\api\model;
/**
 * Class Banner
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class Banner extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];
    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    /*
     * @param  $id  int  banner所在位置
     */
    public static function getBannerById($id)
    {
        $banner = self::with(['items', 'items.img'])->find($id);
        return $banner;
    }
}