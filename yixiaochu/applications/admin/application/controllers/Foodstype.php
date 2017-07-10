<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 菜品分类管理
 * @author chaokai@gz-zc.cn
 */
class Foodstype extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array (
            'Model_foods_type' => 'Mfoods_type'
        ));
        
        $this->load->library('form_validation');
    }

    /**
     * 列表页
     * @author chaokai@gz-zc.cn
     */
    public function index() {
        $data = $this->data;
        $data['title'] = array (
            '菜品分类管理',
            '列表'
        );
        
        $data['list'] = $this->Mfoods_type->type_list();
        
        $this->load->view('foodstype/index', $data);
    }

    /**
     * 添加
     * @author chaokai@gz-zc.cn
     */
    public function add() {
        $data = $this->data;
        if (IS_POST) {
            $this->form_validation->set_rules('name', '分类名称', 'trim|required|is_unique[t_foods_type.name]', array (
                'required' => '请输入%s',
                'is_unique' => '该类名已存在'
            ));
            if ($this->form_validation->run() == false) {
                $this->return_failed(validation_errors());
            }
            
            $post_data = $this->input->post();
            $post_data['create_time'] = $post_data['update_time'] = date('Y-m-d H:i:s');
            $post_data['create_admin'] = $post_data['update_admin'] = $data['userInfo']['id'];
            
            if ($this->Mfoods_type->create($post_data)) {
                $this->return_success();
            } else {
                $this->return_failed('操作失败');
            }
        }
    }

    /**
     * 修改
     * @author chaokai@gz-zc.cn
     */
    public function edit() {
        $data = $this->data;
        if (IS_POST) {
            $this->form_validation->set_rules('id', '编号', 'trim|required|numeric', array (
                'numeric' => '%s必须为数字'
            ));
            $this->form_validation->set_rules('name', '名称', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            
            if ($this->form_validation->run() == false) {
                $this->return_failed(validation_errors());
            }
            
            $post_data['name'] = $this->input->post('name');
            $post_data['update_time'] = date('Y-m-d H:i:s');
            $post_data['update_admin'] = $data['userInfo']['id'];
            $where = array (
                'id' => $this->input->post('id')
            );
            
            if ($this->Mfoods_type->update_info($post_data, $where)) {
                $this->return_success();
            } else {
                $this->return_failed('操作失败');
            }
        }
    }

    /**
     * 删除
     * @author chaokai@gz-zc.cn
     */
    public function del($id) {
        $id = intval($id);
        ! $id && $this->return_failed('参数错误');
        
        $post_data = array (
            'is_del' => 1
        );
        $where = array (
            'id' => $id
        );
        
        if ($this->Mfoods_type->update_info($post_data, $where)) {
            $this->return_success();
        } else {
            $this->return_failed('操作失败');
        }
    }
}