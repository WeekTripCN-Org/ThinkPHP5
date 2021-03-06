<?php
namespace app\lib\exception;
/**
 * Class ThemeException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class ThemeException extends BaseException
{
    public $code = 404;
    public $msg  = '指定主题不存在，请检查主题ID';
    public $errorCode = 30000;
}