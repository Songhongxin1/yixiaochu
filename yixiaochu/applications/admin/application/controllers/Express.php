<?php
/**
 * 配送员管理
 * @author chaokai@gz-zc.cn
 */
class Express extends MY_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array (
            'Model_express' => 'Mexpress'
        ));
        // 表单验证类
        $this->load->library('form_validation');
    }

    /**
     * 列表页
     * @author chaokai@g-zc.cn
     */
    public function index() {
        $data = $this->data;
        $data['title'] = array (
            '配送员管理',
            '列表'
        );
        
        $data['list'] = $this->Mexpress->get_list();
        
        $this->load->view('express/index', $data);
    }

    /**
     * 添加
     * @author choakai@gz-zc.cn
     */
    public function add() {
        $data = $this->data;
        
        if (IS_POST) {
            $this->form_validation->set_rules('name', '账户名', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            $this->form_validation->set_rules('username', '姓名', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            $this->form_validation->set_rules('password', '密码', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            $this->form_validation->set_rules('repassword', '重复密码', 'trim|required|matches[password]', array (
                'reuqired' => '%s不能为空',
                'matches' => '两次输入密码不一致'
            ));
            $this->form_validation->set_rules('mobile', '手机号', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            
            // 手机号验证
            if (! preg_match(C('regular_expression.mobile'), $this->input->post('mobile'))) {
                $this->error('手机号格式错误');
            }
            if ($this->form_validation->run() == false) {
                $this->error(validation_errors());
            }
            
            $post_data = $this->input->post();
            $post_data['create_time'] = $post_data['update_time'] = date('Y-m-d H:i:s');
            $post_data['create_admin'] = $post_data['update_admin'] = $data['userInfo']['id'];
            $post_data['password'] = md5($post_data['password']);
            unset($post_data['repassword']);
            
            if ($this->Mexpress->create($post_data)) {
                $this->success('操作成功', '/express');
            } else {
                $this->error('操作失败');
            }
        }
        
        $data['title'] = array (
            '配送员管理',
            '添加配送员'
        );
        
        $this->load->view('express/add', $data);
    }

    /**
     * 修改
     * @author chaokai@g-zc.cn
     */
    public function modify($id) {
        $id = intval($id);
        ! $id && $this->error('参数错误');
        $data = $this->data;
        $data['title'] = array (
            '配送员管理',
            '修改配送员信息'
        );
        
        if (IS_POST) {
            $this->form_validation->set_rules('name', '账户名', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            $this->form_validation->set_rules('username', '姓名', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            $this->form_validation->set_rules('password', '密码', 'trim');
            $this->form_validation->set_rules('repassword', '重复密码', 'trim|matches[password]', array (
                'matches' => '两次输入密码不一致'
            ));
            $this->form_validation->set_rules('mobile', '手机号', 'trim|required', array (
                'required' => '%s不能为空'
            ));
            
            // 手机号验证
            if (! preg_match(C('regular_expression.mobile'), $this->input->post('mobile'))) {
                $this->error('手机号格式错误');
            }
            if ($this->form_validation->run() == false) {
                $this->error(validation_errors());
            }
            
            $post_data = $this->input->post();
            $post_data['update_time'] = date('Y-m-d H:i:s');
            $post_data['update_admin'] = $data['userInfo']['id'];
            unset($post_data['repassword']);
            // 密码框为空不更改密码
            if ($post_data['password'] == '') {
                unset($post_data['password']);
            } else {
                $post_data['password'] = md5($post_data['password']);
            }
            
            if ($this->Mexpress->update_info($post_data, array (
                'id' => $id
            ))) {
                $this->success('操作成功', '/express');
            } else {
                $this->error('操作失败');
            }
        }
        
        $data['info'] = $this->Mexpress->get_info($id);
        $this->load->view('express/modify', $data);
    }

    /**
     * 设置为禁止登陆或删除
     * @author chaokai@gz-zc.cn
     */
    public function set($id, $k, $v) {
        $id = intval($id);
        ! $id && $this->return_failed('参数错误');
        
        $v_limit = array (
            0,
            1
        );
        if (! in_array($v, $v_limit)) {
            $this->return_failed('值不被允许');
        }
        
        if ($this->Mexpress->update_info(array (
            $k => $v
        ), array (
            'id' => $id
        ))) {
            $this->return_success();
        } else {
            $this->return_failed('操作失败');
        }
    }
}
