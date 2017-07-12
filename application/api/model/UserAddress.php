<?php
namespace app\api\model;
/**
 * Class UserAddress
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class UserAddress extends BaseModel
{
    protected  $hidden = ['id', 'delete_time', 'user_id'];
}