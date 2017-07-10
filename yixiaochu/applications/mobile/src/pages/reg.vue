<template>
    <div :class="css_login.mainfix">
    <img src="../../static/images/logo.png" :class="css_login.logo">
    <ul>
        <li>
            <label>手机号</label>
            <input type="text" v-model="phone" placeholder="&#x8BF7;&#x8F93;&#x5165;&#x624B;&#x673A;&#x53F7;">
        </li>
        <li>
            <label>密码</label>
            <input type="password" v-model='password' placeholder="&#x8BF7;&#x8BBE;&#x7F6E;&#x5BC6;&#x7801;">
        </li>
        <li>
            <label>验证码</label>
            <input type="text" v-model='code' placeholder="&#x8BF7;&#x8F93;&#x5165;&#x9A8C;&#x8BC1;&#x7801;">
        </li>
        <li>
          <a href="javascript:;" :class="css_login.code" v-if="!isSendCode" @click="getCode">获取验证码</a>
          <a href="javascript:;" v-if="isSendCode" :class="css_login.code">{{codeTips}}</a>
        </li>
        
    </ul>
    <a href="javascript:;" :class="css_login.submit" @click="reg">立即注册</a>
    
    </div>
</template>



<script>
import css_login from '../../static/css/login.css';
import store from '../store.js';

export default {
    components: {
      css_login,
    },
    created(){
    },
    data(){
        return {
            css_login: {},
            isSendCode: false,
           
            password: '',
            phone:'',
            code:'',
            codeTips:'60秒后可重新获取',
            count: 5,
        }
    },
    ready(){
       this.css_login = css_login;
       //如果已登录跳转
       if(store.fetch('user').length != 0){
           this.$route.router.go('home');
       }
    },
    methods:{
      checkInput: function(){
         
          let isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
          if(!isMobile.test(this.phone)){
              alert('请填写正确的手机号');
              return;
          }
          
          if(this.password == ''){
            alert('密码不能为空'); 
              return;
          }

          return true;
      },
    //注册
      reg: function(){
          if(!this.checkInput()){
              return 
          }
          if(this.code.length != 6){
              alert('请输入正确的验证码');
              return;
          }
          if(!this.isSendCode){
              alert('请先获取验证码！');
              return;
          }
          
          this.$http.post('passport/check_reg', {
              user_phone: this.phone,
              password: this.password,
              tel_verify: this.code,
          })
          .then((response) => {
              if(response.body.status == 0){
                  alert( response.body.msg);
                  store.save(response.body.data.user, 'user');
                  store.save(response.body.data.userinfo, 'userinfo');
                  this.$route.router.go('home');
              }else{
                  alert( response.body.msg);
              }
          })
          .catch(function(error) {
              alert('网络异常，请稍后再试！');
          })
          this.isSendCode = true;
      },

      getCode: function(){
          if(!this.checkInput()){
              return 
          }
          this.$http.post('publicservice/mobile_code', {
              mobile: this.phone,
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
          })
          
          this.isSendCode = true;
          let second = 59; // second秒后可重新获取短信
          let int = setInterval(()=>{
              if (second > 0){
                this.codeTips = second +'秒后可重新获取';
                second--;
              }else {
                  this.isSendCode = false;
                  this.codeTips = '60秒后可重新获取';
                  clearInterval(int);
              }
          }, 1000);
      }
    },
    watch:{
       
    },

}

</script>
