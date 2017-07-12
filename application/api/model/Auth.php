<?php
namespace app\api\model;
use think\Model;

/**
 * Class Auth
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class Auth extends Model
{
    public function hi()
    {
        return $this->belongsToMany('User', 'user_auth', 'auth_id', 'user_id');
    }
}