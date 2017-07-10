<?php 
/**
* 资讯管理控制器
* @author jianming@gz-zc.cn
*/
defined('BASEPATH') or exit('No direct script access allowed');
class News extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model([
             'Model_news' => 'Mnews',
             'Model_keywords' => 'Mkeywords',
             'Model_news_class' => 'Mnews_class',
             'Model_admins' => 'Madmins',
             'Model_news_comment' => 'Mnews_comment'
        ]);
    }
    

    /**
     * 文章评论页
     */
    public function comment(){
        $id = intval($this->input->get_post('id'));
        $content = $this->input->post('content'); 
        if($content){
            $post_data['created_time'] = date("Y-m-d h:i:s", time());
            $post_data['news_id'] = $id;
            $post_data['comment'] = $content; 
            $add = $this->Mnews_comment->create($post_data);
        }
        
        $order_by['created_time'] = 'desc';
//         $limit = 3;
//         $data['comment_lists'] = $this->Mnews_comment->get_lists('*', array('is_del'=>0, 'news_id'=>$id), $order_by, 0, $limit);
        $data['comment_lists'] = $this->Mnews_comment->get_lists('*', array('is_del'=>0, 'news_id'=>$id), $order_by);
        $limit = 2;
        $data['is_news_recommend'] = $this->Mnews->get_lists('*', array('is_del'=>0, 'is_news_recommend'=>1), array('publish_time'=>'desc'), $limit);
        $this->return_success($data);
    }
    
    
    /**
     * 赞评论
     * @author nengfu@gz-zc.cn
     */
    public  function get_zan(){
        $id = intval($this->input->get("id"));
        $where['id'] = $id;
        $number = $this->Mnews->get_one('good', array('id'=>$id))['good']+1;
        $update = $this->Mnews->update_info(array('good'=>$number), $where);
        $this->return_success($number);
    
    }
    
    
    public  function get_read(){
        $id = intval($this->input->get("id"));
        $where['id'] = $id;
        $number = $this->Mnews->get_one('read', array('id'=>$id))['read']+1;
        $update = $this->Mnews->update_info(array('read'=>$number), $where);
        $this->return_success($number);
    
    }
    
}

