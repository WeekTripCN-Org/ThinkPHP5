<?php
namespace app\api\validate;
/**
 * Class Count
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1, 15',
    ];
}