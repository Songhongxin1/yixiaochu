<?php
/**
 * 操作日志
 * @author nengfu@gz-zc.cn
 */
defined('BASEPATH') or exit('No direct script access allowed');
class Operatelog extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_login_log' => 'Mlogin_log',
        ]);
        $this->pageconfig = C('page.config_log');
        $this->load->library('pagination');
    }


    /**
     * 右边内容
     */
    public function index() {
        $data = $this->data;
        $data['title'] = array("操作日志","日志列表");

        $page =  intval($this->input->get("per_page",true)) ?  : 1;
        $size = $this->pageconfig['per_page'];
        $data['log_list'] = $this->Mlogin_log->get_lists('*','',array("id"=>"desc"),$size,($page-1)*$size);

        $data_count = $this->Mlogin_log->count();

        //获取分页
        if(! empty($data['log_list'])){
            $this->pageconfig['base_url'] = "/operatelog/index";
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        $data['page'] = $page;
        $data['data_count'] = $data_count;
        $this->load->view("log/index",$data);
    }



}

