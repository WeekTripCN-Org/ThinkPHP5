<?php
namespace app\api\model;
/**
 * Class ProductProperty
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'id'];
}