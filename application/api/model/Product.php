<?php
namespace app\api\model;
use think\Model;

/**
 * Class Product
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class Product extends BaseModel
{
    protected $autoWriteTimestamp = 'datetime';
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'
    ];

    /*
     * 图片属性
     */
    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }

    public function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }

    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    /**
     * @param      $categoryId
     * @param bool $paginate
     * @param int  $page
     * @param int  $size
     * @return false|\PDOStatement|string|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取某栏目下的商品
     */
    public static function getProductsByCategoryId($categoryId, $paginate = true, $page = 1, $size = 30)
    {
        $query = self::where('category_id', '=', $categoryId);
        if (!$paginate) {
            return $query->select();
        } else {
            // $paginate 第二个参数true表示采用简洁模式，简洁模式不需要查询记录总数
            return $query->paginate($size, true, ['page' => $page]);
        }
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取商品详情
     */
    public static function getProductDetail($id)
    {
        // 不能在with加空格！
        $product = self::with([
            'imgs' => function($query) {
                $query->with(['imgUrl'])->order('order', 'asc');
            }
        ])->with('properties')->find($id);
        return $product;
    }

    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

}