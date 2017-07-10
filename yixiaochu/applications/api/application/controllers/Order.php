<?php
/**
 * 确认菜单接口
 * @author yonghua@gz-zc.cn
 */
class Order extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_foods'=>'Mfoods',
            'Model_user_addr'=>'Maddr',
            'Model_order' => 'Morder',
            'Model_order_detail' => 'Morderdetail',
            'Model_area' => 'Marea',
            'Model_user' => 'Muser'
        ]);
    }
    
    /**
     * 获得收货地址
     * @author yonghua@gz-zc.cn
     */
    public function get_addr(){
        try {
            $data = $this->data;
            $user = decrypt(trim($this->input->post('user', TRUE)));
            if(!$user['id']){
                $this->return_failed(NULL);
            }
            $fileds = 'id,area,bus_area,addr_name,user_name,addr_phone,is_default';
            $addr = $this->Maddr->get_lists($fileds, ['user_id' => $user['id'], 'is_del' => 0],['is_default' => 'desc']);
            if($addr){
                $data['addr'] = $addr;
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }
            $data['area'] = $this->Marea->get_lists('id,name,pid');
            $this->return_success($data);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    /**
     * 删除用户地址
     * @author yonghua@gz-zc.cn
     */
    public function deladdr(){
        
        try{
            $id = (int) $this->input->post('id', TRUE);
            $user = decrypt(trim($this->input->post('user', TRUE)));
            if(!$user['id']){
                $this->return_success(0);
            }
            $add['is_del'] = 1;
            $res = $this->Maddr->update_info($add, ['id' => $id, 'user_id' => $user['id']]);
            if($res){
                if($res){
                    $this->return_success(1);
                }else{
                    $this->return_success(0);
                }
            }
        } catch(Exception $e){
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 通过订单id获得订单的信息
     * @author yonghua@gz-zc.cn
     */
    public function get_order_info_by_id(){
        try {
            $data = $this->data;
            $user = decrypt(trim($this->input->post('user', TRUE)));
            if(!$user['id']){
                $this->return_failed(NULL);
            }
            $id = (int) $this->input->post('id',TRUE);
            $field = 'id,order_number,create_time,favorable,pay_type,order_type,status,pay_user_id,addr_id';
            $order = $this->Morder->get_one($field, ['id' => $id, 'is_del' => 0, 'create_id' => $user['id']]);
            if(!$order){
                $this->return_failed('null');
            }
            $time = strtotime($order['create_time'])+(60*30);
            $data['end_time'] = date('Y-m-d H:i:s', $time);
            $detail = $this->Morderdetail->get_one('order_name', ['is_del' => 0, 'order_id' => $order['id']]);  
            //查询订单的收货地址
            $addr_id = $order['addr_id'];
            $field = 'area,bus_area,addr_name,user_name,addr_phone';
            $addr = $this->Maddr->get_one($field, ['id' => $addr_id, 'is_del' => 0]);
            $area_ids = [$addr['area'], $addr['bus_area']];
            $area = $this->Marea->get_lists('name', ['in' => ['id'=>$area_ids]]);
            $order['addr_str'] = $area[0]['name'].' '.$area[1]['name'].' '.$addr['addr_name'].' （'.$addr['user_name'].' 收）'.$addr['addr_phone'];
            //查询已经支付的人数和未支付的人数（已支付的取出用户名和头像）
            $taocan = C('order.pay_type.aapay.id');

            if($order['order_type'] == $taocan){
                $pay_info = $this->Morder->get_lists('pay_user_id,status', ['pid' => $id, 'is_del' => 0, 'create_id' => $user['id']]);
                //累加已付款人数与用户的id
                $data['total'] = count($pay_info);//需要支付的人数
                $data['yes'] =0; //已经支付的人数
                $yes_user_id =[];
                foreach ($pay_info as $k => $v){
                    if($v['status'] == 3){
                        $data['yes'] +=1;
                        $yes_user_id[$k] = $v['pay_user_id'];
                    }
                }
                //查看自己是否已经支付
                foreach ($pay_info as $k => $v){
                    if($v['pay_user_id'] == $user['id'] && $v['status'] == C('order.status.wait_send.id')){
                        $data['has_me_pay'] = 1;
                    }else{
                        $data['has_me_pay'] = 0;
                    }
                }
                //如果有支付的，查询支付用户的name和img
                if($yes_user_id > 0){
                    $pay_user = $this->Muser->get_lists('user_name,head_img', ['in' => ['id' => $yes_user_id]]);
                    foreach ($pay_user as $k => $v){
                        $data['pay_user'][$k] = $v;
                        $data['pay_user'][$k]['head_img'] = get_full_img_url($v['head_img']);
                    }
                }
            }else{
                //查询是单人name和img
                $pay_user_id = $order['pay_user_id'];
                $pay_user = $this->Muser->get_lists('user_name,head_img', ['id' => $pay_user_id]);
                foreach ($pay_user as $k => $v){
                    $data['pay_user'][$k] = $v;
                    $data['pay_user'][$k]['head_img'] = get_full_img_url($v['head_img']);
                }
            }

            //查询订单的菜谱信息
            $data['order'] = $order;
            $data['order']['order_name'] = $detail['order_name'];
            $data['config'] = C('order');
            //查询当前套餐包含的菜谱
            $data['foods'] = $this->get_foods_by_order_id($id);
            $this->return_success($data);

        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    

    /**
     * 通过订单id获得包含菜谱的信息
     * @author yonghua@gz-zc.cn
     */
    public function get_foods_by_order_id($id){
        $info = $this->Morderdetail->get_lists('foods_id',['order_id' => $id]);
        $ids = array_column($info, 'foods_id');
        //统计所有的id
        $all_id =[];
        if(count($ids) > 1){
            foreach($ids as $k => $v){
                array_push($all_id, $v);
            }
        }else{
            foreach ($ids as $k => $v){
                foreach (explode(',', $v) as $kk => $vv){
                    array_push($all_id, $vv);
                }
            }
        }
        $all_id = array_unique($all_id);//移除重复
        $field = 'foods_name,cover_img,food_material,nutritive_value,description,sell_number';
        $foods = $this->Mfoods->get_lists($field, ['in'=> ['id' => $all_id]]);
        foreach ($foods as $k => $v){
            $foods[$k] = $v;
            $foods[$k]['cover_img'] = get_full_img_url($v['cover_img']);
        }
        return $foods;
    }
    
}




