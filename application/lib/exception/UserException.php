<?php
namespace app\lib\exception;
/**
 * Class UserException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class UserException extends BaseException
{
    public $code = 404;
    public $msg  = '用户不存在';
    public $errorCode = 60000;
}