<?php
/**
 * 吐槽
 * @author songchi@gz-zc.cn
 */
class Scoff extends MY_Controller{
  
  private $pagesize = 10;
  
  public function __construct(){
    parent::__construct();
    
    $this->load->model(array(
    	'Model_scoff' => 'Mscoff',
    ));
    
    $this->load->library('pagination');
    $this->pageconfig = C('page.config');
  }
  
  
  /**
   * 
   * @author songchi@gz-zc.cn
   */
    public function get_read(){
        $order_by['create_time'] = 'desc';
        $data['lists'] = $this->Mscoff->get_lists('*', array(), $order_by);
//         echo 1;
//         exit;
//         $type = C('scoff_object');
//         echo "<pre>";
//         var_dump($type);
//         exit;
//         $data['type'] = $type;
//         $data['lists'] = $this->Mscoff->get_lists('content');

        $this->return_success($data['lists']);
      
  }
  
  
  /**
   *
   * @author songchi@gz-zc.cn
   */
  public function get_tag(){
      $data['tag'] =  C('scoff_object');
      //         echo 1;
      //         exit;
      //         $type = C('scoff_object');
      //         echo "<pre>";
      //         var_dump($type);
      //         exit;
      //         $data['type'] = $type;
      //         $data['lists'] = $this->Mscoff->get_lists('content');
  
      $this->return_success($data['tag']);
  
  }
  
  public function write(){
      $content = $this->input->post('content1');
      if($content){
          $data['content'] = $content;
          $data['create_time'] = date('Y-m-d H:i:s', time());
          $add = $this->Mscoff->create($data);
          if($add){
              $data['lists'] = $this->Mscoff->get_lists('*');
              $this->return_success($data['content']);
          }
      }
  
  }

}