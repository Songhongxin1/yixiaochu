<template>
<!-- header start -->
    <headpart show_item="home"></headpart>
<!-- main start -->
    <div :class="css_public.container">
        <div class="{{css_pay.page_main}} {{css_public.page_main}}">
            <p :class="css_pay.pay_title">全款支付</p> 
            <div :class="css_pay.pay_result">
                <div :class="css_pay.top_text">
                    <p>全款支付：这里是全款支付简介  这里是全款支付简介  这里是全款支付简介  这里是全款支付简介</p>
                    <p>这里是全款支付简介  这里是全款支付简介</p>
                </div>
                <div :class="css_pay.left_cont">
                    <img :src="temp/ewm1.jpg">
                    <p>微信扫描上方二维码，完成支付</p>
                </div>
                <div :class="css_pay.right_cont">
                    <p :class="css_pay.title">支付完成立即开始配送</p>
                    <p>付款倒计时<span :class="css_pay.t_grey">（超时未付款，订单自动取消）</span>：<span class="t-green">01：00：00</span></p>
                    <p :class="css_pay.t_center">送餐地址：重庆 重庆市 南岸区 海棠溪街道学府大道16号附24号(电话:02363218601)（ 张三 收） 18285164522    </p>
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
            console.log(css_pay.page_main)
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
            css_pay:{}
        }
    },
}

</script>
















