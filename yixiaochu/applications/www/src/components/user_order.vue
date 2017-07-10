<template>
<!-- header start -->
    <headpart show_item="userinfo"></headpart>
    <!-- main start -->
    <div :class="css_public.container">
        <div class="{{css_user.page_main}} {{css_public.page_main}}">
            <userhead user_item="user_order" v-bind:userinfo.sync="user_info"></userhead>
            <div :class="css_user.chose_nav">
                <a v-if="code == order.order_status.no_pay.id" v-on:click="change(order.order_status.no_pay.id)" :class="css_user.act" >{{order.order_status.no_pay.name}}</a>
                <a v-else="code != order.order_status.no_pay.id" v-on:click="change(order.order_status.no_pay.id)" >{{order.order_status.no_pay.name}}</a>
                <a v-if="code == order.order_status.wait_send.id" v-on:click="change(order.order_status.wait_send.id)" :class="css_user.act">{{order.order_status.wait_send.name}}</a>
                <a v-else="code != order.order_status.wait_send.id" v-on:click="change(order.order_status.wait_send.id)" >{{order.order_status.wait_send.name}}</a>
                <a v-if="code == order.order_status.sended.id" v-on:click="change(order.order_status.sended.id)" :class="css_user.act">{{order.order_status.sended.name}}</a>
                <a v-else="code != order.order_status.sended.id" v-on:click="change(order.order_status.sended.id)">{{order.order_status.sended.name}}</a>
                <a v-if="code == order.order_status.sured.id" v-on:click="change(order.order_status.sured.id)" :class="css_user.act">{{order.order_status.sured.name}} (完成)</a>
            	<a v-else="code != order.order_status.sured.id" v-on:click="change(order.order_status.sured.id)">{{order.order_status.sured.name}} (完成)</a>
            </div> 
            <!--套餐全款-->
            <template v-for="o of order.info">
            <template v-if="o.order_type == order.order_type.combo.id && code == o.status && del_id != o.id && o.pay_type != order.pay_type.aapay.id">
            <p :class="css_user.order_title">订单号：{{o.order_number}}<template v-if="o.status == order.order_status.no_pay.id"><a href="javascript:;" v-on:click="del(o.id)"><i :class="css_user.del"></i>删除</a></template></p>
            <div :class="css_user.peoples_list">
                <template v-for="f of o.foods">
                <div :class="css_user.cont">
                    <p :class="css_user.title">{{f.order_name}}<span>全款支付</span></p>
                    <div :class="css_user.slider">
                        <template v-for="ov of f.foods_detail">
                        <div :class="css_user.slide"><img :src="ov.cover_img">{{ov.foods_name}}</div>
                        </template>
                    </div>
                </div>
                <div :class="css_user.num">
                    <p :class="css_user.head">数量</p>
                    <p :class="css_user.text">{{f.buy_number}}</p>
                </div>
                <div :class="css_user.discount">
                    <p :class="css_user.head">优惠</p>
                    <p v-if="o.favorable>0" :class="css_user.text">{{o.favorable}}</p>
                    <p v-else="o.favorable==0" :class="css_user.text">无优惠</p>
                </div>
                <div :class="css_user.price_cont">
                    <p :class="css_user.head">价格</p>
                    <p :class="css_user.price">￥{{o.need_pay}}</p>
                    <a href="/order_detail/{{o.id}}" :class="css_user.but">查看详情</a>
                    <a href="javascript:;" :class="css_user.ing">等待支付...</a>
                </div>
                </template>
            </div>
            </template>
            </template>
            <!--单份 全款-->
            <template v-for=" d of order.info">
            <template v-if="d.order_type == order.order_type.single.id && code == d.status && del_id != d.id && d.pay_type != order.pay_type.aapay.id ">
            <p :class="css_user.order_title">订单号：{{d.order_number}}<template v-if="d.status == order.order_status.no_pay.id"><a href="javascript:;" v-on:click="del(d.id)"><i :class="css_user.del"></i>删除</a></template></p>
            <ul :class="css_user.order_lists">
                <template v-for="f of d.foods">
                <li>
                    <template v-for="n of f.foods_detail">
                    <div :class="css_user.cont">
                        <img :src="n.cover_img">
                        <div :class="css_user.brife">
                            <p :class="css_user.title">{{n.foods_name}}<span>全款支付</span></p>
                            <p :class="css_user.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;材：</p>
                            <p :class="css_user.r_text">{{n.food_material}}</p>
                        </div>
                    </div>
                    <div :class="css_user.num">
                        <p :class="css_user.head">数量</p>
                        <p :class="css_user.text">{{f.buy_number}}</p>
                    </div>
                    <div :class="css_user.discount">
                        <p :class="css_user.head">优惠</p>
                        
                        <p v-if="d.favorable>0" :class="css_user.text">￥{{d.favorable}}</p>
                        <p v-else="d.favorable <=0" :class="css_user.text">无优惠</p>
                    </div>
                    <div :class="css_user.price_cont">
                        <p :class="css_user.head">价格</p>
                        <p :class="css_user.price">￥{{f.pay_price}}</p>
                    </div>
                    </template>
                </li>
                </template>
                <div :class="css_user.bot">
                    <a href="/order_detail/{{d.id}}" :class="css_user.but">订单详情</a>
                    <a v-if="code == order.order_status.no_pay.id" href="javascript:;" :class="css_user.ing">等待支付</a>
                    <a v-if="code == order.order_status.wait_send.id" href="javascript:;" :class="css_user.ing">等待发货</a>
                    <a v-if="code == order.order_status.sended.id" href="javascript:;" :class="css_user.ing">正在配送</a>
                    <a v-if="code == order.order_status.sured.id" href="javascript:;" :class="css_user.finish">订单已完成</a>
                    <p :class="css_user.conct">总计：<span>￥{{d.need_pay}}</span></p>
                </div>
            </ul>
            </template>
            </template>
            <!--套餐aa-->
            <template v-for="o of order.info">
            <template v-if="o.order_type == order.order_type.combo.id && code == o.status && del_id != o.id && o.pay_type == order.pay_type.aapay.id">
            <p :class="css_user.order_title">订单号：{{o.order_number}}<template v-if="o.status == order.order_status.no_pay.id"><a href="javascript:;" v-on:click="del(o.id)"><i :class="css_user.del"></i>删除</a></template></p>
            <div :class="css_user.peoples_list">
                <template v-for="f of o.foods">
                <div :class="css_user.cont">
                    <p :class="css_user.title">{{f.order_name}}<span>{{order.pay_type.aapay.name}}</span></p>
                    <div :class="css_user.slider">
                        <template v-for="ov of f.foods_detail">
                        <div :class="css_user.slide"><img :src="ov.cover_img">{{ov.foods_name}}</div>
                        </template>
                    </div>
                </div>
                <div :class="css_user.num">
                    <p :class="css_user.head">数量</p>
                    <p :class="css_user.text">{{f.buy_number}}</p>
                </div>
                <div :class="css_user.discount">
                    <p :class="css_user.head">优惠</p>
                    <p v-if="o.favorable>0" :class="css_user.text">{{o.favorable}}</p>
                    <p v-else="o.favorable==0" :class="css_user.text">无优惠</p>
                </div>
                <div :class="css_user.price_cont">
                    <p :class="css_user.head">价格</p>
                    <p :class="css_user.price">￥{{o.need_pay}}</p>
                    <a href="/order_detail/{{o.id}}" :class="css_user.but">查看详情</a>
                    <div v-if="o.count > 0" :class="css_user.statu">还有<span>{{o.count}}</span>人未付款</div>
                    <a v-if="code == order.order_status.wait_send.id" href="javascript:;" :class="css_user.ing">等待发货</a>
                    <a v-if="code == order.order_status.sended.id" href="javascript:;" :class="css_user.ing">正在配送</a>
                    <a v-if="code == order.order_status.sured.id" href="javascript:;" :class="css_user.finish">订单已完成</a>
                </div>
                </template>
            </div>
            </template>
            </template>
            <!--单份aa-->
            <template v-for=" d of order.info">
            <template v-if="d.order_type == order.order_type.single.id && code == d.status && del_id != d.id && d.pay_type == order.pay_type.aapay.id ">
            <p :class="css_user.order_title">订单号：{{d.order_number}}<template v-if="d.status == order.order_status.no_pay.id"><a href="javascript:;" v-on:click="del(d.id)"><i :class="css_user.del"></i>删除</a></template></p>
            <ul :class="css_user.order_lists">
                <template v-for="f of d.foods">
                <li>
                    <template v-for="n of f.foods_detail">
                    <div :class="css_user.cont">
                        <img :src="n.cover_img">
                        <div :class="css_user.brife">
                            <p :class="css_user.title">{{n.foods_name}}<span>{{order.pay_type.aapay.name}}</span></p>
                            <p :class="css_user.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;材：</p>
                            <p :class="css_user.r_text">{{n.food_material}}</p>
                        </div>
                    </div>
                    <div :class="css_user.num">
                        <p :class="css_user.head">数量</p>
                        <p :class="css_user.text">{{f.buy_number}}</p>
                    </div>
                    <div :class="css_user.discount">
                        <p :class="css_user.head">优惠</p>
                        
                        <p v-if="d.favorable>0" :class="css_user.text">￥{{d.favorable}}</p>
                        <p v-else="d.favorable <=0" :class="css_user.text">无优惠</p>
                    </div>
                    <div :class="css_user.price_cont">
                        <p :class="css_user.head">价格</p>
                        <p :class="css_user.price">￥{{f.pay_price}}</p>
                    </div>
                    </template>
                </li>
                </template>
                <div :class="css_user.bot">
                    <a href="/order_detail/{{d.id}}" :class="css_user.but">订单详情</a>
                    <div v-if="d.count > 0" :class="css_user.statu">还有<span>{{d.count}}</span>人未付款</div>
                    <a v-if="code == order.order_status.no_pay.id" href="javascript:;" :class="css_user.ing">等待支付</a>
                    <a v-if="code == order.order_status.wait_send.id" href="javascript:;" :class="css_user.ing">等待发货</a>
                    <a v-if="code == order.order_status.sended.id" href="javascript:;" :class="css_user.ing">正在配送</a>
                    <a v-if="code == order.order_status.sured.id" href="javascript:;" :class="css_user.finish">订单已完成</a>
                    <p :class="css_user.conct">总计：<span>￥{{d.need_pay}}</span></p>
                </div>
            </ul>
            </template>
            </template>
        </div>
    </div>


    <!-- menu start -->
    <mymenu v-bind:menus.sync="menus" v-bind:show_menus.sync="show_menus"></mymenu>

    <!-- backtop start -->
    <div :class="css_user.gotop"></div>

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
        	css_public,
        	css_user,
        	footpart,
         	headpart,
         	userhead,
        	mymenu
        },
        route:{
        	data(){
        		//初始化css对象
            	this.css_public = css_public;
            	this.css_user = css_user;
            	var user = store.fetch('user');
        	    this.$http.post('user/user_order',{user:user}).then(response => {
               		this.$set('order', response.data.data)
                });
                
                this.$http.post('user/info', {user:user}).then((response) => {
                    this.user_info = response.body.data;
                })
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
        	moveR(){
            
        	},
        	change(code){
        	    this.$set('code',code);
        	},
        	del(id){
        	    var user = store.fetch('user');
        	    this.$http.post('user/del',{id:id,user:user}).then(response => {
        	        if(response.data.data.code == 1){
        	            this.$set('del_id',id);
        	        }else{
                        alert('不能删除！')      	        
        	        }
        	    });
        	}
        },
        data () {    
        return {
        	manual_list:[],
            manual_style:{display:'list-item'},
            manual_active_class:'active',
            menus:[],
            show_menus:false,
            order:{},
            css_public:{},
            css_user:{},
            code:3,
            del_id:0,
            user_info:[]
    	}
    }
        
    }
</script>