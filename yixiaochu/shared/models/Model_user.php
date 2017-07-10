<?php
/**
 * 用户表
 */
class Model_user extends MY_Model{
  
  private $_table = 't_user';
  
  public function __construct(){
    parent::__construct($this->_table);
    
    $this->load->model(array(
    	'Model_user_addr' => 'Muser_addr',
        'Model_score' => 'Mcore'
    ));
  }
  
  public function get_list_by_ids($ids = array()){
    $list = $this->get_lists('id,user_name,user_phone,sex', array('in' => array('id' => $ids)));
    return $list;
  }
  
  /**
   * 获取用户详情
   * @author chaokai@gz-zc.cn
   */
  public function info($id){
      $user_info = $this->get_one('id,user_name,nickname,head_img,user_phone,sex,union_id,birthday', array('id' => $id));
      if(!$user_info){
          return false;
      }
      //查询用户当前积分
      $score = $this->Mcore->get_one('balance_score',['user_id' => $id]);
      if(!$score){
          $user_info['score'] = 0;
      }else{
          $user_info['score'] =$score['balance_score'];
      }
      
      //图片地址转换
      $user_info['head_img_url'] = get_full_img_url($user_info['head_img']);
      if($user_info['sex'] == 0){
          $user_info['sex_text'] = '女';
      }else{
          $user_info['sex_text'] = '男';
      }
      //用户地址信息
      $user_addr = $this->Muser_addr->get_lists('id, user_id, bus_area, area, addr_name, user_name, addr_phone, is_default', array('user_id' => $id, 'is_del' => 0));
      $user_info['user_addr'] = $user_addr;
      return $user_info;
  }
}