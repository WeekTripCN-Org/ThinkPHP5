<?php
namespace app\api\validate;
/**
 * Class PagingParameter
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page'  => 'isPositiveInteger',
        'size'  => 'isPositiveInteger'
    ];

    protected $message = [
        'page'  => '分页参数必须是正整数',
        'size'  => '分页参数必须是正整数'
    ];
}