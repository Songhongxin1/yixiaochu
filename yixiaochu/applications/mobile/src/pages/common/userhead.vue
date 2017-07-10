<template>
    <div :class="css_user.banner">
                <img v-if="user_info.head_img_url" v-bind:src="userinfo.head_img_url">
                <img v-else src="../../../static/images/head.jpg"/>
                <p :class="css_user.name">{{userinfo.user_name}}</p>
                <p :class="css_user.text"><i></i>个人积分<span>{{userinfo.score}}</span></p>
            </div>
        
            <div :class="css_user.user_nav">
                <a href="javascript:;" :class="user_order" v-link="'user_order'">我的订单</a>
                <a href="javascript:;" :class="user_score" v-link="'user_point'">我的积分</a>
                <a href="javascript:;" :class="user_info" v-link="'userinfo'">个人资料</a>
            </div>
</template>

<script>
    import css_user from '../../../static/css/user.css';
    export default{
        props:['user_item', 'userinfo'],
        components:{
            css_user,
        },
        data(){
            return {
                css_user
            }
        },
        mounted(){
            this.css_user = css_user;
        },
        computed:{
            'user_order':function(){
                if(this.user_item == 'user_order'){
                    return this.css_user.act;
                }else{
                    return '';
                }
            },
            'user_score':function(){
                if(this.user_item == 'user_point'){
                    return this.css_user.act;
                }else{
                    return '';
                }
            },
            'user_info':function(){
                if(this.user_item == 'info'){
                    return this.css_user.act;
                }else{
                    return '';
                }
            }
        }
    }
</script>