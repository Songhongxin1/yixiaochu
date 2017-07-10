<?php
/**
* 会员吐槽列表控制器
* @author weiqiang@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class Comment extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_comment' => 'Mcomment'
        ]);
        $this->pageconfig = C('page.config_log');
        $this->load->library('pagination');
    }
    public function index(){
        $data = $this->data;
        $pageconfig = C('page.config_log');
        $this->load->library('pagination');
        $page = (int)$this->input->get_post('per_page') ? : '1';
        if(IS_POST){
            $type = (int)$this->input->get_post('type');
            $data['type'] = $type;
            switch ($type){
            	case 0:
            	   $where = array("type"=>0);
            	break;
            	case 1:
            	   $where = array("type"=>1);
            	break;
            	case 2:
            	   $where = array("type"=>2);
            	break;
            	default:
        	       $where = "";
    	        break;
            }
            $data['list'] = $this->Mcomment->get_lists("*", $where, array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
            $data_count = $this->Mcomment->count($where);
        }else{
            $data['list'] = $this->Mcomment->get_lists("*", "", array("create_time" => "DESC"), $pageconfig['per_page'], ($page-1)*$pageconfig['per_page']);
            $data_count = $this->Mcomment->count();
        }
        
        $data['data_count'] = $data_count;
        $data['page'] = $page;
        $urls= array();
        $class_id = (int) $this->input->get('type', TRUE);
        if(isset($class_id)){
            $urls['class_id'] = $class_id;
        }
        $is_del = (int) $this->input->get('is_del', TRUE);
        if(isset($is_del)){
            $urls['is_del'] = $is_del;
        }
        $is_has_child = (int) $this->input->get('is_has_child');
        if($is_has_child){
            $urls['is_has_child'] = $is_has_child;
        }
        $title = trim($this->input->get('title', TRUE));
        if(isset($title)){
            $urls['title'] = $title;
        }
        $pageconfig['base_url'] = "/news/index?".http_build_query($urls);
        $pageconfig['total_rows'] = $data_count;
        $this->pagination->initialize($pageconfig);
        $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        $this->load->view("comment/index",$data);
    }
    
    
    public function show(){
        $data = $this->data;
        $where['id'] = $this->input->get("id", TRUE);
        $status = $this->input->get("status", TRUE);
        if($status == 0){
        	$set['is_show'] = 1;
        }else if($status = 1){
        	$set['is_show'] = 0;
        }else{
        	return false;
        }
        $res = $this->Mcomment->update_info($set, $where);
        if($res){
            $this->success("编辑成功","/comment");
        }else{
            $this->success("编辑失败","/comment");
        }
        
    }
    public function reply($id){
        $data = $this->data;
        $where['id'] = $id;
        $data['id'] = $id;
        $data['reply'] = $this->Mcomment->get_one("content", $where);
        if(IS_POST){
        	$reply['reply_content'] = rtrim(ltrim($this->input->post("reply", TRUE),"<p>"),"</p>");
        	@$where= "id = ".$this->input->post("id", TRUE);
        	$result = $this->Mcomment->update_info($reply, $where);
        	if($result){
        	    $this->success("回复成功","/comment");
        	}else{
        	    $this->success("回复失败","/comment");
        	}
        }
        $this->load->view("comment/reply",$data);
    }
}
