<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 吐槽表
 * @author songchi@gz-zc.cn
 */

class Model_scoff extends MY_Model{
    
    private $_table = 't_scoff';
    public function __construct(){
        parent::__construct($this->_table);
        
        $this->load->model(array(
          'Model_admins' => 'Madmins',
        ));
    }
    
}