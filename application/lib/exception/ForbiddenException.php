<?php
namespace app\lib\exception;
/**
 * Token验证失败时，抛出此异常
 * Class ForbiddenException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg  = '权限不够';
    public $errorCode = 10001;
}