<template>
<!-- header start -->
    <headpart show_item="user"></headpart>
<!-- main start -->
    <div :class="css_public.container">
        <div class="{{css_user.page_main}} {{css_public.page_main}}">
            <userhead user_item="user_point" v-bind:userinfo.sync="user_info"></userhead>
            <div :class="css_user.chose_nav">
                <a @click="all()" :class="{[css_user.act]: current == 'default'}">我的积分</a>
                <a @click="shou()" :class="{[css_user.act]: current == 'income'}">积分收入</a>
                <a @click="zhi()"  :class="{[css_user.act]: current == 'payout'}">积分支出</a>
            </div>
            <div :class="css_user.point_cont">
                <p :class="css_user.nav">
                    <span :class="css_user.cont1">来源/用途</span>
                    <span :class="css_user.cont2">积分变化</span>
                    <span :class="css_user.cont3">日期</span>
                    <span :class="css_user.cont4">备注</span>
                </p>
                <ul>
                    <template v-for="v of info.list">
                    <li>
                        <img :src="v.cover_img">
                        <div :class="css_user.cont">
                            <p :class="css_user.info">{{v.detail_name}}</p>
                        </div>
                        <p v-if="v.spend_score > 0" class="{{css_user.grade}} {{css_user.add}}">+{{v.spend_score}}</p>
                        <p v-if="v.spend_score <= 0" class="{{css_user.grade}} {{css_user.subtract}}">{{v.spend_score}}</p>
                        <p :class="css_user.date">{{v.create_time}}</p>
                        <p :class="css_user.text">{{v.info}}</p>
                    </li>
                   </template>
                </ul>
                <div :class="css_user.page_cont">
                    <div :class="css_user.pages">
                      <a href="javascript:;" :class="css_user.prve" v-on:click="back(a_act)"><</a>                      
                      <template v-for="v of info.link" v-if="v <= info.count">
                      <a href="javascript:;" v-if="a_act == v" :class="css_user.act" v-on:click="page(v)">{{v}}</a>
                      <a href="javascript:;" v-else="a_act != v" v-on:click="page(v)">{{{v}}}</a>
                      </template>
                      <a href="javascript:;" v-on:click="next(a_act)">></a>
                      <span>共{{info.count}}页，去第</span>
                      <input type="text" value="2" v-model="jump">
                      <span>页</span>
                      <button v-on:click="jumpto(jump)">确定</button>
                    </div>
                </div>
            </div>          

        </div>
    </div>
    <!-- menu start -->
    <mymenu v-bind:menus.sync="menus" v-bind:show_menus.sync="show_menus"></mymenu>
    <!-- backtop start -->
    <div :class="css_pay.gotop"></div>
    
    <!-- footer start -->
    <footpart></footpart>
    
</template>

<script>
import css_public from '../../static/css/public.css';
import css_user from '../../static/css/user.css';
import store from '../store.js';
//引入公共头部和尾部
import footpart from './common/footer';
import headpart from './common/header';
import mymenu from './common/mymenu';
import userhead from './common/userhead';
export default {
    components:{
        css_user,
        css_public,
        footpart,
        headpart,
        mymenu,
        store,
        userhead
    },
    route:{
        data(){
            //初始化css对象
            this.css_public = css_public;
            this.css_user = css_user;
            var user = store.fetch('user');
                this.$http.post('user/info', {user:user}).then((response) => {
                    this.user_info = response.body.data;
                })

            //获取api数据，默认是第一页
            this.$http.post('user/my_point', {user:user,page:this.a_act}).then(response => {
                this.$set('info', response.data.data);
                this.$set('a_act',this.a_act);
            });
        }
        
    },
    ready(){
            //如果未登录跳转
            if(store.fetch('user').length == 0){
                this.$route.router.go('/login');
            }
        },
    methods:{
        //菜品向右移动
        moveR(){},
        //点击页码
        page(k){
            this.get_list(k)
        },
        //上一页
        back(k){
            if(k>=1){
                this.get_list(k-1);
            }
        },
        //下一页
        next(k){
            if(k < this.info.count){
                this.get_list(k+1);
            }
        },
        //跳转到
        jumpto(k){
            if(k>=1 && k <= this.info.count){
                this.get_list(k);
            }
        },
        get_list(k){
            var user = store.fetch('user');
            if(this.jian == 1){
              var obj = {user:user,page:k,jian:1};
            }else if(this.jia == 1){
                var obj = {user:user,page:k,jia:1};
            }else{
                var obj = {user:user,page:k};
            }
            this.$http.post('user/my_point', obj).then( response => {
                this.$set('info', response.data.data);
                this.$set('a_act',k);
            });
        },
        all(){
          this.$set('current','default');//设置class 为 active
          this.$set('a_act',1);//初始化页码
          this.$set('jian',0);
          this.$set('jia',0);
          var user = store.fetch('user');
          this.get_list(this.a_act);
        },
        shou(){
            this.$set('current','income'); //设置class 为 active
            this.$set('a_act',1);//初始化页码
            this.$set('jia',1);
            this.$set('jian',0);
            var user = store.fetch('user');
            this.get_list(this.a_act);
        },
        zhi(){
            
            this.$set('current','payout');//设置class 为 active
            this.$set('a_act',1);//初始化页码
            this.$set('jian',1);
            this.$set('jia',0);
            var user = store.fetch('user');
            this.get_list(this.a_act);
        }
    },
    data(){
        return {
            menus_list:[],
            menus:[],
            show_menus:false,
            css_public:{},
            css_user:{},
            info:{},
            user_info:[],
            a_act:1,//连接获得焦点
            jump:'',
            jian:0,
            jia:0,
            current: 'default',
        }
    },
}

</script>
















