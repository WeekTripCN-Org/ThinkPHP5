<?php
namespace app\api\validate;
/**
 * Class AppTokenGet
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac'    => 'require|isNotEmpty',
        'se'    => 'require|isNotEmpty'
    ];
}