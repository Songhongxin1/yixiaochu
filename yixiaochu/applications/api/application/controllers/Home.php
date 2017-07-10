<?php
/**
 * 首页接口
 * @author chaokai@gz-zc.cn
 */
class Home extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        
        $this->load->model(array(
        	'Model_manual' => 'Mmanual',
            'Model_news' => 'Mnews',
            'Model_combo' => 'Mcombo',
            'Model_combo_cate' => 'Mcombo_cate',
            'Model_foods_type' => 'Mfoods_type',
            'Model_foods'=>'Mfoods',
        ));
    }
    
    public function index(){
        
        $data = $this->data;
        
        //首页轮播id
        $manual_class_id = C('manual.home.id');
        $manual_where = array('manual_class_id' => $manual_class_id, 'is_del' => 0);
        $data['manual_list'] = $this->Mmanual->get_lists('id,title,sub_title,url,img_url', $manual_where);
        if($data['manual_list']){
            foreach ($data['manual_list'] as $k => $v){
                $data['manual_list'][$k]['img_url'] = get_full_img_url($v['img_url']);
            }
        }
        //首页推荐小厨故事
        $story_where = array('is_head_recommend' => 1, 'is_del' => 0);
        $story_field = 'id,title,summary,cover_img';
        $data['home_story'] = $this->Mnews->get_one($story_field, $story_where);
        if($data['home_story']){
            $data['home_story']['cover_img'] = get_full_img_url($data['home_story']['cover_img']);
        }
        //首页套餐分类
        $menus_cate_where = array('is_del' => 0);
        $menus_cate_order = array('sort' => 'asc');
        $data['menus_cate'] = $this->Mcombo_cate->get_lists('id,name', $menus_cate_where, $menus_cate_order);
        //首页套餐
        $menus_where = array('is_del' => 0, 'in' => array('combo_cate_id' => array_column($data['menus_cate'], 'id')), 'is_show' => 1, 'is_today' => 1);
        $menus_ids = $this->Mcombo->get_lists('id', $menus_where);
        //根据ids获取套餐详情
        $menus_list = $this->Mcombo->get_info_by_ids(array_column($menus_ids, 'id'));
        //组合分类和详情数据
        $data['menus_list'] = array();
        foreach ($menus_list as $key => $value){
            $data['menus_list'][$value['id']] = $value;
            $data['menus_list'][$value['id']]['num'] = 1;//初始化下单的份数
        }
        
        $this->return_success($data);
    }
    
    /**
     * 手机端首页
     * @author louhang@gz-zc.cn
     */
    public function mobile_index(){
        $data = $this->data;
        
        //首页轮播
        $manual_class_id = C('manual.home.id');
        $manual_where = array('manual_class_id' => $manual_class_id, 'is_del' => 0);
        $data['manual_list'] = $this->Mmanual->get_lists('id,title,sub_title,url,img_url', $manual_where);
        if($data['manual_list']){
            foreach ($data['manual_list'] as $k => $v){
                $data['manual_list'][$k]['img'] = get_full_img_url($v['img_url']);
            }
        }

        //首页菜品展示
        $foods_type = $this->Mfoods_type->get_lists('id, name',array('is_del' => 0));
        foreach ($foods_type as $key => $val){
            $foods_type[$key]['type'] = 'single';
        }
        
        $data['foods_type'] = $foods_type;
        $this->return_success($data);
    }
    
    /**
     * 手机端 根据分类id,输出该分类下的菜品
     * @author louhang@gz-zc.cn
     */
    public function get_foods_by_type(){
        $data = $this->data;

        $foods_type = $this->input->get_post('food_type');
        $foods_type_id = intval($this->input->get_post('food_type_id'));
    
        if($foods_type == 'single'){
            $fileds = 'id,foods_name,old_price,now_price,type,cover_img,food_material,nutritive_value,sell_number';
            $single_foods = $this->Mfoods->get_lists($fileds, ['is_show' => 1, 'type' => $foods_type_id, 'is_del' => 0], ['sort' => 'desc']);
            $data['foods'] = array();
            foreach ($single_foods as $k => $v) {
                $data['foods'][$k] = $v;
                $data['foods'][$k]['cover_img'] = get_full_img_url($v['cover_img']);
                $data['foods'][$k]['num'] = 0;//初始化下单的份数
                $data['foods'][$k]['type'] = 'single';
            }
        }
    
        $this->return_success($data);
    }
    
    /**
     * 手机端 展示套餐
     * @author louhang@gz-zc.cn
     */
    public function get_combo_type(){
        $data = $this->data;

        $menus_cate_where = array('is_del' => 0);
        $menus_cate_order = array('sort' => 'asc');
        $data['menus_cate'] = $this->Mcombo_cate->get_lists('id,name', $menus_cate_where, $menus_cate_order);
        //首页套餐
        $menus_where = array('is_del' => 0, 'in' => array('combo_cate_id' => array_column($data['menus_cate'], 'id')), 'is_show' => 1, 'is_today' => 1);
        $menus_ids = $this->Mcombo->get_lists('id', $menus_where);
        //根据ids获取套餐详情
        
        $menus_list = $this->Mcombo->get_info_by_ids(array_column($menus_ids, 'id'));
        //组合分类和详情数据
        $data['menus_list'] = array();
        foreach ($menus_list as $key => $value){
            $data['menus_list'][$key] = $value;
            $data['menus_list'][$key]['show'] = false;
            $data['menus_list'][$key]['num'] = 0;//初始化下单的份数
        }
    
        
    
        $this->return_success($data);
    }
    
    
}