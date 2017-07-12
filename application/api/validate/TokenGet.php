<?php
namespace app\api\validate;
/**
 * Class TokenGet
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class TokenGet extends BaseValidate
{
    protected  $rule = [
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => '没有code还想拿token?'
    ];
}