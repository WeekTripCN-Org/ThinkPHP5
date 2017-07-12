<?php
namespace app\lib\exception;
/**
 * Class WechatException
 * @package \app\lib\exception
 * @author  weektrip@weektrip.cn
 */
class WechatException extends BaseException
{
    public $code = 400;
    public $msg  = 'wechat unknow error';
    public $errorCode = 999;
}