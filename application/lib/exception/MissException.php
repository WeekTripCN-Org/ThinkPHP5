<?php
namespace app\lib\exception;
/**
 * Class MissException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class MissException extends BaseException
{
    public $code = 404;
    public $msg  = 'global:your required resource are not found';
    public $errorCode = 10001;
}