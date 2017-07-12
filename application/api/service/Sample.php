<?php
namespace app\api\service;

use app\api\model\Sample AS SampleModel;
/**
 * Class Sample
 * @package \app\api\service
 * @author  weektrip@weektrip.cn
 */
class Sample
{
    public static function getSampleByKey($key)
    {
        $banners =SampleModel::all(['key' => $key]);
        return $banners;
    }
}