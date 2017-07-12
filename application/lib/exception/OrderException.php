<?php
namespace app\lib\exception;
/**
 * Class OrderException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class OrderException extends BaseException
{
    public $code = 404;
    public $msg  = '订单不存在，请检查ID';
    public $errorCode = 80000;
}