<?php
/**
 * 订单管理
 * @author cahokai@gz-zc.cn
 */
class Story extends MY_Controller{
  
  private $pagesize = 10;
  
  public function __construct(){
    parent::__construct();
    
    $this->load->model(array(
    	'Model_news' => 'Mnews',
        'Model_news_class' => 'Mnews_class',
        'Model_admins' => 'Madmins'
    ));
    
    $this->load->library('pagination');
    $this->pageconfig = C('page.config');
  }
  
  /**
   * 文章列表
   * @author songchi@gz-zc.cn
   */
    public function lists(){
        
        $type = $this->input->get('type');
        //获取标签
        $data['tags'] = $this->Mnews_class->get_lists('*', array('is_del'=>0));
        
        $cur_page = $this->input->get('cur_page');
        $cur_page = $cur_page ? $cur_page: 1;
        $order_by = array('id'=>'desc');
        $limit = 3;
        $where['is_del'] = 0;
        if($cur_page <= 1){
            if($type){
                $where['news_class_id'] = $type;
                $data['lists'] = $this->Mnews->get_lists('*', $where, $order_by, $limit);

            }else{
                $data['lists'] = $this->Mnews->get_lists('*', $where, $order_by, $limit);
            }

        }
        else{
            if($type){
                $where['news_class_id'] = $type;
            }
            $offset = ($cur_page-1)*$limit;
            $lists = $this->Mnews->get_lists('*', $where, $order_by, $limit, $offset);

            if($lists){
                //把数组从新排序
                foreach($lists as $k=>$v){
                    $data['lists'][$offset+$k] = $v;
                }
                
            }
        }
        
        $data['is_news_recommend'] = $this->Mnews->get_lists('*', array('is_del'=>0, 'is_news_recommend'=>1), $order_by, $limit);
        $data['is_banner_recommend'] = $this->Mnews->get_lists('*', array('is_del'=>0, 'is_banner_recommend'=>1), $order_by, $limit);
        if(isset($data['is_banner_recommend']) && $data['is_banner_recommend']){
            foreach($data['is_banner_recommend'] as $k=>$v){
                $data['is_banner_recommend'][$k]['cover_img'] = get_full_img_url($v['cover_img']);
            }
        }
        
        if(isset($data['lists']) && $data['lists']){
            //获取发布人
            $id = array_column($data['lists'], 'create_user');
            if($id){
                $data['create_user'] = $this->Madmins->get_lists('id, name', array('in'=>array('id'=>$id)));
                $data['create_user'] = array_column($data['create_user'], 'name', 'id');
            }
            
            foreach($data['lists'] as $k=>$v){
                $data['lists'][$k]['cover_img'] = get_full_img_url($v['cover_img']);
                $data['lists'][$k]['publisher'] = $data['create_user'][$v['create_user']];
            }
        }
        
        $this->return_success($data);

  }
  
  /**
   * ajax获取文章详情
   * @author songchi@gz-zc.cn
   */
    public function get_info(){
        $id = $this->input->get_post('id');
        $type = $this->input->get_post('type');
        $where = array();
        if($type){
            $where['news_class_id'] = $type;
        }
        $data['info'] = $this->Mnews->get_one('*', array_merge(array('id'=>$id), $where));
        $data['info']['content'] = $data['info']['content'] = str_replace(array('/../uploads/image/','/uploads/'),  C('domain.img.url') . '/', $data['info']['content']); 
        $up = $this->Mnews->get_one('id,title', array_merge(array('id<'=>$id), $where));
        $data['up'] = $up ? $up : '';
        $down = $this->Mnews->get_one('id,title', array_merge(array('id>'=>$id), $where));
        $data['down'] = $down ? $down : '';

        $this->return_success($data);
      
  }

}