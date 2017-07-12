<?php
namespace app\api\controller\v1;
use app\api\controller\BaseController;
use app\api\service\Token;
use app\api\validate\OrderPlace;


/**
 * Class Order
 * @package \app\api\controller\v1
 * @author  weektrip@weektrip.cn
 */
class Order extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope'   => ['only' => 'getDetail,getSummaryByUser'],
        'checkSuperScope'     => ['only' => 'delivery,getSummary']
    ];

    public function placeOrder()
    {
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = Token::getCurrentUid();
    }
}