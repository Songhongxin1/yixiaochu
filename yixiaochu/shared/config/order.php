<?php
/**
 * 订单配置
 *
 */
$config = array (
  'status' => array (
    'no_pay' => array (
      'id' => 1,
      'name' => '未支付'
    ),
    'no_complete_pay' => array (
      'id' => 2,
      'name' => '支付未完成'
    ),
    'wait_send' => array (
      'id' => 3,
      'name' => '待发货'
    ),
    'sended' => array (
      'id' => 4,
      'name' => '已发货'
    ),
    'sured' => array (
      'id' => 5,
      'name' => '确认收货'
    ),
    'refund_apply' => array (
      'id' => 6,
      'name' => '退款申请'
    ),
    'refund_success' => array (
      'id' => 7,
      'name' => '退款成功'
    ),
    'refund_failed' => array (
      'id' => 8,
      'name' => '拒绝退款'
    )
  ),
  // 订单类型
  'type' => array (
    'combo' => array (
      'id' => 1,
      'name' => '套餐'
    ),
    'single' => array (
      'id' => 2,
      'name' => '单份'
    )
  ),
  // 支付类型
  'pay_type' => array (
    'weixin' => array (
      'id' => 1,
      'name' => '微信支付'
    ),
    'alipay' => array (
      'id' => 2,
      'name' => '支付宝支付'
    ),
    'aapay' => array (
      'id' => 3,
      'name' => 'AA支付'
    )
  )
);