<?php
/**
 * @author weektrip@weektrip.cn
 * 2017/7/10
 */
return [
    'app_id'        => 'wx9d6f937f290f66f1',
    'app_secret'    => 'd17e0bb8a073b3f09c725240b65ed18b',
    // 微信使用code换取用户openid及session_key的url地址
    'login_url'     => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s"
];
