<?php
/**
 * 套餐管理
 * @author yonghua@gz-zc.cn
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Combo extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Model_combo_cate' => 'Mcombocate',
            'Model_combo' => 'Mcombo',
            'Model_foods' => 'Mfoods'
        ));
        $this->pageconfig = C('page.config_log');
        $this->load->library('pagination');
    }
    
    /**
     * 套餐管理首页
     * @author yonghua@gz-zc.cn
     */
    public function index()
    {
        $data = $this->data;
        $data['title'] = ['添加套餐'];
        $page =  intval(trim($this->input->get("per_page", TRUE))) ?  :1;
        $size = $this->pageconfig['per_page'];
        $name = trim($this->input->get('combo_name', TRUE));
        $cate_id = trim($this->input->get('cate_id', TRUE));
        $update_time = trim($this->input->get('update_time', TRUE));
        if(!empty($name)){
            $where['combo_name'] = $name;
            $data['names'] = $name;
        }
        if(!empty($cate_id)){
            $where['combo_cate_id'] = $cate_id;
            $data['cate_id'] = $cate_id;
        }
        if(!empty($update_time)){
            $where['update_time >'] = date('Y-m-d H:i:s', strtotime($update_time));
            $where['update_time <'] = date('Y-m-d H:i:s', strtotime($update_time)+3600*24);
            $data['time'] = $update_time;
        }
        $where['is_del'] = 0;
        $where['is_today'] =1;
        $size = $this->pageconfig['per_page'];
        $fields ='id,combo_cate_id,combo_name,price,description,cover_img,relevance_id,sell_number';
        $data['list'] = $this->Mcombo->get_lists($fields, $where, ['sort' => 'desc'], $size, ($page-1)*$size);
        //var_dump($this->db->last_query());die;
        $data_count = $this->Mcombo->count($where);
        //查询套餐下包含的菜谱
        if($data['list']){
            foreach ($data['list'] as $k => $v){
                $relevance_id['id'] =explode(',', $v['relevance_id']);
                //重新组装
                $data['list'][$k]['foods'][] = $this->Mfoods->get_lists('foods_name,cover_img', ['in'=>$relevance_id ]);
            }
            
            //分页
            $urls=[];
            if(!empty($data['names'])){
                $urls['name'] = $data['names'];
            }
            if(!empty($cate_id)){
                $urls['combo_cate_id'] = $cate_id;
            }
            if(!empty($update_time)){
                $urls['time'] = $update_time;
            }
            $this->pageconfig['base_url'] = "/combo/index?".http_build_query($urls);
            $this->pageconfig['total_rows'] = $data_count;
            $this->pagination->initialize($this->pageconfig);
            $data['pagestr'] = $this->pagination->create_links(); // 分页信息
        }
        $data['catename'] = $this->Mcombocate->get_lists('id,name', ['is_del' => 0], ['sort' => 'DESC']);
        $this->load->view('combo/index', $data);
    }
    
    /**
     * 套餐添加
     * @author yonghua@gz-zc.cn
     */
    public function add()
    {
        $data = $this->data;
        $data['combo'] = $this->Mcombocate->get_lists('id,name', ['is_del' => 0], ['sort' => 'DESC']);
        $data['title'] = ['套餐管理','添加套餐'];
        if(IS_POST){
            $add_data['combo_cate_id'] = (int) $this->input->post('combo_cate_id', TRUE);
            $add_data['combo_name'] = trim($this->input->post('combo_name', TRUE));
            $add_data['description'] = trim($this->input->post('description', TRUE));
            $add_data['price'] = (int) $this->input->post('price', TRUE);
            $add_data['cover_img'] = trim($this->input->post('img_url', TRUE));
            $add_data['relevance_id'] = $this->input->post('relevance_id', TRUE);
            $add_data['favorable'] = (int) $this->input->post('favorable', TRUE);
            $add_data['is_today'] = (int) $this->input->post('is_today', TRUE);
            $add_data['is_show'] = (int) $this->input->post('is_show', TRUE);
            $add_data['sort'] = (int) $this->input->post('is_today', TRUE);
            $add_data['create_time'] = date("Y-m-d H:i:s");
            $add_data['update_time'] = date("Y-m-d H:i:s");
            $add_data['create_admin'] = $data['userInfo']['id'];
            $add_data['update_admin'] = $data['userInfo']['id'];
            $add = $this->Mcombo->create($add_data);
            if($add){
                $this->success('添加成功', '/combo');
            }else{
                $this->error('操作是失败');
            }
        }
        $data['foods'] = $this->Mfoods->get_lists('id,foods_name,cover_img', ['is_today' => 1, 'is_del' => 0, 'is_show' => 1], ['sort' => 'desc']);
        $this->load->view('combo/add', $data);
    }
    
    public function edit($id='')
    {
        $data = $this->data;
        $data['title'] = ['套餐管理','编辑套餐'];
        if(IS_POST){
            $ids = (int) $this->input->post('id', TRUE);
            $up_data['combo_cate_id'] = (int) $this->input->post('combo_cate_id', TRUE);
            $up_data['combo_name'] = trim($this->input->post('combo_name', TRUE));
            $up_data['description'] = trim($this->input->post('description', TRUE));
            $up_data['price'] = (int) $this->input->post('price', TRUE);
            $up_data['cover_img'] = trim($this->input->post('img_url', TRUE));
            $up_data['relevance_id'] = $this->input->post('relevance_id', TRUE);
            $up_data['favorable'] = (int) $this->input->post('favorable', TRUE);
            $up_data['is_today'] = (int) $this->input->post('is_today', TRUE);
            $up_data['is_del'] = (int) $this->input->post('is_del', TRUE);
            $up_data['sort'] = (int) $this->input->post('is_today', TRUE);
            $up_data['update_time'] = date("Y-m-d H:i:s");
            $up_data['update_admin'] = $data['userInfo']['id'];
            $up = $this->Mcombo->update_info($up_data, ['id' => $ids]);
            if($up){
                $this->success('修改成功', '/combo');
            }else{
                $this->error('操作是失败');
            }
        }
        $data['cate'] = $this->Mcombocate->get_lists('id,name', ['is_del' => 0], ['sort' => 'desc']);
        $data['info'] = $this->Mcombo->get_one('*', ['id'=>$id, 'is_del' => 0]);
        $data['foods'] = $this->Mfoods->get_lists('id,foods_name,cover_img', ['is_today' => 1, 'is_del' => 0, 'is_show' => 1], ['sort' => 'desc']);
        $this->load->view('combo/edit', $data);
    }
    
    /**
     * 分类列表
     * @author yonghua@gz-zc.cn
     */
    public function cate()
    {
        $data = $this->data;
        $data['title'] = ['套餐分类'];
        $name = trim($this->input->get('name', TRUE));
        if(!empty($name)){
            $where['name'] = $name;
            $data['names'] = $name;
        }
        $where['is_del'] = 0;
        $data['list'] = $this->Mcombocate->get_lists('*', $where, ['sort'=>'DESC']);
        $this->load->view('combo/cate', $data);
    }
    
    /**
     * 添加分类
     * @author yonghua@gz-zc.cn
     */
    public function cateadd()
    {
        $data = $this->data;
        $data['title'] = ['套餐分类','添加套餐'];
        if(IS_POST){
            $add_data['name'] =trim($this->input->post('name', TRUE));
            if(empty($add_data['name'])){
                $this->return_json(['msg' => '套餐名称不能为空']);
            }
            $count = $this->Mcombocate->count(array('is_del'=>0,'name'=>$add_data['name']));
            if($count){
                $this->return_json(array("msg"=>'套餐名称已经存在'));
            }
            $add_data['sort'] =(int) $this->input->post('sort', TRUE);
            $add_data['is_del'] =(int) $this->input->post('is_del', TRUE);
            $add = $this->Mcombocate->create($add_data);
            if($add){
                $this->return_json(['code' => 1, 'msg' => '操作成功！']);
            }else{
                $this->return_json(['msg' => '操作失败！']);
            }
        }
        $this->load->view('combo/cateadd', $data);
    }
    
     /**
     * 删除分类
     */
    public function del($id = 0 )
    {
        $this->Mcombocate->update_info(array("is_del"=>1),array("id"=>$id)) ;
        $this->success("操作成功","/combo/cate");
    }
    
    /**
     * 编辑分类
     * @author yonghua@gz-zc.cn
     */
    public function cateedit($id='')
    {
        $data = $this->data;
        $data['title'] = ['套餐分类','编辑套餐'];
        $data['info'] = $this->Mcombocate->get_one('*',['id' => $id]);
        if(IS_POST){
            $ids =(int) $this->input->post('id', TRUE);
            $add_data['name'] =trim($this->input->post('name', TRUE));
            if(empty($add_data['name'])){
                $this->return_json(['msg' => '分类名称不能为空']);
            }
            $add_data['sort'] =(int) $this->input->post('sort', TRUE);
            if(!is_int($add_data['sort']) && $add_data['sort'] < 0){
                $this->return_json(['msg' => '排序必须为数字或不能小于零']);
            }
            $add_data['is_del'] =(int) $this->input->post('is_del', TRUE);
            unset($add_data['id']);
            $add = $this->Mcombocate->update_info($add_data, ['id' => $ids]);
            if($add){
                $this->return_json(['code' => 1, 'msg' => '操作成功！']);
            }else{
                $this->return_json(['msg' => '操作失败！']);
            }
        }
        $this->load->view('combo/cateedit', $data);
    }
    
    
    
    /**
     * 校验分类是否存在
     * nengfu@gz-zc.cn
     */
    public function  check_exists(){
        if($this->input->is_ajax_request())
        {
            $name =  $this->input->post("name",true);
            $count = $this->Madmins->count(array('is_del'=>1,'name'=>$name));
    
            if($count){
                $this->return_json(array("code"=>0));
            }else{
                $this->return_json(array("code"=>1));
            }
    
        }
    }
    
}