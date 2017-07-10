<?php
/**
 * 订单
 */
class Model_order_detail extends MY_Model{
  
  private $_table = 't_order_detail';
  
  public function __construct(){
    parent::__construct($this->_table);
  }
  
}
