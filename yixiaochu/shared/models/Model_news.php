<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 资讯分类model
 * 
 * @author jianming@gz-zc.cn
 *
 */
class Model_news extends MY_Model {

    private $_table = 't_news';

    public function __construct() {
        parent::__construct($this->_table);
    }

    /** 
     * 根据条件获取资讯
     */
    public function get_news_by_where($field = "*" , $where = array(), $sort = array(), $pagesize = 0, $offset = 0) {
        $where = array_merge($where, array('is_del' => 0, 'publish_time<=' => date('Y-m-d H:i:s'), 'publish_status' => 1));
        $data = $this->Mnews->get_lists($field, $where, $sort, $pagesize, $offset);
        if ($data) {
            foreach ($data as $key => $val) {
                $data[$key]['cover_img'] =  get_full_img_url($val['cover_img']);
            }
        }
        $count = $this->Mnews->count($where);
        $result = array('list' => $data, 'count' => $count);
        return $result;
    }

    
    
}