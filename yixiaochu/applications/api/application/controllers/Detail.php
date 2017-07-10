<?php
/**
 * 套餐详情页接口
 * @author yonghua@gz-zc.cn
 */
class Detail extends MY_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model([
            'Model_foods' => 'Mfoods',
            'Model_combo' => 'Mcombo',
            'Model_combo_cate' => 'Mcombocate',
            'Model_area' => 'Marea'
        ]);
    }
    
    /**
     * 获得套餐详情
     * @author yonghua@gz-zc.cn
     */
    public function get_detail(){
        try {
            $data = $this->data;
            //查找当前id的套餐
            $id = (int) $this->input->post('id', TRUE);
            $fileds = 'id,combo_name,price,favorable,cover_img,relevance_id,combo_cate_id,sell_number,description';
            $data['combo'] = $this->Mcombo->get_one($fileds, [
                'id' => $id,
                'is_today' => 1,
                'is_show' => 1,
                'is_del' => 0
            ]);
            //查询套餐的分类名称
            $cate = $this->Mcombocate->get_one('name',['id' => $data['combo']['combo_cate_id']]);
            if($cate){
                $data['combo']['cate_name'] = $cate['name'];
                unset($data['combo']['combo_cate_id']);
            }
            $data['combo']['cover_img'] = get_full_img_url($data['combo']['cover_img']);
            //根据当前套餐关联id,查询菜谱信息
            $relevance_id = explode(',', $data['combo']['relevance_id']);
            $filed = 'id,foods_name,cover_img,food_material,nutritive_value,sell_number';
            $res = $this->Mfoods->get_lists($filed, [
                'is_today' => 1,
                'is_show' => 1,
                'in' => array('id' => $relevance_id),
                'is_del' => 0
            ], [
                'sort' => 'desc'
            ]);
            if($res){
                foreach ($res as $k => $v){
                    $data['caipu'][$k] = $v;
                    $data['caipu'][$k]['cover_img'] = get_full_img_url($v['cover_img']);
                }
            }
            //查询收货地区和商圈
            $data['area'] = $this->Marea->get_lists('id,pid,name',['pid' =>0 ],['sort' => 'desc']);
            $this->return_success($data);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
        
    }
    
    /**
     * 获得单独菜品详情
     * @author louhang@gz-zc.cn
     */
    public function get_single_detail(){
        try {
            $data = $this->data;
            //查找当前id的套餐
            $id = (int)$this->input->post('id', TRUE);
            $filed = 'id, foods_name, cover_img, old_price, now_price, food_material, nutritive_value, sell_number';
            $res = $this->Mfoods->get_one($filed, [
                            'is_today' => 1,
                            'is_show' => 1,
                            'id' => $id,
                            'is_del' => 0
            ]);
            if($res){
                $res['cover_img'] = get_full_img_url($res['cover_img']);
                $res['num'] = 0;
                $data = $res;
            }
            $this->return_success($data);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    
    }
    
    /**
     * 获得单独菜品详情
     * @author louhang@gz-zc.cn
     */
    public function get_combo_detail(){
        try {
            $data = $this->data;
            //查找当前id的套餐
            $id = (int)$this->input->post('id', TRUE);
            
            $menus_list = $this->Mcombo->get_info_by_ids(array($id), true);
            //组合分类和详情数据
            $data['menus_list'] = array();
            foreach ($menus_list as $key => $value){
                $data['menus_list'][$key] = $value;
                $data['menus_list'][$key]['num'] = 0;//初始化下单的份数
                $data['menus_list'][$key]['is_clicked_like'] = false;//初始化下单的份数
            }
            $this->return_success($data);
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    
    }
    
    /**
     * 单独菜品点赞
     * @author louhang@gz-zc.cn
     */
    public function click_like(){
        try {
            $data = $this->data;
            //查找当前id的套餐
            $id = (int)$this->input->post('id', TRUE);
    
            if($this->Mfoods->update_info(array('incr' => array('like_num' => 1)), array('id' => $id))){
                $this->return_success('','点赞成功，感谢您的支持!');
            }else{
                $this->return_failed('点赞失败，请稍后再试!');
            }

            
            
        } catch (Exception $e) {
            $this->return_failed($e->getMessage());
        }
    
    }
    
}