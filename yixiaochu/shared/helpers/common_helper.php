<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cookie 加密
 */
if ( ! function_exists('encrypt')) {
	function encrypt($array = array()){
		$info = base64_encode(json_encode($array));
		$num = ceil(strlen($info)/1.5);
		$key1 = substr($info,0,$num);
		$result = strtr($info,array($key1=>strrev($key1)));
		$key2 = substr($result, -$num,$num-2);
		$result = strtr($result,array($key2=>strrev($key2)));
		return $result;
	}
}

/**
 * Cookie 解密
 */
if ( ! function_exists('decrypt')) {
	function decrypt($str = ''){
		$num = ceil(strlen($str)/1.5);
		$key2 = substr($str, -$num,$num-2);
		$str = strtr($str,array($key2=>strrev($key2)));
		$key1 = substr($str,0,$num);
		$result = strtr($str,array($key1=>strrev($key1)));
		$info = json_decode(base64_decode($result),true);
		return $info;
	}
}


/**
 *发送短信
 */
if ( ! function_exists('send_msg')) {
    function send_msg($tel, $msg = ''){
        if (empty($tel) || empty($msg)){
            return false;
        }
        $CI=&get_instance();
        $CI->load->library('sms', array(C("sms")));
        if (is_array($tel)){
            $tel = implode(',', $tel);
        }

        try {
            return $CI->sms->send_sms_huaxing($tel, $msg,'');
        }catch (Exception $e) {
            echo $e->getMessage(), "\n";
        }
    }

}


/**
 * 获取随机数
 */
if (! function_exists('get_code')){
    function get_code(){
        return  rand(100000, 999999);
    }
}


/**
 * 更复杂的获取随机数
 */
if (! function_exists('get_complex_code')){
    function  get_complex_code($length = 6){
        $str = '';
        $pa = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i=0; $i<$length; $i++){
             $str .= $pa{mt_rand(0,35)};
        }
        return $str;
     }
}


/**
 * 图片上传
 * @param string $file_name
 */
if (! function_exists('upload_file')){
    function upload_file($file_name, $config=''){
        $return_msg = array();
        $CI=&get_instance();
        $CI->load->library('upload', $config);
        if ( ! $CI->upload->do_upload($file_name)){
            $return_msg['flag'] = FALSE;
            $return_msg['data'] = $CI->upload->display_errors();
        }else{
            $return_msg['flag'] = TRUE;
            $return_msg['data'] = $CI->upload->data();
        }
        return $return_msg;
    }
}


/**
 * 获取加密用户密码
 *
 * @param string $file_name
 */
if (! function_exists('get_encode_pwd')){
    function get_encode_pwd($password){
        if (empty($password)){
            return FALSE;
        }
        $password = md5(strtolower($password));
        return $password;
    }
}


/**
 * 将二维数组中的第一维转换为和某个第二维字段值关联
 */
if (! function_exists('change_arr_key_by_somekey')){
    function change_arr_key_by_somekey($arr = array(), $somekey){
        $arr_somekey = array();
        if ($arr){
            foreach ($arr as $key=>$v){
                $arr_somekey[$v[$somekey]] = $v;
            }
        }
        return $arr_somekey;
    }


}

/**
 * 显示图片优化函数
 */
if (! function_exists('optim_image')){
    function optim_image($img_full_url = '', $size = array(0, 0), $type = '', $watermark = FALSE){
        
        //地址为空 或者优化配置关闭直接返回 
        if ($img_full_url == '' || !C('images_optim.optim')){
            return $img_full_url;
        } 
        
        $extension =  substr($img_full_url, strrpos($img_full_url, '.'));
        
        $replace_str = '_t';
        if ($type){
            $replace_str .= $type;
        }
        if ($watermark){
            $replace_str .= '_w';
        }
        if ($size[0] && $size[1]){
            $replace_str .= '_s'.$size[0] . 'x' . $size[1];
        }
        
        $img_full_url = str_replace($extension, $replace_str . $extension,  $img_full_url);
        
        return $img_full_url;
    }
   
}
  
/**
 * nengfu@gz-zc.cn
 * 操作日志
 * @param string $id 操作人ID
 * @param string $info 操作信息
 * @return void
 */
