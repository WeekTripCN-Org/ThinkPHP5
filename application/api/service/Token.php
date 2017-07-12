<?php
/**
 * @author weektrip@weektrip.cn
 * 2017/7/10
 */
namespace app\api\service;

use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\ParameterException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * 生成令牌
     * @return string
     */
    public static function generateToken()
    {
        $randChar  = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }

    /**
     * 验证Token是否合法或者是否过期
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /**
     * 用户专有权限
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    /**
     * 管理员权限
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars  = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentIdentity($keys)
    {
        $token = Request::instance()->header('token');
        $identities = Cache::get($token);
        if (!$identities) {
            throw new TokenException();
        } else {
            $identities = json_decode($identities, true);
            $result = [];
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $identities)) {
                    $result[$key] = $identities[$key];
                }
            }
            return $result;
        }
    }

    /**
     * 当需要获取全局UID时，调用此方法，而不应当自己解析UID
     * @return mixed
     * @throws Exception
     * @throws ParameterException
     * @throws TokenException
     */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        $scope = self::getCurrentTokenVar('scope');
        if ($scope == ScopeEnum::Super) {
            // 只有Super权限才可以自己传入uid，且必须在get参数中，post不接受任何uid字段
            $userId = input('get.uid');
            if (!$userId) {
                throw new ParameterException(
                    ['msg' => '没有指定需要操作的用户对象']
                );
            }
            return $userId;
        } else {
            return $uid;
        }
    }

    /**
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws ParameterException
     * @throws TokenException
     * 检查操作UID是否合法
     */
    public static function isValidOperate($checkedUID)
    {
        if (!$checkedUID) {
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkedUID) {
            return true;
        }
        return false;
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if ($exist) {
            return true;
        } else {
            return false;
        }
    }
}