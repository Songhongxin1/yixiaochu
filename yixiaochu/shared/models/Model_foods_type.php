<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 菜品分类表
 * @author chaokai@gz-zc.cn
 */

class Model_foods_type extends MY_Model{
    
    private $_table = 't_foods_type';
    public function __construct(){
        parent::__construct($this->_table);
        
        $this->load->model(array(
          'Model_admins' => 'Madmins',
        ));
    }
    
    /**
     * 获取列表
     * @author chaokai@gz-zc.cn
     * @return unknown
     */
    public function get_list(){
        
        $result = $this->get_lists('id,name');
        return $result;
    }
    
    /**
     * 管理获取列表
     * @author chaokai@gz-zc.cn
     */
    public function type_list(){
      $result = $this->get_lists('*', array('is_del' => 0));
      $admin_list = $this->Madmins->get_lists('id,fullname');
      foreach ($result as $k => $v){
        foreach ($admin_list as $key => $value){
          if($v['create_admin'] == $value['id']){
            $result[$k]['create_admin_name'] = $value['fullname'];
          }
          if($v['update_admin'] == $value['id']){
            $result[$k]['update_admin_name'] = $value['fullname'];
          }
        }
      }
      
      return $result;
    }
}