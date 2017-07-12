<?php
/**
 * @author weektrip@weektrip.cn
 * 2017/7/10
 */
namespace  app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    public $code = 400;
    public $msg  = 'invalid parameters';
    public $errorCode = 999;

    public $shouldToClient = true;

    public function __construct($params = array())
    {
        if (!is_array($params)) {
            return;
        }
        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('errorCode', $params)) {
            $this->errorCode = $params['errorCode'];
        }
    }
}