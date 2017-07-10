<?php
/**
 * 今日菜单接口
 * @author yonghua@gz-zc.cn
 */
class Today extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_foods'=>'Mfoods'
        ]);
    }
    
    /**
     * 获得今日的菜谱列表
     * @author yonghua@gz-zc.cn
     */
    public function get_today(){
        try {
            $data = $this->data;
            $fileds = 'id,foods_name,old_price,now_price,type,cover_img,food_material,nutritive_value,sell_number';
            $res = $this->Mfoods->get_lists($fileds, [
                'is_today' => 1,
                'is_show' => 1,
                'in' => array('type' => array(C('foods_type.fushi.value'), C('foods_type.jinri.value'))),
                'is_del' => 0
            ], [
                'sort' => 'desc'
            ]);
            foreach ($res as $k => $v) { 
                $data['foods'][$k] = $v;
                $data['foods'][$k]['cover_img'] = get_full_img_url($v['cover_img']);
                $data['foods'][$k]['num'] = 1;//初始化下单的份数
            }
            $data['type'] = C('foods_type');
            $this->return_success($data);
            
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
        
    }
    
}