<?php
/**
 * 配送员
 * @author chaokai@gz-zc.nc
 */
class Model_express extends MY_Model{
  
  private $_table = 't_express';
  
  public function __construct(){
    parent::__construct($this->_table);
  }
  
  /**
   * 获取列表
   * @author chaoaki@gz-zc.cn
   *
   */
  public function get_list($where = array()){
    $default_where = array('is_del' => 0);
    $where = array_merge($default_where, $where);
    
    $list = $this->get_lists('id,name,username,mobile,address,is_limit,head_img', $where);
    if($list){
      foreach ($list as $k => $v){
        if($v['is_limit'] == 0){
          $list[$k]['is_limit_text'] = '否';
        }else{
          $list[$k]['is_limit_text'] = '是';
        }
        $list[$k]['head_img'] = get_full_img_url($v['head_img']);
      }
    }
    
    return $list;
  }
  
  /**
   * 获取详情
   * @author chaokai@gz-zc.cn
   */
  public function get_info($id){
    $info = $this->get_one('*', array('id' => $id));
    if($info){
      $info['head_img_url'] = get_full_img_url($info['head_img']);
    }
    return $info;
  }
  
}