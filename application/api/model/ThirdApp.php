<?php
namespace app\api\model;
/**
 * Class ThirdApp
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class ThirdApp extends BaseModel
{
    public static function check($ac, $se)
    {
        $app = self::where('app_id', '=', $ac)
            ->where('app_secret', '=', $se)
            ->find();
        return $app;
    }
}