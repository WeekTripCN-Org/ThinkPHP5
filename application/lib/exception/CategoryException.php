<?php
namespace app\lib\exception;
/**
 * Class CategoryException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class CategoryException extends BaseException
{
    public $code = 404;
    public $msg  = '指定类目不存在，请检查商品ID';
    public $errorCode = 20000;
}