function operate_log($id , $info = ""){
    $CI = get_instance();
    $data = array(
        "operate_id" => $id,
        "operate_content" => $info,
        "create_time" => time()
    );
    $CI->db->insert("t_operate_log",$data);
  
}




    
/**
 * 获取随机奖品
 *
 * @param array $data  奖品数据
 *
 * @return number  中奖奖项
 */
if (! function_exists('get_rand')){
    function get_rand($data) {
        $result = '';
        $pro_sum = array_sum($data);
        foreach ($data as $key => $pro_cur) {
            $rand_num = mt_rand(1, $pro_sum);
            if ($rand_num <= $pro_cur) {
                $result = $key;
                break;
            } else {
                $pro_sum -= $pro_cur;
            }
        }
        unset ($data);
        return $result;
    }
}

    

/**
 *  删除非站内链接
 *
 * @access    public
 * @param     string  $body  内容
 * @param     array  $allow_urls  允许的超链接
 * @return    string
 */
if(!function_exists('replace_links')){
    function replace_links($body, $allow_urls=array('global28.com')){
        $host_rule = join('|', $allow_urls);
        $host_rule = preg_replace("#[\n\r]#", '', $host_rule);
        $host_rule = str_replace('.', "\\.", $host_rule);
        $host_rule = str_replace('/', "\\/", $host_rule);
        $arr = '';
        preg_match_all("#<a([^>]*)>(.*)<\/a>#iU", $body, $arr);
        if( is_array($arr[0]) )
        {
            $rparr = array();
            $tgarr = array();
            foreach($arr[0] as $i=>$v)
            {
                if( $host_rule != '' && preg_match('#'.$host_rule.'#i', $arr[1][$i]) )
                {
                    continue;
                } else {
                    $rparr[] = $v;
                    $tgarr[] = $arr[2][$i];
                }
            }
            if( !empty($rparr) )
            {
                $body = str_replace($rparr, $tgarr, $body);
            }
        }
        return $body;
    }
}
/**
 * 获取客户端ip
 *
 */
if(!function_exists('get_client_ip')){
    function get_client_ip($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
if(!function_exists('tp_redirect')){
    function tp_redirect($url, $time=0, $msg='') {
        //多行URL地址支持
        $url        = str_replace(array("\n", "\r"), '', $url);
        if (empty($msg))
            $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
        if (!headers_sent()) {
            // redirect
            if (0 === $time) {
                header('Location: ' . $url);
            } else {
                header("refresh:{$time};url={$url}");
                echo($msg);
            }
            exit();
        } else {
            $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
            if ($time != 0)
                $str .= $msg;
            exit($str);
        }
    }
}


/**
 *递归处理数组（将子分类与上级分类合并）
 *
 *@param string $data
 *@param string $parent
 *@param int page_number
 *@return array
 */
if(!function_exists('class_loop')){
    function class_loop($data,$parent=0){

        $result = array();
        if($data)
        {
            foreach($data as $key=>$val)
            {
                if($val['parent_id']==$parent)
                {
                    $temp = class_loop($data,$val['id']);
                    if($temp) $val['child'] = $temp;
                    $result[] = $val;
                }
            }
        }
        return $result;
    }
}

/**
 *递归处理数组（将子分类与上级分类合并）
 *
 *@param string $data
 *@param string $parent
 *@param int page_number
 *@return array
 */
if(!function_exists('class_loop_list')) {
    function class_loop_list($data, $level = 0)
    {

        $level++;
        $result = array();
        if ($data) {
            foreach ($data as $v) {
                $v['level'] = $level;
                $child = array();
                if (!empty($v['child'])) {
                    $child = $v['child'];
                }
                unset($v['child']);
                $result[] = $v;
                if (!empty($child)) {
                    $result = array_merge($result, class_loop_list($child, $level));
                }
            }
        }
        return $result;
    }
}

/**
 *根据身份证号计算年龄
 *
 *@param string $birthday
 *@return int
 */
if(!function_exists('get_age_by_ID')) {
    function get_age_by_ID($ID){ 
        if(empty($ID)) return ''; 
        $date = strtotime(substr($ID, 6, 8));
        $today = strtotime('today');
        $diff = floor(($today-$date)/86400/365);
        $age = strtotime(substr($ID, 6, 8).' +'.$diff.'years') > $today ? ($diff + 1) : $diff; 
        return $age; 
    } 
}
    
    
   
    
    


