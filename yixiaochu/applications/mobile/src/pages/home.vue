<template>
    <div>
      <headpart ></headpart>

      <div :class="css_wap.mainfix">
          <!-- Swiper -->
          <div  class="page-swipe">
            <mt-swipe :auto="4000">
              <mt-swipe-item v-for="v in manual_list">
                  <img :src="v.img">
              </mt-swipe-item>
            </mt-swipe>
          </div>

          <ul :class="css_wap.left_nav" >
              <li>
                  <a href="javascript:;" @click="displayCombo()" :class="foods_current_id == -1 ? css_wap.act : '' ">特推菜單</a>
              </li>
              <li v-for="(v,k) in foods_type" >
                  <a href="javascript:;"@click="change_food_type(k, v.id)":class="k == foods_current_id ? css_wap.act : '' ">{{v.name}}</a>
              </li>
          </ul>

          <!-- 右侧套餐展示栏 -->
          <div :class="css_wap.page_main" v-show="is_combo">
              <ul :class="css_wap.chose_nav">
                  <li v-for="(v, k) in menus_cate"
                    v-if=" k < 3" @click="change_menus_cate(k, v.id)":class="k == menus_cate_current_index ? css_wap.act : '' ">{{v.name}}</li>

                  <li @click="show_remain_menus_cate" :class="is_show_remain_menus_cate ? css_wap.act : '' ">﹀</li>

                  <div :class="css_wap.more_chose" v-show="is_show_remain_menus_cate">
                      <i></i>
                      <p v-for="(v,k) in menus_cate"
                         v-if=" k >= 3"
                         @click="change_menus_cate(k, v.id)"
                         :class="k == menus_cate_current_index ? css_wap.act : '' "
                        >{{v.name}}</p>
                  </div>
              </ul>
              <ul :class="[css_wap.index_lists, css_wap.meal_lists]">
                  <li v-for="(v,k) in current_menus_list" >
                      <div :class="css_wap.cont"  @click.stop="display_detail(v.id, 'combo')">
                          <img :src="v.cover_img" :class="css_wap.big_img">
                          <div :class="css_wap.info">
                              <p :class="css_wap.title">{{v.combo_name}}</p>
                              <p :class="css_wap.text">月售  {{v.sell_number}}</p>
                              <p :class="css_wap.price">
                                  ￥{{v.price}}
                                  <a href="javascript:;" :class="css_wap.add" @click.stop="add_to_car(v, current_food_type)">+</a>
                                  <input type="text" :value="v.num">
                                  <a href="javascript:;" :class="css_wap.reduce" @click.stop="remove_from_car(v, current_food_type)">-</a>
                              </p>
                          </div>
                      </div>
                      <div :class="[css_wap.cont, css_wap.list, v.show ? css_wap.act : '']">
                          <div v-for="(v2,k2) in v.foods" @click.stop="display_detail(v2.id, 'single')">
                              <img :src="v2.cover_img" :class="css_wap.s_img">
                              <p>{{v2.foods_name}}<br><span>￥{{v2.now_price}}</span></p>
                          </div>

                      </div>
                      <p :class="css_wap.but" @click="show_meal_lists(v)">{{!v.show ? '详情﹀ ' : '收起︿'}}</p>
                  </li>


              </ul>
          </div>
          <!-- 套餐右侧展示栏 -->

          <!-- 右侧单独菜品展示栏 -->
          <ul :class="css_wap.index_lists" v-show="!is_combo">
              <li v-for="(v,k) in foods" @click.stop="display_detail(v.id, current_food_type)">
                  <img :src="v.cover_img" :class="css_wap.big_img">
                  <div :class="css_wap.info" >
                      <p :class="css_wap.title">{{v.foods_name}}</p>
                      <p :class="css_wap.text">月售  {{v.sell_number}}</p>
                      <p :class="css_wap.price">
                          ￥{{v.now_price}}
                          <a href="javascript:;" :class="css_wap.add" @click.stop="add_to_car(v, current_food_type)">+</a>
                          <input type="text" @click.stop :value="v.num">
                          <a href="javascript:;" :class="css_wap.reduce" @click.stop="remove_from_car(v, current_food_type)">-</a>
                      </p>
                  </div>
              </li>
          </ul>
          <!-- 单独菜品右侧展示栏 -->
      </div>

      <footpart current = "home" :shopping_car = "shopping_car"></footpart>
    </div>
</template>

