<?php
namespace app\api\validate;
/**
 * Class IDMustBePostiveInt
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class IDMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id'    => 'require|isPositiveInteger'
    ];

    protected $message = [
        'id'    => 'id必须是正整数'
    ];
}