<template>
<div>
    <headpart title="套餐详情"></headpart>
    
    <div :class="css_wap.mainfix">
        <div :class="css_wap.detail_cont">
            <img :src="menus_list[0].cover_img" :class="css_wap.big_img">
            <p :class="css_wap.big_title">{{menus_list[0].combo_name}}<span :class="css_wap.price">{{menus_list[0].price}}</span></p>
            <p :class="css_wap.cont_text"><span v-for="(k,v) in menus_list[0].foods">{{v.foods_name }}</span></p>
            <div :class="css_wap.cont_text">
                <em>优惠：{{menus_list[0].favorable}}</em>
                
               
                <a href="javascript:;" :class="[css_wap.sum, css_wap.add]" @click="add_to_car(menus_list[0], 'combo')">+</a>
                <input type="text" :value="menus_list[0].num">
                <a href="javascript:;" :class="[css_wap.sum, css_wap.reduce]" @click="remove_from_car(menus_list[0], 'combo')">-</a>
            
            </div>
        </div>
        <p :class="css_wap.page_title">搭配技巧</p>
        <div v-for="(v, k) in menus_list[0].foods" 
             :class="[css_wap.detail_cont ,css_wap.marbot]"
            >
            <img :src="v.cover_img" :class="css_wap.s_img">
            <div :class="css_wap.info">
                <p :class="css_wap.title">{{v.foods_name}}</p>
                <p :class="css_wap.text">{{v.description}}</p>
                <p :class="css_wap.bot">已售  {{v.sell_number}}<span @click="like(v)">{{v.like_num}}</span></p>
            </div>
            <p :class="css_wap.l_text">食       材：</p>
            <p :class="css_wap.r_text">{{v.food_material}}</p>
            <p :class="css_wap.l_text">营养价值：</p>
            <p :class="css_wap.r_text">{{v.nutritive_value}}</p>
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
          menus_list: [],
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
       this.$http.post('detail/get_combo_detail', {
         id: id,
       })
       .then((response) => {
         if(response.body.status == 0){
           console.log(response.body.data)
           this.menus_list = response.body.data.menus_list;
           document.title = '易小厨-套餐详情-' + this.menus_list[0].combo_name;
           for( let food of this.menus_list){
             for(let combo_in_car of this.shopping_car.combo){
               if(combo_in_car.id == food.id){
                 food.num = combo_in_car.num;
                 break;
               }
             }
           }
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
      
      like: function(food){
        if(food.is_clicked_like){
          alert('您已经点过赞了，请勿重复操作!');
          return;
        }
        food.like_num ++ ;
        food.is_clicked_like = true;
        this.$http.post('detail/click_like', {
          id: food.id,
        })
        .then((response) => {
          if(response.body.status == 0){
            alert(response.body.msg);
          }else{
            alert(response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        });
      }

    },

}

</script>
