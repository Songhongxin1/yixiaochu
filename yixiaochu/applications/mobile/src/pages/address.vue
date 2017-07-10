<template>
<div>
    <headpart title="收货地址"></headpart>
    
    <div :class="css_wap.mainfix">
        <p :class="css_wap.page_title" v-if="is_login">送餐地址<a href="javascript:;" @click="trigger_show_address">新增地址</a></p>
        <p style="margin-top: 0.4rem;" v-else></p>
        <div v-for="(k, v) in user_addr"
             :class="[css_wap.page_cont, css_wap.adres_cont, css_wap.marbot]" 
            >
            <div class="left_button">
            <a href="javascript:;"  class="del" @click.stop="edit_address(v)">编辑</a>
            <a href="javascript:;"  class="del" @click.stop="delete_address(v)">删除</a>
            <a v-if="v.is_default == 1" class="del default_button" >默认</a>
            </div>
            
            
            <p style="width:85%" :class="css_wap.text"> {{v['bus_area_text']}}-{{v['area_text']}}-{{v['addr_name']}}- {{v['user_name']}} 收 (电话: {{v['addr_phone']}})  </p>
        </div>
        
        <div :class="[css_wap.page_cont, css_wap.marbot, css_wap.sum_cont]"> <a href="javascript:;" :class="css_wap.pay" @click="add_address">添加新的地址</a></div>
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
                    <textarea v-model="address_info.addr_name" placeholder="&#x5EFA;&#x8BAE;&#x4F60;&#x5982;&#x5B9E;&#x586B;&#x5199;&#x8BE6;&#x7EC6;&#x9001;&#x9910;&#x5730;&#x5740;&#xFF0C;&#x4F8B;&#x5982;&#x8857;&#x9053;&#x540D;&#x79F0;&#xFF0C;&#x95E8;&#x724C;&#x53F7;&#x7801;&#xFF0C;&#x697C;&#x5C42;&#x548C;&#x623F;&#x95F4;&#x53F7;&#x7B49;&#x4FE1;&#x606F;&#x3002;"></textarea>
                </li>
                <li>
                    <label><span>*</span>收货人姓名：</label>
                    <input type="text" v-model="address_info.user_name" placeholder="&#x957F;&#x5EA6;&#x4E0D;&#x8D85;&#x8FC7;25&#x4E2A;&#x5B57;&#x7B26;">
                </li>
                <li>
                    <label><span>*</span>手机号码：</label>
                    <input type="text" v-model="address_info.addr_phone" placeholder="&#x8BF7;&#x8F93;&#x5165;11&#x4F4D;&#x624B;&#x673A;&#x53F7;&#x7801;">
                </li>
                <li><input type="checkbox" v-model="address_info.is_default" >设置为默认收货地址</li>
            </ul>
            <div :class="css_wap.but_cont"><a href="javascript:;" :class="css_wap.submit" @click="save_address">保存</a><a href="javascript:;" :class="css_wap.submit" @click="trigger_show_address">取消</a></div>
        </div>
    </div>
    
    
    <footpart current = "menu" :shopping_num = "shopping_num"></footpart>
    
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

.del{
  float: left;
  padding: 0.1rem 0.3rem;
  border-radius: 0.2rem;
  background: #eaeaea;
  border: solid 1px #dedede;
  color: #999;
  margin: 0.1rem 0 0 0;
}
.left_button{
  float: left; 
  width: 13%;
}
.default_button{
  background: #f56c65;
  border: solid 1px #ffffff;
  color: #fff;
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
    created(){
    },
    data(){
      return {
        css_wap: {},

        //用户信息
        user_info:[],
        //地址信息
        user_addr:[],

        show_add_address: false,

        
        address_info:{
          
        },
        bus_area_options: {},
        area_options: {},
        
      }
    },
    computed: {
      //购物车内商品个数统计
      
      sum:function(){
        
        return 123;
      },
    },
    ready(){      
       this.css_wap = css_wap;

    },
    methods:{
      trigger_show_address: function(){
        this.show_add_address = !this.show_add_address;
      },
      add_address: function(){
        this.address_info = {
          id: -1,
          bus_area: 1,
          area: 5,
          addr_name: '',
          user_name: '',
          addr_phone: '',
          is_default: 1,
        };
        this.trigger_show_address();
      },
      edit_address: function(v){
        
        this.address_info = {
          id: v.id,
          bus_area: v.bus_area,
          area: v.area,
          addr_name: v.addr_name,
          user_name: v.user_name,
          addr_phone: v.addr_phone,
          is_default: v.is_default == 1 ,
        };
        console.log(this.address_info.is_default);
        this.trigger_show_address();
      },
      delete_address: function(v){
        if(!confirm("确定要删除该收货地址吗？"))
        {
          return
        }
        
        this.$http.post('user/del_address', {
          user: store.fetch('user'),
          id: v.id,
        })
        .then((response) => {
          if(response.body.status == 0){
            this.user_addr = response.body.data;
          }else{
            alert(response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        })
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
          is_default: this.address_info.is_default ? '1' : '0',
        })
        .then((response) => {
          if(response.body.status == 0){
            this.user_addr = response.body.data;
            this.trigger_show_address();
          }else{
            alert(response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        })
       
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
    route:{
      data: function(){
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
      }
    },
}

</script>
