<?php
namespace app\lib\exception;
/**
 * Class SuccessMessage
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg  = 'ok';
    public $errorCode = 0;
}