<?php
namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\api\model\Category as CategoryModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\MissException;

/**
 * Class Category
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Category extends BaseController
{
    /**
     * @return false|static[]
     * @throws MissException
     * @throws \think\exception\DbException
     * 获取全部类目列表，但不包含类目下的商品
     * @url /category/all
     */
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');
        if (empty($categories)) {
            throw new MissException([
                'msg'       => '还没有任何项目',
                'errorCode' => 50000
            ]);
        }
        return $categories;
    }

    public function getCategory($id)
    {
        $validate = new IDMustBePostiveInt();
        $validate->goCheck();
        $category = CategoryModel::getCategory($id);
        if (empty($category)) {
            throw new MissException([
                'msg' => 'category not found'
            ]);
        }
        return $category;
    }
}