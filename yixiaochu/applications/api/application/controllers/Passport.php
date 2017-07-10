<?php
/**
 * 登录注册
 * @author chaokai@gz-zc.cn
 */
class Passport extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model(array(
            'Model_user' => 'Muser',
            'Model_tel_verify' => 'Mverify'
        ));
        
        $this->load->library('form_validation');
    }
    
    public function login(){
        $this->form_validation->set_rules('name', '账号', 'trim|required', array('required' => '%s不能为空'));
        $this->form_validation->set_rules('password', '密码', 'trim|required', array('required' => '%s不能为空'));
        
        if($this->form_validation->run() == false){
            $this->return_failed(validation_errors());
        }
        $post_data = $this->input->post();
        $post_data['password'] = get_encode_pwd($post_data['password']);
        $post_data['user_phone'] = $post_data['name'];
        unset($post_data['name']);
        
        $result = $this->Muser->get_one('id,user_phone,user_name', $post_data);
        
        if($result){
            $result_data['user'] = encrypt(array('id' => $result['id'], 'user_phone' => $result['user_phone']));
            $result_data['userinfo'] = array($result['user_name']);
            $this->return_success($result_data);
        }else{
            $this->return_failed('用户名或密码错误');
        }
    }

    
    /**
     * 注册处理
     *
     * @return multitype:string
     */
    public  function check_reg(){
        
        $time = date('Y-m-d H:i:s' ,time());
        $data = array();
        $data['nickname'] = addslashes(strip_tags($this->input->post('nickname', TRUE)));
        $data['user_phone'] = (int)$this->input->post('user_phone', TRUE);
        $data['tel_verify'] = addslashes(strip_tags($this->input->post('tel_verify', TRUE)));
        $data['password'] = addslashes(strip_tags($this->input->post('password', TRUE)));
        $data['repassword'] = addslashes(strip_tags($this->input->post('rePassword', TRUE)));
        
        if(empty($data['user_phone']))
        {
            $this->return_failed('手机号不能为空！');
        }
        
        if(!preg_match(C('regular_expression.mobile'), $data['user_phone']))
        {
            $this->return_failed('手机号格式不对！');
        }
        
        $check_tel = $this->Muser->get_one(array('id'), array('user_phone' => $data['user_phone']));
        if($check_tel)
        {
            $this->return_failed('手机号已被注册！');
        }
        
        /* $check_nickname = $this->Muser->get_one(array('id'), array('nickname' => $data['nickname']));
        if($check_nickname)
        {
            $this->return_failed('昵称已被注册！');
        } */
        
        if(empty($data['tel_verify']))
        {
            $this->return_failed('手机验证码不能为空！');
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
        
        if(empty($data['password']))
        {
            $this->return_failed('密码不能为空！');
        }
        

        $data['password']	= get_encode_pwd($data['password']);
        $data['create_time']	= $time;
        $data['update_time']	= $time;
        unset($data['repassword'], $data['tel_verify']);
        
        //用户信息存入数据库
        $result = $this->Muser->create($data);
        if($result)
        {
            $result_data['user'] = encrypt(array('id' => $result, 'user_phone' => $data['user_phone']));
            $result_data['userinfo'] = array($result['user_name']);
            $this->return_success($result_data, '注册成功！');
        }
        else
        {
            $return_arr['msg'] = '注册失败，请重试！';
            $return_arr['status'] = -1;
            $this->return_json($return_arr);
        }

    }
}