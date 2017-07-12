<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\PagingParameter;
use app\lib\exception\ParameterException;
use app\lib\exception\ProductException;
use app\lib\exception\ThemeException;
use think\Controller;

/**
 * Class Product
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Product extends BaseController
{
    protected $beforeActionList = [
        'checkSuperScope'   => ['only' => 'createOne, deleteOne']
    ];

    /**
     * @param int $id       商品ID
     * @param int $page     分页页数
     * @param int $size     每页数目
     * @return array
     * @throws ParameterException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据类目ID获取该类目下所有商品(分页)
     * $url /product?id=:category_id&page=:page&size=:page_size
     */
    public function getByCategory($id = -1, $page = 1, $size = 30)
    {
        (new IDMustBePostiveInt())->goCheck();
        (new PagingParameter())->goCheck();
        $pagingProducts = ProductModel::getProductsByCategoryId($id, true, $page, $size);
        if ($pagingProducts->isEmpty()) {
            return [
                'current_page' => $pagingProducts->currentPage(),
                'data' => []
            ];
        }
        $data = $pagingProducts->hidden(['summary'])->toArray();
        return [
            'current_page' => $pagingProducts->currentPage(),
            'data'  => $data
        ];
    }

    /**
     * @param int $id   分类id号
     * @return mixed
     * @throws ParameterException
     * @throws ThemeException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取某分类下全部商品(不分页)
     * @url /product/all?id=:category_id
     */
    public function getAllInCategory($id = -1)
    {
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryId($id, false);
        if ($products->isEmpty()) {
            throw new ThemeException();
        }
        $data = $products->hiddne(['summary'])->toArray();
        return $data;
    }

    /**
     * @param int $count
     * @return mixed
     * @throws ParameterException
     * 获取指定数量的最近商品
     * @url /product/recent?count=:count
     */
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {

        }
        $products = $products->hidden(['summary'])->toArray();
        return $products;
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws ParameterException
     * @throws ProductException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取商品详情
     * 如果商品详情信息很多，需要考虑分多个接口分布加载
     * @url /product/:id
     */
    public function getOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductException();
        }
        return $product;
    }

    public function createOne()
    {
        $product = new ProductModel();
        $product->save([
            'id'    => 1
        ]);
    }

    public function deleteOne($id)
    {
        ProductModel::destroy($id);
    }
}