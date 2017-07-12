<?php
namespace app\api\model;
use app\lib\exception\ProductException;
use app\lib\exception\ThemeException;

/**
 * Class Theme
 * @package \app\api\model
 * @author  weektrip@weektrip.cn
 */
class Theme extends BaseModel
{
    protected $hidden = ['delete_time', 'topic_img_id', 'head_img_id'];

    /**
     * @return \think\model\relation\BelongsTo
     * 要注意belongsTo和hasOne的区别
     * 带外键的表一般定义belongsTo，另外一方定义hasOne
     */
    public function topicImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    /**
     * @return \think\model\relation\BelongsToMany
     * 关联product，多对多关系
     */
    public function products()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }

    public function getThemes()
    {

    }

    public static function getThemeWithProducts($id)
    {
        $themes = self::with('products, topicImg, headImg')
            ->find($id);
        return $themes;
    }

    /**
     * @param $ids
     * @return array|false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取主题列表
     */
    public static function getThemeList($ids)
    {
        if (empty($ids)) {
            return [];
        }
        $themes = self::with('products,img')
            ->select($ids);
        return $themes;
    }

    public static function deleteThemeProduct($themeID, $productID)
    {

    }

    public static function checkRelationExist($themeID, $productID)
    {
        $theme = self::get($themeID);
        if (!$theme) {
            throw new ThemeException();
        }
        $product = Product::get($productID);
        if (!$product) {
            throw new ProductException();
        }
        return [
            'theme'     => $theme,
            'product'   => $product
        ];
    }
}