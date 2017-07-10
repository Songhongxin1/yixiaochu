<template>
    <div :class="css_login.mainfix">
        <img src="../../static/images/logo.png" :class="css_login.logo">
        <div :class="[css_login.input_cont, css_login.name]"><i></i><input type="text" v-model="phone" placeholder="&#x8D26;&#x53F7;"></div>
        <div :class="[css_login.input_cont, css_login.pass]"><i></i><input type="password" v-model="password" placeholder="&#x5BC6;&#x7801;"></div>
        <a href="javascript:;" :class="css_login.submit" @click="login">登录</a>
        <p :class="css_login.message">错误提示</p>
        <div :class="css_login.but_cont">
            <a href="javascript:;" :class="css_login.qq">QQ登录</a>
            <span>OR</span>
            <a href="javascript:;" :class="css_login.weix">微信登录</a>
        </div>
        <p :class="css_login.text"><a href="javascript:;" :class="css_login.l">忘记密码？</a><a href="javascript:;" :class="css_login.r">立即注册</a></p>
    </div>
</template>

<script>
import css_login from '../../static/css/login.css';
import store from '../store.js';

export default {
    components: {
      css_login,
    },
    data(){
        return {
            css_login: {},
            phone:'',
            password:'',
            message:'',

        }
    },
    mounted(){
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
      
      login(){
        if(!this.checkInput()){
            return 
        }
        this.$http.post('passport/login', {
            name: this.phone,
            password: this.password,
        })
        .then((response) => {
            if(response.body.status == 0){
                alert( response.body.msg);
                store.save(response.body.data.user, 'user');
                store.save(response.body.data.userinfo, 'userinfo');
                this.$route.push('home');
            }else{
                alert( response.body.msg);
            }
        })
        .catch(function(error) {
            alert('网络异常，请稍后再试！');
        })
        
      },
   
    },
    watch:{
       
    },

}

</script>

