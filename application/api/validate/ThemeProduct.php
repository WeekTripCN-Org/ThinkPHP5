<?php
namespace app\api\validate;
/**
 * Class ThemeProduct
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class ThemeProduct extends BaseValidate
{
    protected $rule = [
        't_id'  => 'number',
        'p_id'  => 'number'
    ];
}