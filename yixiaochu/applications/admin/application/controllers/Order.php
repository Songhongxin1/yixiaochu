<?php

/**
 * 订单管理
 * @author cahokai@gz-zc.cn
 */
class Order extends MY_Controller
{

    private $pagesize = 10;

    public function __construct()
    {
        parent::__construct();
        
        $this->load->model(array(
            'Model_order' => 'Morder',
            'Model_foods' => 'Mfoods',
            'Model_combo' => 'Mcombo',
            'Model_user' => 'Muser',
            'Model_user_addr' => 'Museraddr',
            'Model_order_detail' => 'Morderdetail',
            'Model_area' => 'Marea'
        ));
        
        $this->load->library('pagination');
        $this->pageconfig = C('page.config');
    }

    /**
     * 订单列表
     *
     * @author chaokai@gz-zc.cn
     */
    public function index()
    {
        $data = $this->data;
        $data['title'] = array(
            '订单管理',
            '列表'
        );
        $data['status'] = C('order.status');
        
        $this->load->view('order/index', $data);
    }

    /**
     * ajax获取订单列表
     *
     * @author chaokai@gz-zc.cn
     */
    public function get_list()
    {
        $status = intval($this->input->post('status'));
        $time = $this->input->post('time');
        $page = $this->input->get_post('p') ?  : 1;
        
        $where = array();
        if ($status) {
            $where['status'] = $status;
        }
        $time_num = strtotime($time);
        if ($time_num && $time_num != - 1) {
            $where['create_time >'] = $time;
            $where['create_time <='] = date('Y-m-d H:i:s', $time_num + 3600 * 24);
        }
        
        $data = $this->Morder->get_list($where);
        
        $this->pageconfig['base_url'] = '/order/get_list';
        $this->pageconfig['total_rows'] = $data['count'];
        $this->pagination->initialize($this->pageconfig);
        $data['pagestr'] = $this->pagination->create_links();
        
        $this->return_success($data);
    }
    
