<?php
namespace app\admin\controller;

use controller\BasicAdmin;
use service\NodeService;
use service\ToolsService;
use think\Db;
use think\View;

/**
 * 后台入口
 * Class Index
 * @package \app\admin\controller
 * @author  weektrip@weektrip.cn
 */
class Index extends BasicAdmin
{
    public function index()
    {
        NodeService::applyAuthNode();
        // 获取所有显示菜单
        $list = Db::name('SystemMenu')->where('status', '1')->order('sort asc,id asc')->select();
        $menus = $this->_filterMenu(ToolsService::arr2tree($list));
        return View('', ['title' => '系统管理', 'menus' => $menus]);
    }

    /**
     * @param $menus
     * @return mixed
     * 后台菜单权限过滤
     */
    private function _filterMenu($menus)
    {
        foreach ($menus as $key => &$menu) {
            if (!empty($menu['sub'])) {
                $menu['sub'] = $this->_filterMenu($menu['sub']);
            }
            if (!empty($menu['sub'])) {
                $menu['url'] = '#';
            } elseif (stripos($menu['url'], 'http') === 0) {
                // 如果url以http开头
                continue;
            } elseif ($menu['url'] !== '#' && auth(join('/', array_slice(explode('/', $menu['url']), 0, 3)))) {
                $menu['url'] = url($menu['url']);
            } else {
                unset($menus[$key]);
            }
        }
        return $menus;
    }
}