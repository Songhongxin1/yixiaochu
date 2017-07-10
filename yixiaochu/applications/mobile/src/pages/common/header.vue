<template>
    <div v-if="!title" :class="css_wap.header"></div>
    
    <div v-else :class="[css_wap.header, css_wap.head]">
        <a href="javascript:history.go(-1);" :class="css_wap.go_back"></a>
        <div :class="css_wap.head_title">{{title}}</div>
        <div  :class="css_wap.menu_but" @click="show_triggle">
          <ul  v-show="is_show" :class="css_wap.menu_list" >
            <li><a href="javascript:;">订餐首页</a></li>
            <li><a href="javascript:;">我的菜单</a></li>
            <li><a href="javascript:;">小厨故事</a></li>
            <li><a href="javascript:;">欢乐吐槽</a></li>
            <li><a href="javascript:;">个人中心</a></li>
          </ul>
        </div>
    </div>
</template>
<script>
    import store from '../../store.js';
    import css_wap from '../../../static/css/wap.css';
    export default{
        components:{
            css_wap,
        },
        props:['title', 'show_more'],
        data(){
            return {
                is_login:false,
                user_name:'',
                css_wap:{},
                is_show: false,
            }
        },
        methods:{
            login_out(){
                store.remove('user');
                store.remove('userinfo');
                this.$route.router.go('/home');
            },
            show_triggle (){
              this.is_show = !this.is_show;
            },
        },
        mounted(){
            this.css_wap = css_wap;
            if(store.fetch('user').length != 0){
                this.is_login = true;
                this.user_name = store.fetch('userinfo');
            }
        },
        
    }
</script>