<?php
namespace app\api\model;
/**
 * Class BannerItem
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class BannerItem extends BaseModel
{
    protected $hidden = ['id', 'img_id', 'banner_id', 'delete_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}