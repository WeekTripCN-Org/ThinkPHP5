<?php
namespace app\api\model;
/**
 * Class ProductImage
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}