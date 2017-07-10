<template>
    <!-- header start -->
    <headpart show_item="user"></headpart>

    <!-- main start -->
    <div :class="css_public.container">
        <div :class="css_login.login_cont">
            <div :class="css_login.advent"><img src="../../static/images/login.jpg"></div>
            <div :class="css_login.login_form">
                <p :class="css_login.itle">账户登录</p>
                <div :class="css_login.input_cont"><i class="name"></i><input type="text" v-model="name" placeholder="&#x8BF7;&#x8F93;&#x5165;&#x7528;&#x6237;&#x540D;"></div>
                <div :class="css_login.input_cont"><i :class="css_login.password"></i><input type="password" v-model="password" placeholder="&#x8BF7;&#x8F93;&#x5165;&#x5BC6;&#x7801;"></div>
                <p :class="css_login.text"><a href="javascript:;">忘记登录密码</a><a href="javascript:;" v-link="'reg'" :class="css_login.reg">免费注册</a></p>
                <p :class="css_login.message">{{{message}}}</p>
                <a href="javascript:;" :class="css_login.submit" v-on:click="login">登录</a>
                <p :class="css_login.other">
                    <span>其他登录方式：</span>
                    <a href="javascript:;" v-link="'home'" :class="css_login.weibo" title="&#x5FAE;&#x535A;&#x767B;&#x5F55;"></a>
                    <a href="javascript:;" :class="css_login.qq" title="QQ&#x767B;&#x5F55;"></a>
                    <a href="javascript:;" :class="css_login.weix" title="&#x5FAE;&#x4FE1;&#x767B;&#x5F55;"></a>
                </p>
            </div>
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
            css_public,
            css_login,
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
                name:'',
                password:'',
                message:'',
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
            //登录
            login(){
                this.$http.post('passport/login', {name:this.name,password:this.password}).then((response)=>{
                	if(response.body.status == 0){
                        store.save(response.body.data.user, 'user');
                        store.save(response.body.data.userinfo, 'userinfo');
                        this.$route.router.go('home');
                    }else{
                        this.message=response.body.msg;
                    }
                })
            }
        }
    }
</script>
