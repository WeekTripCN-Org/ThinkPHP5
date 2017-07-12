<?php
namespace app\api\service;

use app\api\model\User;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WechatException;
use think\Exception;
use think\Request;

/**
 * 微信登录
 * 如果担心频繁恶意调用，请限制ip
 * Class UserToken
 * @package \app\api\service
 * @author  weektrip@weektrip.cn
 */
class UserToken extends Token
{
    protected $code;
    protected $wxLoginUrl;
    protected $wxAppID;
    protected $wxAppSecret;

    function __construct($code)
    {
        $this->code     = $code;
        $this->wxAppID  = config('wx.app_secret');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl  = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    /**
     * @return mixed
     * @throws exception
     * 登录思路
     * 1、每次调用登录接口到都去微信刷新一次session_key，生成新的Token,不删除永久的Token
     * 2、检查Token有没有过期，没有过期则直接返回当前Token
     * 3、重新去微信刷新session_key并删除当前Token，返回新的Token
     */
    public function get()
    {
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及OpenID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }

    /**
     * 判断是否重复获取
     */
    private function duplicateFetch()
    {
        //Todo...目前无法重复获取
    }

    /**
     * @param $wxResult
     * @throws WechatException
     * 处理微信登录异常
     */
    private  function processLoginError($wxResult)
    {
        throw new WechatException([
            'msg'       => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }

    /**
     * @param $wxResult
     * @return string
     * @throws TokenException
     * 写入缓存
     */
    private function saveToCache($wxResult)
    {
        $key = self::generateToken();
        $value = json_encode($wxResult);
        $expire_in = config('setting.token_expire_in');
        $result = cache($key, $value, $expire_in);
        if (!$result) {
            throw new TokenException([
               'msg'        => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    /**
     * @param $wxResutlt
     * @return string
     * @throws TokenException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws exception\DbException
     * 颁发令牌，只要调用登录就办法新令牌
     * 但旧令牌依然可以使用
     * 所以通常令牌的有效时间比较短
     */
    private function grantToken($wxResutlt)
    {
        //此处生成的令牌使用的是TP5自带的令牌
        //$token = Request::instance()->token('token', 'md5');
        $openid = $wxResutlt['openid'];
        $user = User::getByOpenID($openid);
        if (!$user) {
            $uid = $this->newUser($openid);
        } else {
            $uid = $user->id;
        }
        $cacheValue = $this->prepareCachedValue($wxResutlt, $uid);
        $token = $this->saveToCache($cacheValue);
        return $token;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;
        return $cachedValue;
    }

    /**
     * @param $openid
     * @return mixed
     * 创建新用户
     */
    private function newUser($openid)
    {
        $user = User::create([
            'openid'    => $openid
        ]);
        return $user->id;
    }
}