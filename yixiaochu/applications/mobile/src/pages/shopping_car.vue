<template>
<div>
    <headpart title="我的菜单"></headpart>
    
    <div :class="css_wap.mainfix">
        <ul :class="[css_wap.story_lists, css_wap.order_list]">
            <li v-for="(v, k) in shopping_car.combo" v-if="v.num">
                <img src="../../static/images/p11.jpg" @click="display_detail(v.id, 'combo')">
                <div :class="css_wap.cont">
                    <p :class="css_wap.title" @click="display_detail(v.id, 'combo')">{{v.combo_name}}<a href="javascript:;" :class="css_wap.del" @click.stop="delete_from_car(v)">删除</a></p>
                    <p :class="css_wap.text_cont"><span v-for="(v2, k2) in v.foods">{{v2.foods_name}} </span></p>
                    <p :class="[css_wap.bot, css_wap.price]">
                        ￥{{v.price}}
                        <a href="javascript:;" :class="[css_wap.sum, css_wap.add]" @click = "add_to_car(v, 'combo')">+</a>
                        <input type="text" :value="v.num">
                        <a href="javascript:;" :class="[css_wap.sum, css_wap.reduce]" @click = "remove_from_car(v, 'combo')">-</a>
                    </p>
                </div>
            </li>
            
            <li v-for="(v, k) in shopping_car.single" v-if="v.num">
                <img src="../../static/images/p11.jpg" @click="display_detail(v.id, 'single')">
                <div :class="css_wap.cont">
                    <p :class="css_wap.title" @click="display_detail(v.id, 'single')">{{v.foods_name}}<a href="javascript:;" :class="css_wap.del" @click.stop="delete_from_car(v)">删除</a></p>
                    <p :class="css_wap.text">{{v.nutritive_value}}</p>
                    <p :class="[css_wap.bot, css_wap.price]">
                        ￥{{v.now_price}}
                        <a href="javascript:;" :class="[css_wap.sum, css_wap.add]" @click = "add_to_car(v, 'single')">+</a>
                        <input type="text" :value="v.num">
                        <a href="javascript:;" :class="[css_wap.sum, css_wap.reduce]" @click = "remove_from_car(v, 'single')">-</a>
                    </p>
                </div>
            </li>
        </ul>
        <p :class="css_wap.page_title" v-if="is_login">送餐地址<a href="javascript:;" @click="trigger_show_address">新增地址</a></p>
        <p style="margin-top: 0.4rem;" v-else></p>
        <div v-for="(v, k) in user_addr"
             :class="[css_wap.page_cont, css_wap.adres_cont, css_wap.marbot]" 
             
            >
            <input type="radio" v-model="receive_address" :value="v.id" >
            <p :class="css_wap.text"> {{v['bus_area_text']}}-{{v['area_text']}}-{{v['addr_name']}}- {{v['user_name']}} 收 (电话: {{v['addr_phone']}})  </p>
        </div>
        
        <div :class="[css_wap.page_cont, css_wap.marbot, css_wap.sum_cont]">总计：<span>￥{{sum}}</span><a href="javascript:;" :class="css_wap.pay" @click="pay">立即付款</a></div>
    </div>
    
    <div class="modal-mask" v-show="show_pay" transition="modal" @click="trigger_show_pay">
        <div :class="[css_wap.popup, css_wap.popup_pay, css_wap.act]" @click.stop="">
            <p :class="css_wap.title">选择支付方式</p>
            <div :class="css_wap.pay_cont">
                <img src="../../static/images/weix.png">
                <p :class="css_wap.text">微信支付<br><span>使用微信支付，支持AA付款</span></p>
                <i></i>
            </div>
            
            <div :class="css_wap.cont">
                <div :class="css_wap.con">
                    <input type="radio" v-model="pay_type" value="1" id="all"><label :class="css_wap.icon" for="all">任性全款</label>
                </div>
                <div :class="css_wap.con">
                    <input type="radio" v-model="pay_type" value="2" id="part"><label :class="css_wap.icon" for="part">AA支付</label>
                    <template v-if="pay_type == 2">  
                        <span :class="css_wap.num">人数</span>
                        <a href="javascript:;" :class="css_wap.but" @click="minus_person_num">-</a>
                        <input type="text" :value="pay_person_num">
                        <a href="javascript:;" :class="css_wap.but" @click="pay_person_num++">+</a>
                    </template> 
                </div>
            </div>
            <div :class="css_wap.pay_cont">
                <p :class="css_wap.count">总计：<span>￥{{sum}}</span></p>
                <template v-if="pay_type == 2"> 
                    <p :class="css_wap.count">小计（人均）：<span>￥{{(sum/pay_person_num).toFixed(2)}}</span></p>
                </template> 
            </div>
            <a href="javascript:;" :class="css_wap.submit">确认支付</a>
        </div>
    </div>
    
    <div class="modal-mask" v-show="show_add_address" transition="modal">
        <div :class="[css_wap.popup, css_wap.popup_adres, css_wap.act]" >
            <ul>
                <li>
                    <label><span>*</span>所在地区：</label>
                    <select :class="css_wap.style1" v-model="address_info.bus_area" >
                      <option v-for="option in bus_area_options" v-bind:value="option.id"">
                        {{ option.name }}
                      </option>
                    </select>
                  
                </li>
                <li style="margin-left: 4rem;">
                <select :class="css_wap.style1" v-model="address_info.area" >
                    <option v-for="option in area_options" v-bind:value="option.id"">
                      {{ option.name }}
                    </option>
                </select>
            </li>
                <li>
                    <label><span>*</span>详细地址：</label>
                    <textarea v-model="address_info.addr_name" placeholder=""></textarea>
                </li>
                <li>
                    <label><span>*</span>收货人姓名：</label>
                    <input type="text" v-model="address_info.user_name" placeholder="">
                </li>
                <li>
                    <label><span>*</span>手机号码：</label>
                    <input type="text" v-model="address_info.addr_phone" placeholder="">
                </li>
                <li><input type="checkbox" v-model="address_info.is_default">设置为默认收货地址</li>
            </ul>
            <div :class="css_wap.but_cont"><a href="javascript:;" :class="css_wap.submit" @click="save_address">保存</a><a href="javascript:;" :class="css_wap.submit" @click="trigger_show_address">取消</a></div>
        </div>
    </div>
    
    
    <footpart current = "menu" :shopping_car = "shopping_car"></footpart>
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