    /**
     * 手动添加订单
     *
     * @author yonghua@gz-zc.cn
     */
    public function add()
    {
        $data = $this->data;
        if(IS_POST){
            $phone = (int) $this->input->post('user_phone', TRUE);
            //判断该手机号是否在会员数据库中存在
            $res = $this->Muser->get_one('id', ['user_phone' => $phone]);
            if($res){
                $user_id = $res['id'];
            }
            //如果不存在，则向会员表里添加新用户
            $this->db->trans_begin(); // 开启事物
            $add['user_name'] = trim($this->input->post('user_name', TRUE));
            $add['user_phone'] = trim($this->input->post('user_phone', TRUE));
            $addr['area'] = trim($this->input->post('area', TRUE));
            $addr['bus_area'] = trim($this->input->post('bus_area', TRUE));
            $addr['addr_name'] = trim($this->input->post('addr_name', TRUE));
            $addr['user_name'] = trim($this->input->post('user_name', TRUE));
            $addr['addr_phone'] = trim($this->input->post('user_phone', TRUE));
            $ids = $this->input->post('ids', TRUE);
            $order_type = (int) $this->input->post('order_type', TRUE);
            if (! $res) {
                // 添加新用户
                $add['create_time'] = date("Y-m-d H:i:s");
                $add['update_time'] = date("Y-m-d H:i:s");
                $user_id = $this->Muser->create($add);
                // 为当前的用户创建一个收货地址 $user_id为当前被创建的用户id
                $addr['user_id'] = $user_id;
                $addr['create_time'] = date("Y-m-d H:i:s");
                $addr['update_time'] = date("Y-m-d H:i:s");
                // 首次创建收货地址，是默认的收货地址
                $addr['is_default'] = 1;
                //$ret为当前收货地址的ID
                $newaddr = 1;
                $addr_id = $this->Museraddr->create($addr);
                if (! $addr_id) {
                    $this->order_error('添加收货地址失败！');
                }
            }
            $user_id = $res['id'] ? $res['id'] : $addr_id;
            if(!isset($addr_id)){
                $user_addr = $this->Museraddr->get_one('id', ['is_default' => 1, 'user_id' => $user_id]);
            }
            $addr_id = $user_addr['id'] ? $user_addr['id'] : $addr_id;
            $id = array_keys($ids);
            //根据类型计算订单价格
            if($order_type == 1){
                $info = $this->Mcombo->get_lists('id,price', ['in' => array('id' => $id)]);
                $total_price = '';
                foreach ($info as $k => $v) {
                    foreach ($ids as $kk => $vv) {
                        if ($v['id'] == $kk) {
                            $total_price += $v['price'] * $vv;
                        }
                    }
                }
            }else{
                $info = $this->Mfoods->get_lists('id,now_price', ['in' => array('id' => $id)]);
                $total_price = '';
                foreach ($info as $k => $v) {
                    foreach ($ids as $kk => $vv) {
                        if ($v['id'] == $kk) {
                            $total_price += $v['now_price'] * $vv;
                        }
                    }
                }
            }
            $order_data['pid'] = 0;
            // 生成订单编号
            $order_data['order_number'] = 'yxc' . date('YmdHis') . mt_rand(100, 999999);
            $order_data['create_id'] = $user_id;
            $order_data['need_pay'] = $total_price;
            $order_data['pay_user_id'] = $user_id;
            $order_data['pay_type'] = trim($this->input->post('pay_type', TRUE));
            $order_data['order_type'] = $order_type;
            $order_data['addr_id'] = $addr_id;
            $order_data['status'] = 1;
            $order_data['create_time'] = date("Y-m-d H:i:s");
            // $add_order为生成的订单ID
            $add_order = $this->Morder->create($order_data);
            if (! $add_order) {
                $this->order_error('生成订单失败！');
            }
            
            // 生成订单详情
            $order_datail['addr'] = $addr['area'] . $addr['bus_area'] . $addr['addr_name'];
            if($order_type == 1){
                // 生成订单详情
                $order_datail['order_id'] = $add_order;
                $order_datail['menus_id'] = $id['0'];
                // 查询套餐关联的菜谱id
                $foods = $this->Mcombo->get_one('relevance_id,combo_name,cover_img', [
                    'id' => $id['0']
                ]);
                $order_datail['foods_id'] = $foods['relevance_id'];
                $order_datail['buy_number'] = $ids[$id[0]];
                $order_datail['order_name'] = $foods['combo_name'];
                $order_datail['cover_img'] = $foods['cover_img'];             
                $order_datail['pay_price'] = $total_price;
                $order_datail['create_time'] = date("Y-m-d H:i:s");
                $order_datail['update_time'] = date("Y-m-d H:i:s");
                $f = $this->Morderdetail->create($order_datail);
            }else{
                foreach ($id as $k => $v) {
                    $order_datail['order_id'] = $add_order;
                    $order_datail['menus_id'] = $v;
                    $foods = $this->Mfoods->get_one('foods_name,now_price,cover_img', [
                        'id' => $v
                    ]);
                    $order_datail['foods_id'] = $v;
                    $order_datail['order_name'] = $foods['foods_name'];
                    $order_datail['cover_img'] = $foods['cover_img'];
                    $order_datail['buy_number'] = $ids[$v];
                    $order_datail['pay_price'] = $foods['now_price'] * $ids[$v];
                    $order_datail['create_time'] = date("Y-m-d H:i:s");
                    $order_datail['update_time'] = date("Y-m-d H:i:s");
                    $f = $this->Morderdetail->create($order_datail);
                } 
            }
            $this->order_success('添加成功！');
        }
        //post end
        $data['title'] = ['订单管理','手动添加订单'];
        $data['foods'] = $this->Mfoods->get_lists('id,foods_name,cover_img', ['is_today' => 1,'is_del' => 0,'is_show' => 1], ['sort' => 'desc']);
        $data['combo'] = $this->Mcombo->get_lists('id,combo_name,cover_img', ['is_today' => 1,'is_del' => 0,'is_show' => 1], ['sort' => 'desc']);
        // 读取地区
        $data['area'] = $this->Marea->get_lists('name', ['pid' => 0]);
        $this->load->view('order/hand_add', $data);
    }
    
    public function get_bus_area()
    {
        $name = trim($this->input->get('name', TRUE));
        // 查找地区的pid
        $res = $this->Marea->get_one('id', [
            'name' => $name
        ]);
        // 返回该pid下的所有商圈
        $bus_area = $this->Marea->get_lists('name', [
            'pid' => $res['id']
        ]);
        if ($bus_area) {
            $this->return_json($bus_area);
        } else {
            $this->return_json(FALSE);
        }
    }

    public function order_error($msg = '')
    {
        $this->db->trans_rollback();
        // $this->db->trans_off();
        $this->error($msg);
    }

    public function order_success($msg = '')
    {
        $this->db->trans_commit();
        // $this->db->trans_off();
        $this->success($msg, '/order');
    }

    /**
     * 订单详情
     *
     * @author chaoki@gz-zc.cn
     */
    public function info($id)
    {
        $id = intval($id);
        ! $id && die('参数错误');
        
        $data['info'] = $this->Morder->get_info($id);
        
        $this->load->view('order/ajax_info', $data);
    }

    /**
     * 设置订单状态，删除/发货
     *
     * @author chaokai@gz-zc.cn
     */
    public function set()
    {
        if (IS_POST) {
            $key = $this->input->post('key');
            $value = intval($this->input->post('value'));
            $id = intval($this->input->post('id'));
            ! $value && ! $id && $this->return_failed('参数错误');
            
            $post_data = array(
                $key => $value
            );
            $where = array(
                'id' => $id
            );
            
            if ($this->Morder->update_info($post_data, $where)) {
                $this->return_success();
            } else {
                $this->return_failed('操作失败');
            }
        }
    }
}

