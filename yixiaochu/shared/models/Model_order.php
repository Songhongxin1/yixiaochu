<?php
/**
 * 订单
 */
class Model_order extends MY_Model{
  
  private $_table = 't_order';
  
  public function __construct(){
    parent::__construct($this->_table);
    
    $this->load->model(array(
    	'Model_user' => 'Muser',
        'Model_order_detail' => 'Morder_detail',
        'Model_combo' => 'Mcombo',
        'Model_user_addr' => 'Muser_addr',
    ));
  }
  
  /**
   * 获取订单列表
   */
  public function get_list($where = array(), $pagesize = 10, $offset = 0){
    
    //默认显示等待发货订单
    $default_where = array(
    	'is_del' => 0,
        'status' => C('order.status.wait_send.id')
    );
    
    $where = array_merge($default_where, $where);
    $order_by = array('create_time' => 'desc');
    $field = 'id,order_number,create_id,status,create_time';
    
    //订单列表
    $list = $this->get_lists($field, $where, $order_by, $pagesize, $offset);
    $count = $this->count($where);
    
    if($list){
      //用户列表
      $user_ids = array_column($list, 'create_id');
      $user_list = $this->Muser->get_list_by_ids($user_ids);
      
      //组合用户数据
      foreach ($list as $k => $v){
        foreach ($user_list as $key => $value){
          if($v['create_id'] == $value['id']){
            $list[$k]['user_name'] = $value['user_name'];
            $list[$k]['user_phone'] = $value['user_phone'];
            break;
          }
        }
      }
      
      //状态数据
      $status_list = array_column(C('order.status'), 'name', 'id');
      foreach ($list as $k => $v){
        $list[$k]['status_text'] = $status_list[$v['status']];
      }
    }
    
    return array('list' => $list, 'count' => $count);
    
  }
  
  /**
   * 订单详情，顾客信息、订单地址、订单菜品目录
   * @author chaokai@gz-zc.cn
   */
  public function get_info($id){
    
    $field = 'id,pid,order_number,trade_id,create_id,create_time,need_pay,pay_type,order_type,status,addr_id';
    $order_info = $this->get_one($field, array('id' => $id));
    if(!$order_info){
      return false;
    }
    //支付类型
    $pay_type_list = array_column(C('order.pay_type'), 'name', 'id');
    $order_info['pay_type_text'] = $pay_type_list[$order_info['pay_type']];
    //订单类型
    $order_type_list = array_column(C('order.type'), 'name', 'id');
    $order_info['order_type_text'] = $order_type_list[$order_info['order_type']];
    //订单状态
    $status_list = array_column(C('order.status'), 'name', 'id');
    $order_info['status_text'] = $status_list[$order_info['status']];
    
    //订单详情
    $detail_field = 'id,order_id,menus_id,foods_id,buy_number,order_name,pay_price';
    $order_detail = $this->Morder_detail->get_lists($detail_field, array('order_id' => $order_info['id']));
    if($order_info['order_type'] == C('order.type.combo.id')){
      //如果是套餐
      //在每条套餐记录中增加菜品数组
      foreach ($order_detail as $k => $v){
        $info_list[$k]['foods_ids'] = explode(',', $v['foods_id']);
      }
      //合并所有菜品id
      $foods_ids = array();
      foreach ($order_detail as $k => $v){
        $foods_ids = array_unique(array_merge(explode(',', $v['foods_id']), $foods_ids));
      }
      //查询菜品信息
      $foods_list = $this->Mfoods->get_list_by_ids($foods_ids);
      
      foreach ($info_list as $k => $v){
        foreach ($foods_list as $key => $value){
          if(in_array($value['id'], $v['foods_ids'])){
            $order_detail[$k]['foods'][] = $value;
            break;
          }
        }
      }
    }
    
    $order_info['detail'] = $order_detail;
    //订单用户信息
    $order_info['user_info'] = $this->Muser_addr->get_one('*', array('id' => $order_info['addr_id']));
    
    return $order_info;
    
  }
}