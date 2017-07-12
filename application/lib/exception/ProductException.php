<?php
namespace app\lib\exception;
/**
 * Class ProductException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class ProductException extends BaseException
{
    public $code = 404;
    public $msg  = '指定商品不存在，请检查商品ID';
    public $errorCode = 20000;
}