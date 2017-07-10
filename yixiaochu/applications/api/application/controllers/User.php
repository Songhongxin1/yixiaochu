<?php
/**
 * 个人中心
 * @author chaokai@gz-zc.cn
 */
class User extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model(array(
            'Model_user' => 'Muser',
            'Model_order' => 'Morder',
            'Model_foods' => 'Mfoods',
            'Model_order_detail' => 'Morderdetail',
            'Model_score_log' => 'Mcorelog',
            'Model_score' => 'Mcore',
            'Model_user_addr' => 'Museraddr',
            'Model_area' => 'Marea'
        ));
        $this->load->library('pagination');
        $this->load->helper('cookie');
        $this->pageconfig = C('page.config');
    }
    
    /**
     * 获取用户信息
     * @author chaokai@gz-zc.cn
     */
    public function info(){
        $data = $this->data;
        if(isset($data['user'])){
            $id = (int)$data['user']['id'];
        }else{
            $id = 0;
        }
        !$id && $this->return_failed('参数错误');
        
        $user_info = $this->Muser->info($id);
        $area = $this->Marea->get_lists('id, name');
        $area = array_column($area, 'name', 'id');
        foreach ($user_info['user_addr'] as $k => $v){
            $user_info['user_addr'][$k]['area_text'] = $area[$v['area']];
            $user_info['user_addr'][$k]['bus_area_text'] = $area[$v['bus_area']];
        }
        $this->return_success($user_info);
    }
    
    /**
     * 会员中心，我的订单
     * @author yonghua@gz-zc.cn
     */
    public function user_order(){
        try {
            $user = decrypt(trim($this->input->post('user', TRUE)));
            if(!$user['id']){
                $this->return_failed(NULL);
            }
            $create_id = $user['id'];
            $data = $this->data;
            $data = $this->get_info($data, $create_id);
            $data['order_status'] = $this->order_status_code();
            $data['order_type'] = C('order.type');
            $data['pay_type'] = C('order.pay_type');
            $this->return_success($data);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 获取订单列表
     * @author yonghua@gz-zc.cn
     * todo get_combo($data)
     */
    private  function get_info($data, $create_id){
        
        $filde = 'id,order_number,need_pay,favorable,pay_type,order_type,create_id,pay_user_id,status';
        $order = $this->Morder->get_lists($filde, ['create_id' => $create_id, 'is_del' => 0, 'pid' => 0], ['create_time' => 'desc']);
        if(!$order){
            return $data;
        }
        $sub_order = $this->Morder->get_lists('id,pid', ['create_id' => $create_id, 'is_del' => 0, 'pid!=' => 0, 'status' => 1], ['create_time' => 'desc']);
        $ids = array_column($order, 'id');//获得当前用户所有的订单id
        //统计出母订单下的子订单未支付的个数
        $sub_order = array_column($sub_order, 'pid', 'id');
        foreach ($order as $k => $v){
            $order[$k]['count'] = 0;
            foreach ($sub_order as $kk => $vv){
                if($v['id'] == $vv){
                    $order[$k]['count'] +=1;
                }
            }
        }
            // 查询订单详情
        $order_detail = $this->Morderdetail->get_lists('id,order_id,foods_id,order_name,pay_price,buy_number', [
            'is_del' => 0,
            'in' => array(
                'order_id' => $ids
            )
        ]);
        if ($order_detail) {
            $foods_ids = array();
            foreach ($order_detail as $k => $v) {
                $foods_ids = array_unique(array_merge($foods_ids, explode(',', $v['foods_id'])));
                $order_detail[$k]['foods_ids'] = explode(',', $v['foods_id']);
            }
            $where = [
                'in' => array(
                    'id' => $foods_ids
                )
            ];
            $foods = $this->Mfoods->get_lists('id,cover_img,foods_name,food_material,old_price,now_price', $where);
            // 拼接img
            foreach ($foods as $k => $v) {
                $foods[$k]['cover_img'] = get_full_img_url($v['cover_img']);
            }
            foreach ($order_detail as $k => $v) {
                foreach ($foods as $key => $value) {
                    if (in_array($value['id'], $v['foods_ids'])) {
                        $order_detail[$k]['foods_detail'][] = $value;
                    }
                }
            }
            
            $data['info'] = $order;
            // 合并订单和订单详情
            foreach ($data['info'] as $ok => $ov) {
                foreach ($order_detail as $ook => $oov) {
                    if ($ov['id'] == $oov['order_id']) {
                        $data['info'][$ok]['foods'][] = $oov;
                    }
                }
            }
        }
        return $data;
    }
    
    /**
     * 获取订单状态
     * @author yonghua@gz-zc.cn
     * todo get_combo($data)
     */
    private function order_status_code(){
        return  C('order.status');
    }
    
    /**
     * 删除订单
     * @author yonghua@gz-zc.cn
     */
    public function del($id=''){
        try {
            $id = (int) $id;
            $user = decrypt(trim($this->input->post('user', TRUE)));
            if(!$user['id']){
                $this->return_failed(NULL);
            }
            //只有当前会员未支付条件下可以可以删除订单
            $status = C('order.status');
            $res = $this->Morder->update_info(['is_del' => 1], ['id' => $id, 'create_id' => $user['id'], 'status' => $status['no_pay']['id']]);
            if(!$res){
                $this->return_success(['code' => 0]);
            }
            $this->return_success(['code' => 1]);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 会员中心，我的积分
     * @author yonghua@gz-zc.cn
     */
    public function my_point(){
        
        try {
            $user = decrypt(trim($this->input->post('user', TRUE)));
            $page =  intval(trim($this->input->post("page", TRUE))) ?  :1;
            $jia = intval(trim($this->input->post("jia", TRUE)));
            $jian = intval(trim($this->input->post("jian", TRUE)));
            if(!$user['id']){
                $this->return_failed(NULL);
            }
            if($jia == 1){
                $where['spend_score >'] = 0;
            }
            if($jian == 1){
                $where['spend_score <'] = 0;
            }
            $size = $this->pageconfig['per_page'];
            $where['user_id'] = $user['id'];
            $field = 'cover_img,detail_name,spend_score,info,create_time';
            $data['list'] = $this->Mcorelog->get_lists($field, $where, ['create_time' => 'desc'], $size, ($page-1)*$size);
            $count = $this->Mcorelog->count($where);
            if($data['list']){
                //拼装imgurl
                foreach ($data['list'] as $k => $v){
                    $data['list'][$k] = $v;
                    if($v['cover_img'])
                        $data['list'][$k]['cover_img'] = get_full_img_url($v['cover_img']);
                }
                //link

                $data['link'] = '';
                    for($i=$page; ($i<=(ceil($count/$size)) && $i <= $page+4 ); $i++){
                         $data['link'][$i] = $i;
                }

                $data['count'] = ceil($count/$size);
                $this->return_success($data);
            }
            $this->return_failed(NULL);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 会员中心，我的积分
     * @author yonghua@gz-zc.cn
     */
    public function add_user_addr(){
        try {
            $user = decrypt(trim($this->input->post('user', TRUE)));
            if(!$user['id']){
                $this->return_failed(['code' => -1 ,'msg' => '你还没有登陆']);
            }
            $data['user_id'] = $user['id'];
            $data['area'] = (int) $this->input->post('user_area',TRUE);
            $data['bus_area'] = (int) $this->input->post('user_bus_area',TRUE);
            $data['addr_name'] = trim($this->input->post('user_addr',TRUE));
            $data['user_name'] = trim($this->input->post('user_name',TRUE));
            $data['addr_phone'] = trim($this->input->post('phone',TRUE));
            if(!preg_match(C('regular_expression.mobile'), $data['addr_phone'])){
                $this->return_failed(['code' => -1 ,'msg' => '手机号格式不正确']);
            }
            $data['is_default'] = (int) $this->input->post('is_default',TRUE);
            $data['create_time'] = date('Y-m-d H:i:s');
            $data['update_time'] = date('Y-m-d H:i:s');
            $res = $this->Museraddr->create($data);
            if(!$res){
                $this->return_failed(['code' => 0 ,'msg' => '添加失败']);
            }
            $this->return_success(['code' => 1 ,'msg' => '添加成功']);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 个人资料修改
     * @author louhang@gz-zc.cn
     */
    public function save_info(){
        try{
            $data = $this->input->post();
            
            $user = decrypt(trim(isset($data['user']) ? $data['user'] : ''));
            unset($data['user']);
            if(!$user['id']){
                $this->return_failed('用户不存在');
            }
            if($data['nickname'] == ''){
                $this->return_failed('昵称不能为空!');
            }
            //匹配2~4位的中文汉字
            if(!preg_match("/^[\x{4e00}-\x{9fa5}]{2,4}$/u", $data['user_name']))
            {
                $this->return_failed('姓名格式不正确');
            }
            
            $user_id = (int)$user['id'];
            $oldData = $this->Muser->info($user_id);
            if($data['head_img'] == '' || $data['head_img'] == $oldData['head_img_url']){
                unset($data['head_img']);
            }
            
            if($this->Muser->update_info($data, array('id' => $user_id))){
                $this->return_success('', '更改成功！');
            }else{
                $this->return_failed('更改失败, 请勿重复更改!');
            }
            
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 修改密码
     * @author louhang@gz-zc.cn
     */
    public function change_password(){
        try{
            $data = array();
            $data['user'] = addslashes(strip_tags($this->input->post('user', TRUE)));
            $data['old_password'] = addslashes(strip_tags($this->input->post('old_password', TRUE)));
            $data['new_password'] = addslashes(strip_tags($this->input->post('new_password', TRUE)));
            $data['re_new_password'] = addslashes(strip_tags($this->input->post('re_new_password', TRUE)));
            $data['tel_verify'] = addslashes(strip_tags($this->input->post('tel_verify', TRUE)));
            
            $user = decrypt(trim(isset($data['user']) ? $data['user'] : ''));
            unset($data['user']);
            if(!$user['id']){
                $this->return_failed('用户不存在');
            }
            if($data['old_password'] == '' || $data['new_password'] == ''){
                $this->return_failed('密码不能为空!');
            }
            if($data['new_password'] != $data['re_new_password']){
                $this->return_failed('两次输入的密码不一致');
            }
            if($data['new_password'] == $data['old_password']){
                $this->return_failed('更改失败, 新密码不能和旧密码相同!');
            }
            if(empty($data['tel_verify']))
            {
                $this->return_failed('手机验证码不能为空！');
            }
            
            $user_id = (int)$user['id'];
            $data['user_phone'] = $user['user_phone'];
            $password = $this->Muser->get_one('password', array('id' => $user_id));
            if(get_encode_pwd($data['old_password']) != $password){
                $this->return_failed('旧密码输入错误');
            }

            $sms_config = C('sms.sms_config_huaxing');
            $check_tel_verify = $this->Mverify->get_one(array('code,add_time'), array('phone_number' => $data['user_phone']));
             
            if(isset($check_tel_verify['code']))
            {
                if ((time() - $check_tel_verify['add_time']) > $sms_config['nvalidation_time'])
                {
                    $this->return_failed('手机验证码过期！');
                }
                if ($check_tel_verify['code'] != $data['tel_verify'])
                {
                    $this->return_failed('手机验证码错误！');
                }
                 
            }
            else
            {
                $this->return_failed('手机验证码错误！');
            }
            
            
            $new_password = get_encode_pwd($data['new_password']);
            if($this->Muser->update_info(array('password' => $new_password), array('id' => $user_id))){
                $this->return_success('', '更改成功！');
            }else{
                $this->return_failed('更改失败, 请勿重复更改!');
            }
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 送餐地址修改
     * @author louhang@gz-zc.cn
     */
    public function save_address(){
        try{
            $nowTime = time();
            $data = $this->input->post();
            $user = decrypt(trim(isset($data['user']) ? $data['user'] : ''));

            if(!isset($user['id'])){
                $this->return_failed('用户不存在');
            }
            $data['user_id'] = (int)$user['id'];

            if($data['addr_name'] == ''){
                $this->return_failed('收货地址不能为空!');
            }
            if($data['addr_phone'] == ''){
                $this->return_failed('收货人联系电话不能为空!');
            }         
            
            //若用户更改默认地址,先将用户之前的默认地址变为清除
            if($data['is_default'] == 1){
                $this->Museraddr->update_info(array('is_default' => 0), array('user_id' => $data['user_id'], 'is_default' => 1));
            }
            
            $addressId = (int)$data['id'];
            //获取新的地址详情
            
            unset($data['user'], $data['id'], $data['is_del']);
            
            //address表中id为-1时，代表没有该记录，新建收货地址
            if($addressId == -1){
                $data['create_time'] = $nowTime;
                $data['update_time'] = $nowTime;
                if($this->Museraddr->create($data)){
                    $user_addr = $this->Muser_addr->get_lists('id, user_id, bus_area, area, addr_name, user_name, addr_phone, is_default', array('user_id' => $data['user_id'], 'is_del' => 0));
                    $area = $this->Marea->get_lists('id, name');
                    $area = array_column($area, 'name', 'id');
                    foreach ($user_addr as $k => $v){
                        $user_addr[$k]['area_text'] = $area[$v['area']];
                        $user_addr[$k]['bus_area_text'] = $area[$v['bus_area']];
                    }
                    $this->return_success($user_addr, '添加成功！');
                }else{
                    $this->return_failed('添加失败, 请稍后再试!');
                }
            }else{
                $data['update_time'] = $nowTime;
                if($this->Museraddr->update_info($data, array('id' => $addressId))){
                    $user_addr = $this->Muser_addr->get_lists('id, user_id, bus_area, area, addr_name, user_name, addr_phone, is_default', array('user_id' => $data['user_id'], 'is_del' => 0));
                    $area = $this->Marea->get_lists('id, name');
                    $area = array_column($area, 'name', 'id');
                    foreach ($user_addr as $k => $v){
                        $user_addr[$k]['area_text'] = $area[$v['area']];
                        $user_addr[$k]['bus_area_text'] = $area[$v['bus_area']];
                    }
                    $this->return_success($user_addr, '更改成功！');
                }else{
                    $this->return_failed('更改失败, 请勿重复更改!');
                }
            }
    
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    
    /**
     * 送餐地址删除
     * @author louhang@gz-zc.cn
     */
    public function del_address(){
        try{
            $nowTime = time();
            $data = $this->input->post();
            $user = decrypt(trim(isset($data['user']) ? $data['user'] : ''));
    
            if(!isset($user['id'])){
                $this->return_failed('用户不存在');
            }
            $data['user_id'] = (int)$user['id'];
    
            $addressId = (int)$data['id'];
            unset($data['user'], $data['id']);
            //address表中id为-1时，代表没有该记录，新建收货地址
            $data['update_time'] = $nowTime;
            if($this->Museraddr->update_info(array('is_del' => 1), array('id' => $addressId))){
                 $user_addr = $this->Muser_addr->get_lists('id, user_id, bus_area, area, addr_name, user_name, addr_phone, is_default', array('user_id' => $data['user_id'], 'is_del' => 0));
                 $area = $this->Marea->get_lists('id, name');
                 $area = array_column($area, 'name', 'id');
                 foreach ($user_addr as $k => $v){
                     $user_addr[$k]['area_text'] = $area[$v['area']];
                     $user_addr[$k]['bus_area_text'] = $area[$v['bus_area']];
                 }
                 $this->return_success($user_addr, '删除成功！');
            }else{
                $this->return_failed('删除失败!');
            }
    
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 送餐地址区域列表
     * @author louhang@gz-zc.cn
     */
    public function get_bus_area(){
        try{
            if($bus_area = $this->Marea->get_lists('id, name', array('pid' => 0))){
                $this->return_success($bus_area, 'bus_area！');
            }else{
                $this->return_failed('获取失败!');
            }

        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    
    /**
     * 送餐地址二级区域
     * @author louhang@gz-zc.cn
     */
    public function get_area(){
        try{
            $data = $this->input->post();
            $bus_area_id = isset($data['bus_area_id']) ? (int)$data['bus_area_id'] : 1;
            if($bus_area = $this->Marea->get_lists('id, name', array('pid' => $bus_area_id))){
                $this->return_success($bus_area, '送餐地址二级区域！');
            }else{
                $this->return_failed('暂不支持送餐至该地区!');
            }
    
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }
    

    /**
     * 所有送餐地址区域
     * @author louhang@gz-zc.cn
     */
    public function get_all_area(){
        try{
            
            if($all_area = $this->Marea->get_lists('id, name')){
                $all_area = array_column($all_area  , 'name','id');
                $this->return_success($all_area, '所有送餐地址');
            }else{
                $this->return_failed('暂无支持送餐地区!');
            }
    
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    }

    
}


















