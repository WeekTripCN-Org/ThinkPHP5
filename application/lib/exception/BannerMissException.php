<?php
namespace app\lib\exception;
/**
 * Class BannerMissException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg  = '请求的Banner不存在';
    public $errorCode = 40000;
}