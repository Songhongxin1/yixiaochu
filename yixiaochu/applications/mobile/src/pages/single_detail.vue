<template>
<div>
    <headpart :title="food.foods_name"></headpart>
    
    <div :class="css_wap.mainfix">
    <div :class="[css_wap.detail_cont, css_wap.marbot]">
        <img :src="food.cover_img" :class="css_wap.big_img">
        <p :class="[css_wap.big_title, css_wap.lheight]">
            {{food.foods_name}}
            <a href="javascript:;" :class="[css_wap.sum, css_wap.add]" @click="add_to_car(food, 'single')">+</a>
            <input type="text" :value="food.num">
            <a href="javascript:;" :class="[css_wap.sum, css_wap.reduce]" @click="remove_from_car(food, 'single')">-</a>
            <span :class="css_wap.price">￥{{food.now_price}}</span>
        </p>
    </div>
    <div :class="[css_wap.detail_cont, css_wap.marbot]">
        <p :class="css_wap.l_text">食       材：</p>
        <p :class="css_wap.r_text">{{food.food_material}}</p>
        <p :class="css_wap.l_text">营养价值：</p>
        <p :class="css_wap.r_text">{{food.nutritive_value}}</p>
    </div>
    </div>
    
    
    <footpart current = "home" :shopping_car = "shopping_car"></footpart>
</div>
</template>

<style>
.staggered-transition {
  transition: all .7s ease;
  overflow: hidden;
  margin: 0;

}
.staggered-enter, .staggered-leave {
  opacity: 0;
}

.swiper-pagination{ 
  bottom: 10px; 
  left: 0; 
  width: 100%; 
  position: absolute;
  text-align: right;
  z-index: 10;
}
.swiper-pagination-bullet { 
  margin: 0 5px; 
  width: 10px;
  height: 10px;
  display: inline-block;
  border-radius: 50%;
  background: #fff;
}
.swiper-pagination-bullet-active { opacity: 1; background: #dc1a00; }
</style>

<script>
import css_wap from '../../static/css/wap.css';
import headpart from './common/header';
import footpart from './common/footer';
import store from '../store.js';

export default {
    components:{
      css_wap,
      headpart,
      footpart,
    },
    created(){
      
    },
    data(){
        return {
          css_wap: {},
          food: {},
          shopping_car:{
            single: [],
            combo: [],
          },
        }
    },
    computed: {

    },
    mounted(){
       this.css_wap = css_wap;
       if(store.fetch('shoppingCar').length == undefined){
         this.$set(this, 'shopping_car',store.fetch('shoppingCar'));
       }
       
       let id = this.$route.params.id;
       this.$http.post('detail/get_single_detail', {
         id: id,
       })
       .then((response) => {
         if(response.body.status == 0){
           response.body.data.num = 0;
           for (let obj of this.shopping_car['single']) {
             if(obj.id == response.body.data.id){
               response.body.data.num =  obj.num;
               break;
             }
           }
           
           //ajax仅查询详情信息， 购买数量num保存在本地，需要对比id得出
           this.food = response.body.data;

         }else{
           alert(response.body.msg);
         }
       })
       .catch(function(error) {
         alert('网络异常，请稍后再试！');
       });
       
       

    },
    methods:{
      add_to_car: function(food, type){
        food.num ++;
        if( this.shopping_car[type].length){
          let is_exist = false;
          for (let obj of this.shopping_car[type]) {
            if(obj.id == food.id){
              obj.num ++;
              is_exist = true;
              break;
            }
          }
          if(!is_exist){
            food.num = 1;
            this.shopping_car[type].push(food);
          }
        }else{
          food.num = 1;
          this.shopping_car[type].push(food);
        }
        store.save(this.shopping_car, 'shoppingCar');
      },
      remove_from_car: function(food, type){
        if(food.num == 0){
          alert('不能再减了');
          return ;
        }
        for (let obj of this.shopping_car[type]) {
          if(obj.id == food.id){
            obj.num --;
            food.num = obj.num;
            break;
          }
        }
        store.save(this.shopping_car, 'shoppingCar');
      },

    },
    watch:{
       
    },

}

</script>
