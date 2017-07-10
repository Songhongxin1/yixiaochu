<template>
<!-- header start -->
    <headpart show_item="home"></headpart>
 <!-- main start -->
    <div :class="css_public.container">
        <div class="{{css_pay.page_main}} {{css_public.page_main}}">
            <template v-if="info.order">
            <div :class="css_pay.result_cont">
                <div :class="css_pay.title">
                    <p :class="css_pay.head">{{info.order.order_name}}</p>
                    <p v-if="info.order.status == info.config.status.no_pay.id" :class="css_pay.icon">
                         <template v-if="info.order.order_type == 3">
                             AA支付（未完成）
                         </template>
                         <template v-if="info.order.order_type != 3">
                                                                        全款支付（未完成）
                         </template>
                    </p>
                    <p v-if="info.order.status >= info.config.status.wait_send.id" :class="css_pay.icon">
                         <template v-if="info.order.order_type == 3">
                             AA支付（完成）
                         </template>
                         <template v-if="info.order.order_type != 3">
                                                                        全款支付（完成）
                         </template>
                    </p>
                    <p :class="css_pay.text">截至时间：<span>{{info.end_time}}</span></p>
                    <p :class="css_pay.r_text">订单号：{{info.order.order_number}} &nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;&nbsp;&nbsp;下单时间：{{info.order.create_time}}</p>
                </div>
                <div :class="css_pay.left_cont">
                    <template v-if="info.order.status == info.config.status.no_pay.id">
                    <img v-if="info.order.status == info.config.status.no_pay.id" v-bind:src="'../../static/images/wait.png'">
                    <p v-if="order.has_me_pay == 1"><i :class="css_pay.suce"></i>您已经完成支付</p>
                    <p v-else="order.has_me_pay == 0">您还没有完成支付</p>
                    </template>
                    <template v-if="info.order.status != info.config.status.no_pay.id">
                        <img :src="'../../static/images/success.png'">
                        <p>支付已完成</p>
                    </template>
                </div>
                <div :class="css_pay.right_cont">
                    <p :class="css_pay.l_text">配  送  至：</p>
                    <p :class="css_pay.r_cont">{{info.order.addr_str}}</p>
                    <p :class="css_pay.l_text">数&nbsp;&nbsp;&nbsp;&nbsp;  量：</p>
                    <p :class="css_pay.r_cont">1</p>
                    <p :class="css_pay.l_text">优&nbsp;&nbsp;&nbsp;&nbsp;  惠：</p>
                    <p v-if="info.order.favorable == 0" :class="css_pay.r_cont">无优惠</p>
                    <p v-if="info.order.favorable > 0" :class="css_pay.r_cont">{{info.order.favorable}}</p>
                    <p :class="css_pay.l_text">支付人员：</p>
                    <div :class="css_pay.r_cont">
                        <p v-if="info.yes != info.total">已有<span> {{info.yes}} </span>人完成支付，还有<span> {{info.total-info.yes}} </span>人未支付</p>
                        <ul>
                            <template v-for="u of info.pay_user">
                            	<li><img :src="u.head_img"><p>{{u.user_name}}</p></li>
                            </template>
                        </ul>
                    </div>
                    <template v-if="info.order.status != info.config.status.no_pay.id">
                    <p :class="css_pay.l_text">分&nbsp;&nbsp;&nbsp;&nbsp;  享：</p>
                    <p :class="css_pay.r_cont">
                        <a href="javascript:;" :class="css_pay.qq" title="&#x5206;&#x4EAB;&#x5230;QQ"></a>
                        <a href="javascript:;" :class="css_pay.weix" title="&#x5206;&#x4EAB;&#x5230;&#x5FAE;&#x4FE1;"></a>
                    </p>
                    </template>
                </div>
            </div>
            </template>
            <p :class="css_pay.pay_title">菜品信息</p>
            <ul :class="css_pay.pay_lists">
                <template v-for="v of info.foods">
                <li>
                    <img :src="v.cover_img">
                    <div :class="css_pay.info">
                        <p :class="css_pay.title">{{v.foods_name}}<span>{{v.foods_description}}</span></p>
                        <div :class="css_pay.cont">
                            <p :class="css_pay.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;材：</p>
                            <p :class="css_pay.r_text">{{v.food_material}}</p>
                            <p :class="css_pay.l_text">营养价值：</p>
                            <p :class="css_pay.r_text">{{v.nutritive_value}}</p>
                        </div>
                        <div :class="css_pay.bot">
                            <p :class="css_public.l">已售  {{v.sell_number}}</p>
                            <p :class="css_public.r"><span>赞  9</span>&nbsp;&nbsp;|&nbsp;&nbsp;评价 9&nbsp;&nbsp;|&nbsp;&nbsp;分享  9</p>
                        </div>
                    </div>
                </li>
               </template>
            </ul>
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
import css_pay from '../../static/css/pay.css';
import store from '../store.js';
//引入公共头部和尾部
import footpart from './common/footer';
import headpart from './common/header';
import mymenu from './common/mymenu';

export default {
    components:{
        css_pay,
        css_public,
        footpart,
        headpart,
        mymenu,
        store
    },
    route:{
        data(){
            //初始化css对象
            this.css_public = css_public;
            this.css_pay = css_pay;
            var temp_id = this.$route.params.id;
            var user = store.fetch('user');
			this.$http.post('order/get_order_info_by_id',{id:temp_id,user:user}).then(response => {
               		this.$set('info', response.data.data)
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
        moveR(){}
    },
    data(){
        return {
            menus_list:[],
            menus:[],
            show_menus:false,
            css_public:{},
            css_pay:{},
            id:0,
            info:{}
        }
    },
}

</script>
















