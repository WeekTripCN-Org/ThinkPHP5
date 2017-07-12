<?php
namespace app\api\model;
/**
 * Class Image
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class Image extends BaseModel
{
    protected $hidden = ['delete_time', 'id', 'from'];
    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}