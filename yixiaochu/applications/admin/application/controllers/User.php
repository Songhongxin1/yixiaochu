<?php 
/**
* 会员管理控制器
* @author weiqiang@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class User extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_user' => 'Muser',
             'Model_user_addr' => 'Muser_addr'
        ]);
        $this->pageconfig = C('page.config_log');
        $this->load->library('pagination');
    }
    

    /**
     * 会员列表
     */
    public function index() {
        $data = $this->data;
        $page =  intval($this->input->get("per_page",true)) ?  : 1;
        $size = $this->pageconfig['per_page'];
        if(IS_POST){
            $data['user_name'] = $user_name = $this->input->post('user_name');
            $this->db->select("*");
            $this->db->from('t_user');
            $this->db->like("user_name", $user_name);
            $data['log_list'] = $this->db->get()->result_array();
            $data_count = $this->db->count_all_results();
        }else{
            $data['log_list'] = $this->Muser->get_lists('*', '', array("id"=>"desc"), $size, ($page-1)*$size);
            $data_count = $this->Muser->count("");
        }
        
        //获取分页
        if(! empty($data['log_list'])){
            $this->pageconfig['base_url'] = "/user";
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        $data['page'] = $page;
        $data['data_count'] = $data_count;
        $this->load->view("user/index", $data);
    }


    /**
     * 收货地址
     */
    public function info($id = 0) {
        $data = $this->data;
        $data['details'] = $this->Muser_addr->get_lists("*",array("user_id"=>$id));
        $this->load->view('user/info', $data);
    }


    /**
     * 登录限制
     */
    public function set_login($id, $state) {
        $datas = array('is_limit' => $state);
        $where = array("id"=>$id);
        $result = $this->Muser->update_info($datas,$where);
        if($result) {
            $this->success("操作成功！", "/user");
        } else {
            $this->success("操作失败！", "/user");
        }
    }
}

