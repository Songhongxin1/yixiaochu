<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 菜品管理
 * @author chaokai@gz-zc.cn
 */
class Foods extends MY_Controller {
    private $pagesize = 30;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array (
            'Model_foods' => 'Mfoods',
            'Model_foods_type' => 'Mfoods_type'
        ));
        
        $this->pageconfig = C('page.config');
        $this->load->library('Pagination');
        // 表单验证类
        $this->load->library('form_validation');
    }

    /**
     * 首页/列表页
     */
    public function index() {
        $data = $this->data;
        $data['title'] = array (
            '菜品管理',
            '列表'
        );
        
        $page = $this->input->get('p') ?  : 1;
        $data['page'] = $page;
        $offset = $this->pagesize * ($page - 1);
        $where = array ();
        $order_by = array (
            'sort' => 'desc'
        );
        
        $search_name = trim($this->input->get('foods_name'));
        if ($search_name) {
            $where['like'] = array (
                'foods_name' => $search_name
            );
        }
        
        // 获取列表和总数
        $result = $this->Mfoods->get_list($where, $this->pagesize, $offset, $order_by);
        $data['list'] = $result['list'];
        $data['count'] = $result['count'];
        
        // 分页
        $this->pageconfig['base_url'] = "/foods/index";
        $this->pageconfig['total_rows'] = $data['count'];
        $this->pagination->initialize($this->pageconfig);
        $data['pagestr'] = $this->pagination->create_links();
        
        $this->load->view('foods/index', $data);
    }

    public function add() {
        $data = $this->data;
        $data['title'] = array (
            '菜品管理',
            '添加菜品'
        );
        if (IS_POST) {
            $this->form_validation->set_rules('foods_name', '菜名', 'trim|required|is_unique[t_foods.foods_name]', array (
                'required' => '请输入%s',
                'is_unique' => '该菜名已存在'
            ));
            $this->form_validation->set_rules('cover_img', '封面图', 'trim|required', array (
                'required' => '请上传%s'
            ));
            $this->form_validation->set_rules('food_material', '', 'trim');
            $this->form_validation->set_rules('nutritive_value', '', 'trim');
            $this->form_validation->set_rules('description', '', 'trim');
            $this->form_validation->set_rules('old_price', '原价', 'trim|numeric', array (
                'numeric' => '%s必须为数字'
            ));
            $this->form_validation->set_rules('now_price', '现价', 'trim|numeric', array (
                'numeric' => '%s必须为数字'
            ));
            $this->form_validation->set_rules('type', '分类', 'numeric', array (
                'numeric' => '%s为必选'
            ));
            $this->form_validation->set_rules('sell_number', '已售数量', 'integer', array (
                'integer' => '%s必须为整数'
            ));
            $this->form_validation->set_rules('is_show', '是否显示', 'integer|less_than_equal_to[1]', array (
                'integer' => '%s必须为整数',
                'less_than_equal_to' => '%s不符合要求'
            ));
            $this->form_validation->set_rules('is_today', '是否今日菜品', 'integer|less_than_equal_to[1]', array (
                'integer' => '%s必须为整数',
                'less_than_equal_to' => '%s不符合要求'
            ));
            
            if ($this->form_validation->run() == false) {
                $this->error(validation_errors());
            }
            $post_data = $this->input->post();
            $post_data['create_time'] = $post_data['update_time'] = date('Y-m-d H:i:s');
            $post_data['create_admin'] = $post_data['update_admin'] = $data['userInfo']['id'];
            
            if ($this->Mfoods->create($post_data)) {
                $this->success('操作成功', '/foods/index');
            } else {
                $this->error('操作失败，请重试');
            }
        }
        
        $data['type'] = $this->Mfoods_type->get_list();
        $this->load->view('foods/add', $data);
    }

    /**
     * 修改
     * @author chaokai@gz-zc.nc
     */
    public function modify($id = 0) {
        $id = intval($id);
        ! $id && $this->error('参数错误');
        
        $data = $this->data;
        $data['title'] = array (
            '菜品管理',
            '修改'
        );
        
        if (IS_POST) {
            $this->form_validation->set_rules('foods_name', '菜名', 'trim|required', array (
                'required' => '请输入%s',
                'is_unique' => '该菜名已存在'
            ));
            $this->form_validation->set_rules('cover_img', '封面图', 'trim|required', array (
                'required' => '请上传%s'
            ));
            $this->form_validation->set_rules('food_material', '', 'trim');
            $this->form_validation->set_rules('nutritive_value', '', 'trim');
            $this->form_validation->set_rules('description', '', 'trim');
            $this->form_validation->set_rules('old_price', '原价', 'trim|numeric', array (
                'numeric' => '%s必须为数字'
            ));
            $this->form_validation->set_rules('now_price', '现价', 'trim|numeric', array (
                'numeric' => '%s必须为数字'
            ));
            $this->form_validation->set_rules('type', '分类', 'numeric', array (
                'numeric' => '%s为必选'
            ));
            $this->form_validation->set_rules('sell_number', '已售数量', 'integer', array (
                'integer' => '%s必须为整数'
            ));
            $this->form_validation->set_rules('is_show', '是否显示', 'integer|less_than_equal_to[1]', array (
                'integer' => '%s必须为整数',
                'less_than_equal_to' => '%s不符合要求'
            ));
            $this->form_validation->set_rules('is_today', '是否今日菜品', 'integer|less_than_equal_to[1]', array (
                'integer' => '%s必须为整数',
                'less_than_equal_to' => '%s不符合要求'
            ));
            
            if ($this->form_validation->run() == false) {
                $this->error(validation_errors());
            }
            $post_data = $this->input->post();
            $post_data['update_time'] = date('Y-m-d H:i:s');
            $post_data['update_admin'] = $data['userInfo']['id'];
            
            if ($this->Mfoods->update_info($post_data, array (
                'id' => $id
            ))) {
                $this->success('操作成功', '/foods/index');
            } else {
                $this->error('操作失败，请重试');
            }
        }
        
        $info = $this->Mfoods->get_info($id);
        $data['info'] = $info;
        $data['type'] = $this->Mfoods_type->get_list();
        
        $this->load->view('foods/modify', $data);
    }

    /**
     * 设置今日菜品/删除
     * @author chaokai@gz-zc.cn
     */
    public function set($id, $k, $v) {
        $id = intval($id);
        ! $id && $this->return_failed('参数错误');
        
        $v = intval($v);
        $v_limit = array (
            1,
            0
        );
        if (! in_array($v, $v_limit)) {
            $this->return_failed('参数错误');
        }
        
        $data = array (
            $k => $v
        );
        if ($this->Mfoods->set($id, $data)) {
            $this->return_success();
        } else {
            $this->return_failed('操作失败');
        }
    }

    /**
     * 详情
     * @author chaokai@gz-zc.cn
     */
    public function detail($id) {
        $id = intval($id);
        ! $id && $this->error('参数错误');
        $data = $this->data;
        
        $data['info'] = $this->Mfoods->get_info($id);
        
        $this->load->view('foods/ajax_info', $data);
    }
}