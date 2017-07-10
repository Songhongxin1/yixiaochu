<template>
<div :class="css_public.header">
        <div :class="css_public.nav">
            <a href="javascript:;" :class="css_public.logo"></a>
            <ul :class="css_public.menu">
                <li><a href="javascript:;" v-link="'/home'" v-bind:class="item_home">首页</a></li>
                <li><a href="javascript:;" v-link="'/today'" v-bind:class="item_today">今日菜单</a></li>
                <li><a href="javascript:;" v-link="'/story'" v-bind:class="item_story">小厨故事</a></li>
                <li><a href="javascript:;" v-link="'/scoff'" v-bind:class="item_scoff">欢乐吐槽</a></li>
                <li><a href="javascript:;" v-link="'/userinfo'" v-bind:class="item_user">个人中心</a></li>
            </ul>
            
            <div :class="css_public.right_link" v-if="is_login">
                <a href="javascript:;" v-link="'userinfo'" :class="css_public.login"><i :class="css_public.user"></i>{{user_name}}</a>
                <a href="javascript:;" v-on:click="login_out()" :class="css_public.login"><i :class="css_public.user_out"></i>退出</a>
            </div>
            <div :class="css_public.right_link" v-else>
                <a href="javascript:;" v-link="'login'" :class="css_public.login"><i :class="css_public.user"></i>登录</a>
                <a href="javascript:;"  v-link="'reg'" :class="css_public.reg"><i :class="css_public.user1"></i>注册</a>
            </div>
        </div>
    </div>
</template>
<script>
    import store from '../../store.js';
    import css_public from '../../../static/css/public.css';
    export default{
        components:{
            css_public,
        },
        props:['show_item'],
        data(){
            return {
                is_login:false,
                user_name:'',
                css_public:{}
            }
        },
        methods:{
            login_out(){
                store.remove('user');
                store.remove('userinfo');
                this.$route.router.go('/home');
            }
        },
        ready(){
            this.css_public = css_public;
            if(store.fetch('user').length != 0){
                this.is_login = true;
                this.user_name = store.fetch('userinfo');
            }
        },
        computed:{
            item_home(){
                if(this.show_item == 'home'){
                    return this.css_public.active;
                }else{
                    return '';
                }
            },
            item_today(){
                if(this.show_item == 'today'){
                    return this.css_public.active;
                }else{
                    return '';
                }
            },
            item_story(){
                if(this.show_item == 'story'){
                    return this.css_public.active;
                }else{
                    return '';
                }
            },
            item_scoff(){
                if(this.show_item == 'scoff'){
                    return this.css_public.active;
                }else{
                    return '';
                }
            },
            item_user(){
                if(this.show_item == 'user'){
                    return this.css_public.active;
                }else{
                    return '';
                }
            }
        }
        
    }
</script>