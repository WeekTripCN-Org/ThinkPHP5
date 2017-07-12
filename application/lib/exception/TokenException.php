<?php
namespace app\lib\exception;
/**
 * Class TokenException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class TokenException extends BaseException
{
    public $code = 401;
    public $msg  = 'Token已过期或无效Token';
    public $errorCode = 10001;
}