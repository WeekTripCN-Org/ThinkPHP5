<?php
namespace app\lib\exception;

/**
 * Class ParameterException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class ParameterException extends BaseException
{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = 'invalid parameters';
}