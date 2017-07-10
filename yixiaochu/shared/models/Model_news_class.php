<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 资讯分类model
 * 
 * @author jianming@gz-zc.cn
 *
 */
class Model_news_class extends MY_Model {

    private $_table = 't_news_class';

    public function __construct() {
        parent::__construct($this->_table);
    }
    
    
    
}