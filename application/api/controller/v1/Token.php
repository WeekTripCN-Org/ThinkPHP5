<?php
namespace app\api\controller\v1;

use app\api\service\AppToken;
use app\api\service\UserToken;
use app\api\service\Token AS TokenService;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
/**
 * Class Token
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 *          获取令牌，相当于登录
 */
class Token
{
    /**
     * @param string $code  @post
     * @return array
     * @throws ParameterException
     * @throws \think\exception
     * 用户获取令牌（登录）
     */
    public function getToken($code='')
    {
        (new TokenGet())->goCheck();
        $wx = new UserToken($code);
        $token = $wx->get();
        return [
            'token' => $token
        ];
    }

    /**
     * @param string $ac
     * @param string $se
     * @return array
     * @throws ParameterException
     * 第三方应用获取令牌
     */
    public function getAppToken($ac='', $se='')
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        header('Access-Control-Allow-Methods: GET');
        (new AppTokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac, $se);
        return [
            'token' => $token
        ];
    }

    public function verifyToken($token='')
    {
        if (!$token) {
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid'   => $valid
        ];
    }
}