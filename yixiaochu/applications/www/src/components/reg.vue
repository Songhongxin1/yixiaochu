<template>
    <!-- header start -->
    <headpart show_item="user"></headpart>

    <!-- main start -->
    <div :class="css_public.container">
        <div :class="css_login.reg_cont">
            <ul>
                <li>
                    <label>用户昵称</label>
                    <input type="text" v-model='nickname' placeholder="请输入您的用户昵称" >
                    <span :class="css_login.errormessage">{{{message.nickname}}}</span>
                </li>
                
                <li>
                    <label>手机号</label>
                    <input type="text" v-model="phone" placeholder="请输入您的手机号" >
                    <span :class="css_login.errormessage">{{{message.phone}}}</span>
                </li>

                <li>
                    <label>创建密码</label>
                    <input type="password" v-model='password' placeholder="&#x8BF7;&#x8BBE;&#x5B9A;&#x60A8;&#x7684;&#x5BC6;&#x7801;">
                    <span :class="css_login.errormessage">{{{message.password}}}</span>
                </li>
                <li>
                    <label>确认密码</label>
                    <input type="password" v-model='rePassword' placeholder="&#x8BF7;&#x518D;&#x6B21;&#x8F93;&#x5165;&#x60A8;&#x7684;&#x5BC6;&#x7801;">
                    <span :class="css_login.errormessage">{{{message.rePassword}}}</span>
                </li>
                <li>
                    <label>验证码</label>
                    <input type="text" v-model='code' placeholder="&#x8BF7;&#x8F93;&#x5165;&#x624B;&#x673A;&#x9A8C;&#x8BC1;&#x7801;">
                    <a href="javascript:;" v-if="!isSendCode" @click="sendCode" :class="css_login.code">获取验证码</a>
                    <a href="javascript:;" v-if="isSendCode" :class="css_login.code">{{{codeTips}}}</a>
                    <span :class="css_login.errormessage">{{{message.code}}}</span>
                </li>
            </ul>
            <p :class="css_login.message" v-if="isSendCode"><i :class="isErr ? css_login.err : '' "></i><span>{{{message.serviceReturn}}}</span></p>
            <a href="javascript:;" :class="css_login.submit" @click="reg">立即注册</a>
        </div>
    </div>
    
    
    <!-- footer start -->
    <footpart></footpart>
</template>

<script>
import css_public from '../../static/css/public.css';
import css_login from '../../static/css/login.css';
import headpart from './common/header';
import footpart from './common/footer';
import store from '../store.js';
export default {
    components:{
        headpart,
        footpart
    },
    route:{
        data(transition){
            //transition.redirect('home')
        }
    },
    data(){
        return {
            isSendCode: false,
            isErr: true,
            nickname: '',
            password: '',
            phone:'',
            code:'',
            codeTips:'60秒后可重新获取',
            count: 5,
            message: {
              nickname: '',
              phone: '',
              password: '',
              rePassword: '',
              code: '',
              serviceReturn: '',
            },
            css_public:{},
            css_login:{},
        }
    },
    compiled(){
    },
    ready(){
        this.css_login = css_login;
        this.css_public = css_public;
        //如果已登录跳转
        if(store.fetch('user').length != 0){
            this.$route.router.go('home');
        }
    },
    methods:{
        checkInput: function(){
            if(this.nickname == ''){
              this.message.nickname = '用户昵称不能为空';
              return;
            }else{
                this.message.nickname = '';
            }
            
            let isMobile=/^1[3|4|5|8|7][0-9]\d{8}$/;
            if(!isMobile.test(this.phone)){
                this.message.phone = '请填写正确的手机号';
                return;
            }else{
                this.message.phone = '';
            }
            
            if(this.password == ''){
                this.message.password = '密码不能为空';
                return;
            }else{
                this.message.password = '';
            }
    
            if(this.password != this.rePassword){
                this.message.rePassword = '两次输入的密码不一致';
                return;
            }else{
                this.message.rePassword = '';
            }
            return true;
        },
        //登录
        reg: function(){
            if(!this.checkInput()){
                return 
            }
            if(this.code.length != 6){
                this.message.code = '请输入正确的验证码';
                return;
            }else{
                this.message.code = '';
            }
            
            this.$http.post('passport/check_reg', {
                nickname: this.nickname,
                user_phone: this.phone,
                re_password: this.rePassword,
                password: this.password,
                tel_verify: this.code,
            })
            .then((response) => {
                if(response.body.status == 0){
                    this.message.serviceReturn = response.body.msg;
                    this.isErr = false;
                    store.save(response.body.data.user, 'user');
                    store.save(response.body.data.userinfo, 'userinfo');
                    this.$route.router.go('home');
                }else{
                    this.message.serviceReturn = response.body.msg;
                    this.isErr = true;
                }
            })
            .catch(function(error) {
                this.message.serviceReturn = '网络异常，请稍后再试！';
                this.isErr = true;
            })
            this.isSendCode = true;
        },

        sendCode: function(){
            if(!this.checkInput()){
                return 
            }
            this.$http.post('publicservice/mobile_code', {
                mobile: this.phone,
            })
            .then((response) => {
              console.log(response);
                if(response.body.status == 0){
                    this.message.serviceReturn = response.body.msg;
                    this.isErr = false;
                }else{
                    this.message.serviceReturn = response.body.msg;
                    this.isErr = true;
                }
            })
            .catch(function(error) {
                this.message.serviceReturn = '网络异常，请稍后再试！';
                this.isErr = true;
            })
            this.isErr = false;
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
    }
}
</script>
