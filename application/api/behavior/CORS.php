<?php
/**
 * @author weektrip@weektrip.cn
 * 2017/7/10
 */
namespace app\api\behavior;

class CORS
{
    public function appInit(&$params)
    {
        header('Access-Control-Allow-Origin: *'); // 允许所有域名访问API
        header('Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept');
        header('Access-Control-Allow-Method: POST, GET');
        if (request()->isOptions()) {
            exit();
        }
    }
}