<script>
import css_wap from '../../static/css/wap.css';
import headpart from './common/header';
import footpart from './common/footer';
import store from '../store.js';
import { Swipe, SwipeItem } from 'mint-ui';


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
            is_combo: true,
            //左侧食品分栏
            foods_type:[],
            foods_current_id: -1,
            //食品列表
            foods: [],
            menus_cate: [],
            is_show_remain_menus_cate: false,
            menus_cate_current_index: 0,
            menus_list: [],
            current_menus_list: [],
            //轮播索引
            manual_list:[],
            swiper_index: 0,
            manual_list_size: 0,
            timer: {},

            shopping_car:{
              single: [],
              combo: [],
            },
            current_food_type: 'combo',

        }
    },
    computed: {

    },
    mounted(){

        document.title = "易小厨-首页";
        this.$http.get('home/mobile_index').then((response) => {
          //设置轮播列表
          this.manual_list = response.body.data.manual_list;
          this.manual_list_size = this.manual_list.length;
          //设置首页食品分类
          this.foods_type = response.body.data.foods_type;

        });

        this.displayCombo();

         this.css_wap = css_wap;
         if(store.fetch('shoppingCar').length == undefined){
             this.$set(this, 'shopping_car',store.fetch('shoppingCar'));
         }

         this.timer = setInterval(()=>{
           this.manual_current_index++;
           if(this.manual_current_index == this.manual_list_size){
             this.manual_current_index = 0;
           }
         }, 3500);

    },
    methods:{
      swiper_onIndexChange (index) {
        this.swiper_index = index
      },

      //左侧栏 - 切换单品菜类型
      change_food_type: function(currenr_index, food_type_id){
        this.is_combo = false,
        this.current_food_type = 'single';
        this.foods_current_id = currenr_index;
        this.$http.post('home/get_foods_by_type', {
          food_type: this.current_food_type,
          food_type_id: food_type_id,
        })
        .then((response) => {
          if(response.body.status == 0){
            this.foods = response.body.data.foods;
            for( let food of this.foods){
              for(let food_in_car of this.shopping_car[food.type]){
                if(food_in_car.id == food.id){
                  food.num = food_in_car.num;
                  break;
                }
              }
            }
          }else{
            alert('网络异常，请稍后再试！');
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        })
      },

      //左侧栏 - 切换到套餐(特推菜单)
      displayCombo: function(){
        this.is_combo = true;
        this.foods_current_id = -1;
        this.current_food_type = 'combo';
        this.$http.get('home/get_combo_type')
        .then((response) => {
          if(response.body.status == 0){
            this.menus_cate = response.body.data.menus_cate;
            this.menus_list = response.body.data.menus_list;
            this.change_menus_cate(0, this.menus_cate[0].id);
            for( let food of this.menus_list){
              for(let combo_in_car of this.shopping_car.combo){
                if(combo_in_car.id == food.id){
                  food.num = combo_in_car.num;
                  break;
                }
              }
            }
          }else{
            alert('系统繁忙，请稍后再试！');
          }

        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        });

      },
      change_menus_cate: function(menus_cate_current_index, menus_cate_id){
        this.is_combo = true;
        this.is_show_remain_menus_cate = false;
        this.menus_cate_current_index = menus_cate_current_index;
        this.current_menus_list = [];
        for(let combo of this.menus_list){
          if(combo.combo_cate_id == menus_cate_id){
            this.current_menus_list.push(combo);
          }
        }
      },
      show_remain_menus_cate: function(){
        this.is_show_remain_menus_cate = !this.is_show_remain_menus_cate;

      },
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
      display_detail: function(food_id, type){
        if(type == 'single'){
          this.$router.push('single_detail/' + food_id);
        }else if(type == 'combo'){
          this.$router.push('combo_detail/' + food_id);
        }

      },
      show_meal_lists: function(v){
        v.show = !v.show;
      }
    },

}

</script>


<style >
@import "http://elemefe.github.io/mint-ui/app.3e840f3.css";

desc {
  text-align: center;
  color: #666;
  margin-bottom: 5px;
}
.mint-swipe {
  height: 200px;
  color: #fff;
  font-size: 30px;
  text-align: center;
}
.page-swipe .mint-swipe{
  margin-bottom: 5px;
}
.mint-swipe-item {
  line-height: 200px;
}
.mint-swipe-item img{
  width: 100%;
  height: 100%;
}

</style>
