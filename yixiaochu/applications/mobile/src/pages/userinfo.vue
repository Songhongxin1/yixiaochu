<template>
<div>
    <headpart title="个人中心"></headpart>
    
    <div :class="css_wap.mainfix">
        <template v-if="!is_edit">
          <ul :class="[css_user.user_list, css_user.info_cont]" >
              <li><p>头像</p><img :src="user_info.head_img_url"></li>
              <li><p>昵称</p><p>{{user_info.nickname}}</p></li>
              <li><p>姓名</p><p>{{user_info.user_name}}</p></li>
              <li><p>电话</p><p>{{user_info.user_phone}}</p></li>
              <li><p>性别</p><p>{{user_info.sex==1?'男':'女'}}</p></li>
              <!--li><p>生日</p><p>1990年08月08日</p></li-->
           </ul>
           <a href="javascript:;" :class="css_user.submit" @click="trigger_edit">修改资料</a>
         </template>
         
         <template v-if="is_edit">
           <ul :class="[css_user.user_list, css_user.info_cont]" >
               <li>
                   <p>头像</p>
                   <img :src="user_info.head_img_url" >

               </li>
               <li><p>昵称</p><input type="text" v-model="user_info.nickname" placeholder="&#x8BF7;&#x8F93;&#x5165;&#x60A8;&#x7684;&#x6635;&#x79F0;"></li>
               <li><p>姓名</p><input type="text" v-model="user_info.user_name" placeholder="&#x8BF7;&#x8F93;&#x5165;&#x60A8;&#x7684;&#x771F;&#x5B9E;&#x59D3;&#x540D;"></li>
               <li><p>电话</p><input type="tel" v-model="user_info.user_phone" placeholder="&#x8BF7;&#x8F93;&#x5165;&#x60A8;&#x7684;&#x624B;&#x673A;&#x53F7;"></li>
               <li><p>性别</p><label><input type="radio" v-model="user_info.sex" value="1">男</label><label><input type="radio" v-model="user_info.sex" value="0">女</label></li>
               <!--li>
                 <p>生日</p>
                 <select>
                   <option>1990</option>
                 </select>年
                 <select>
                   <option>08</option>
                 </select>月
                 <select>
                   <option>08</option>
                 </select>日
               </li-->
            </ul>
            <a href="javascript:;" :class="css_user.submit" @click="save">保存</a>
          </template>
    </div>

    <footpart current = "user" ></footpart>
</div>
</template>

<style>

</style>

<script>
import css_wap from '../../static/css/wap.css';
import css_user from '../../static/css/user.css';
import headpart from './common/header';
import footpart from './common/footer';
import store from '../store.js';

export default {
    components:{
      css_wap,
      css_user,
      headpart,
      footpart,

      
    },
    created(){
    },
    data(){
      return {
        css_wap: {},
        css_user: {},
        single_foods: {},
        combo_foods: {},
        shopping_car:{
          single: [],
          combo: [],
        },
        //用户信息
        user_info:[],
        is_edit: false,
        files:[],

      }
    },
    computed: {
      
    },
    mounted(){
       this.css_wap = css_wap;
       this.css_user = css_user;
       
       if(store.fetch('user').length != 0){
         
         let user = store.fetch('user');
         this.$http.post('user/info', {
           user: user,
         })
         .then((response) => {
           if(response.body.status == 0){
             this.user_info = response.body.data;
           }else{
             //alert( response.body.msg);
           }
         })
         .catch(function(error) {
           alert('网络异常，请稍后再试！');
         });
       }else{
           this.$route.push('login');
           return;
       }
    },
    methods:{
      trigger_edit: function(){
        this.is_edit = !this.is_edit;
      },
      save: function(){
        this.$http.post('user/save_info', {
          user: store.fetch('user'),
          head_img: this.user_info.head_img_url,
          nickname: this.user_info.nickname,
          user_name: this.user_info.user_name,
          sex: this.user_info.sex,
        })
        .then((response) => {
          if(response.body.status == 0){
            alert(response.body.msg);
            this.trigger_edit();
          }else{
            alert(response.body.msg);
          }
        })
        .catch(function(error) {
          alert('网络异常，请稍后再试！');
        });
        
      },
    },


}
</script>