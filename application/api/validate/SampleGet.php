<?php
namespace app\api\validate;
/**
 * Class SampleGet
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class SampleGet extends BaseValidate
{
    protected $rule = [
        'key' => 'number',
    ];

    protected $message = [];
}