.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}
.modal-enter, .modal-leave {
  opacity: 0;
}
.modal-enter .modal-container,
.modal-leave .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
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
    data(){
      return {
        css_wap: {},
        is_login: false,
        single_foods: {},
        combo_foods: {},
        shopping_car:{
          single: [],
          combo: [],
        },
        //用户信息
        user_info:[],
        //地址信息
        user_addr:[],
        receive_address: 0,
        show_add_address: false,
        show_pay: false,
        
        pay_way: 1,   //支付途径：1，微信支付 ，2支付宝支付
        pay_type: 1,  //支付形式：1，全款 ，2，AA付款
        pay_person_num: 3, //AA付款人数，默认3人
        addr_id: 0,   //收货地址id
        
        address_info:{
          id: -1,
          bus_area: 1,
          area: 5,
          addr_name: '',
          user_name: '',
          addr_phone: '',
          is_default: 1,
        },
        bus_area_options: {},
        area_options: {},
        
      }
    },
    computed: {
      sum:function(){
        let combo_sum = 0.0;
        let single_sum = 0.0;
        for(let combo of this.shopping_car.combo){
          combo_sum += combo.price * combo.num;
        }
        for(let single of this.shopping_car.single){
          single_sum += single.now_price * single.num;
        }
        return (combo_sum+single_sum).toFixed(2);
      },
    },
    mounted(){    
       this.css_wap = css_wap;
       
       if(store.fetch('user').length != 0){
         this.is_login = true;
         let user = store.fetch('user');
         this.$http.post('user/info', {
           user: user,
         })
         .then((response) => {
           if(response.body.status == 0){
             this.user_info = response.body.data;
             this.user_addr = this.user_info.user_addr;
             for(let address of this.user_addr){
               if(address.is_default == 1){
                 this.receive_address = address.id;
                 return;
               }
             }
           }else{
             //alert( response.body.msg);
           }
         })
         .catch(function(error) {
           alert('网络异常，请稍后再试！');
         });
         
         this.$http.get('user/get_bus_area')
         .then((response) => {
           if(response.body.status == 0){
             this.bus_area_options = response.body.data;
           }else{
             alert(response.body.msg);
           }
         })
         .catch(function(error) {
           alert('网络异常，请稍后再试！');
         });
         
         this.$http.post('user/get_area', {
           bus_area_id: 1 ,
         })
         .then((response) => {
           if(response.body.status == 0){
             this.area_options = response.body.data;
           }else{
             alert(response.body.msg);
           }
         })
         .catch(function(error) {
           alert('网络异常，请稍后再试！');
         });
         
       }
       
       if(store.fetch('shoppingCar').length == undefined){
           this.$set(this, 'shopping_car',store.fetch('shoppingCar'));
       }
    },
    methods:{
      add_to_car: function(food, type){
        food.num ++;
        store.save(this.shopping_car, 'shoppingCar');
      },
      remove_from_car: function(food, type){
        if(food.num == 1){
          this.delete_from_car(food, type);
          return ;
        }
        food.num -- ;
        store.save(this.shopping_car, 'shoppingCar');
      },
      delete_from_car: function(food, type){
        if(!confirm('是否删除该商品?')){
          return;
        }
        food.num = 0;
        store.save(this.shopping_car, 'shoppingCar');
      },
      trigger_show_address: function(){
        this.show_add_address = !this.show_add_address;
      },
      save_address: function(){
        this.$http.post('user/save_address', {
          user: store.fetch('user'),
          id: this.address_info.id,
          bus_area: this.address_info.bus_area,
          area: this.address_info.area,
          addr_name: this.address_info.addr_name,
          user_name: this.address_info.user_name,
          addr_phone: this.address_info.addr_phone,
          is_default: this.address_info.is_default,
        })
        .then((response) => {
          if(response.body.status == 0){
            this.address_info = {
              id: -1,
              bus_area: 1,
              area: 5,
              addr_name: '',
              user_name: '',
              addr_phone: '',
              is_default: 1,
            };
            this.user_addr = response.body.data;
            if(this.user_addr[this.user_addr.length-1].is_default == 1){
              this.receive_address = this.user_addr[this.user_addr.length-1].id;
            }
            this.trigger_show_address();
          }else{
            alert(response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        })
       
      },
      trigger_show_pay: function(){
        this.show_pay = !this.show_pay;
      },
      pay: function(){
        //如果未登录，跳转至登录页面
        if(store.fetch('user').length == 0){
            if(confirm('请先进行登录操作!')){
              this.$route.router.go('login');
              return;
            }else{
              return;
            }
        }else{
          this.trigger_show_pay();
        }
      },
      display_detail: function(food_id, type){
        if(type == 'single'){
          this.$route.router.go('single_detail/' + food_id);
        }else if(type == 'combo'){
          this.$route.router.go('combo_detail/' + food_id);
        }
      },
      minus_person_num: function(){
        if(this.pay_person_num === 2){
          alert('AA付款至少两人支付');
          return
        }
        this.pay_person_num --;
      }, 

    },
    watch:{
      'address_info.bus_area': function (val) {
        this.$http.post('user/get_area', {
          bus_area_id: val || 1,
        })
        .then((response) => {
          if(response.body.status == 0){
            this.area_options = response.body.data;
          }else{
            this.area_options = {};
            alert( response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        });
      },
    },

}

</script>
