<?php
namespace app\api\model;
use think\Model;
use traits\model\SoftDelete;

/**
 * Class BaseModel
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class BaseModel extends Model
{
    // 软删除，设置后在查询时要特别注意whereOr
    // 使用whereOr会将设置了软删除的记录也查询出来
    use SoftDelete;

    protected $hidden = ['delete_time'];

    protected function prefixImgUrl($value, $data)
    {
        $finalUrl = $value;
        if ($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }
}