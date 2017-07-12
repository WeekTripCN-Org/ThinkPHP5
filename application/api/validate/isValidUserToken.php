<?php
namespace app\api\validate;
/**
 * Class isValidUserToken
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class isValidUserToken extends BaseValidate
{
    protected $rule = [
        'token' => 'isValidUserToken'
    ];
}