<?php
/**
 * @author weektrip@weektrip.cn
 * 2017/7/10
 */
namespace app\lib\enum;

class OrderStatusEnum
{
    const UNPAID    = 1; //待支付
    const PAID      = 2; //已支付
    const DELIVERED = 3; //已发货
    const PAID_BUT_OUT_OF = 4; //已支付，但库存不足
    const HANDLED_OUT_OF  = 5; //已处理
}
