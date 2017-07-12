<?php
namespace app\api\validate;
/**
 * Class AddressNew
 * @package \app\api\validate
 * @author  weektrip@weektrip.cn
 */
class AddressNew extends BaseValidate
{
    /*
     * 为防止欺骗重写user_id外键
     * rule中严禁使用user_id获取post参数时过滤掉user_id
     * 所有数据库和user关联的外键统一使用user_id,而不使用uid
     */
    protected $rule = [
        'name'      => 'require|isNotEmpty',
        'mobile'    => 'require|isMobile',
        'provice'   => 'require|isNotEmpty',
        'city'      => 'require|isNotEmpty',
        'country'   => 'require|isNotEmpty',
        'detail'    => 'require|isNotEmpty',
    ];
}