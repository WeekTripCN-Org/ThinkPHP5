<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;
/**
 * @param $node
 * @return bool
 * RBAC节点权限验证
 */
function auth($node)
{
    return \service\NodeService::checkAuthNode($node);
}

/**
 * @param      $name    参数名称
 * @param bool $value   默认false为获取值，否则为更新
 * @return bool|mixed|string
 * @throws \think\Exception
 * @throws \think\exception\PDOException
 * 系统配置参数
 */
function sysconf($name, $value = false)
{
    static $config = [];
    if ($value !== false) {
        $config = [];
        $data = ['name' => $name, 'value' => $value];
        return \service\DataService::save('SystemConfig', $data, 'name');
    }
    if (empty($config)) {
        foreach (Db::name('SystemConfig')->select() as $vo) {
            $config[$vo['name']] = $vo['value'];
        }
    }
    return isset($config[$name]) ? $config[$name] : '';
}

if (!function_exists("array_column")) {
    function array_column(array &$rows, $column_key, $index_key = null)
    {
        $data = [];
        foreach ($rows as $row) {
            if (empty($index_key)) {
                $data[] = $row[$column_key];
            } else {
                $data[$row[$index_key]] = $row[$column_key];
            }
        }
        return $data;
    }
}