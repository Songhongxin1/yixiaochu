<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 用户评论model
 * 
 * @author weiqiang
 *
 */
class Model_comment extends MY_Model {

    private $_table = 't_comment';

    public function __construct() {
        parent::__construct($this->_table);
    }
    
    
    
}