<template>
    <headpart show_item="user"></headpart>
    <!-- main start -->
    <div :class="css_public.container">
        <div class="{{css_user.page_main}}">
            <userhead user_item="info" v-bind:userinfo.sync="user_info"></userhead>
            <div :class="css_user.info_cont">
                <edit-info :user_info = user_info :css_user = css_user></edit-info>
                <edit-address :user_addr.sync = user_addr :css_user = css_user></edit-address>
            </div>          
        </div>
    </div>
    <!-- menu start -->
    <mymenu v-bind:menus.sync="menus" v-bind:show_menus.sync="show_menus"></mymenu>
    <!-- backtop start -->
    <div class="gotop"></div>
    <!-- foot start -->
    <footpart></footpart>
</template>
<script>
    import css_user from '../../static/css/user.css';
    import css_public from '../../static/css/public.css';
    import store from '../store.js';
    //其他公共组件
    import headpart from './common/header';
    import footpart from './common/footer';
    import mymenu from './common/mymenu';
    import userhead from './common/userhead';
    import editInfo from './userinfo_edit_info';
    import editAddress from './userinfo_edit_address';
    export default{
        components:{
            css_public,
            css_user,
            store,
            headpart,
            footpart,
            mymenu,
            userhead,
            editInfo,
            editAddress,
        },
        route:{
            data(){
                var user = store.fetch('user');
                this.$http.post('user/info', {user:user}).then((response) => {
                    this.user_info = response.body.data;
                    this.user_addr = this.user_info.user_addr;
                    console.log(this.user_info.user_addr)
                })
            }
        },
        ready(){
            this.css_user = css_user;
            this.css_public = css_public;
            //如果未登录跳转
            if(store.fetch('user').length == 0){
                this.$route.router.go('/login');
            }
        },
        data(){
            return {
                //我的菜单数据
                menus:[],
                //是否显示我的菜单
                show_menus:false,
                //用户信息
                user_info:[],
                //地址信息
                user_addr:[],
                css_user:{},
                css_public:{},
            }
        }
    }
</script>