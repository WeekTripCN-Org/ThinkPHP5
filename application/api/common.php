<?php
/**
 * 公共方法
 * @author weektrip@weektrip.cn
 * 2017/7/10
 */

/**
 * POST请求
 * @param       $url
 * @param array $params
 * @return mixed
 */
function curl_post($url, array $params = array())
{
    $data_string = json_encode($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_PORT, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * @param $url
 * @param $rowData
 * @return mixed
 */
function curl_post_raw($url, $rowData)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_PORT, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $rowData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:text'));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

/**
 * @param     $url
 * @param int $httpCode
 * @return mixed
 */
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // 不做证书校验，部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    return $file_contents;
}

/**
 * 获取随机码
 * @param $length
 * @return null|string
 */
function getRandChar($length)
{
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $max = strlen($strPol) -1;
    for($i = 0;$i < $length;$i++ ){
        $str .= $strPol[rand(0, $max)];
    }
    return $str;
}

function fromArrayToModel($m, $array)
{
    foreach ($array as $key => $value)
    {
        $m[$key] = $value;
    }
    return $m;
}