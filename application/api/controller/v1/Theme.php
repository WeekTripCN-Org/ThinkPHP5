<?php
namespace app\api\controller\v1;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePostiveInt;
use app\api\validate\ThemeProduct;
use app\lib\exception\SuccessMessage;
use app\lib\exception\ThemeException;
use think\Controller;

/**
 * Class Theme
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 * 主题推荐，主题指首页里多个聚合在一起的商品
 */
class Theme extends Controller
{
    /**
     * @url  /theme?ids=:id1,id2,id3...
     * @param string $ids
     * @return false|\PDOStatement|string|\think\Collection
     * @throws ThemeException
     * @throws \app\lib\exception\ParameterException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     *
     * 实体查询分单一和列表查询，可以只设计一个接收列表接口，单一查询也需要传入一个元素的数组
     * 对于传递多个数组的id可以选用post传递、多个id+分隔符或者将多个序列化成json并在query中传递
     */
    public function getSimpleList($ids = '')
    {
        $validate = new IDCollection();
        $validate->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if ($result->isEmpty()) {
            throw new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if (!$theme) {
            throw new ThemeException();
        }
        return $theme->hidden(['products.summary'])->toArray();
    }

    public function addThemeProduct($t_id, $p_id)
    {
        $validate = new ThemeProduct();
        $validate->goCheck();
        ThemeModel::addThemeProduct($t_id, $p_id);
        return new SuccessMessage();
    }

    public function deleteThemeProduct($t_id, $p_id)
    {
        $validate = new ThemeProduct();
        $validate->goCheck();
        $themeID = (int)$t_id;
        $productID = (int)$p_id;
        ThemeModel::deleteThemeProduct($themeID, $productID);
        return new SuccessMessage([
            'code' => 204
        ]);
    }
}