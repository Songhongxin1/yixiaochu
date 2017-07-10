<template>
<!-- header start -->
    <alert-dialog :msg ="msg"></alert-dialog>
    <headpart show_item="home"></headpart>
    <!-- main start -->
    <div v-bind:class="css_public.container">
        <div :class="css_order.banner"></div>
        <div class="{{css_order.page_main}} {{css_public.page_main}}">
            <p :class="css_order.order_title">确认菜单信息</p>
            <ul :class="css_order.order_lists">
                <template v-for="(k,c) of car">
                <li>
                    <div :class="css_order.cont">
                        <!--套餐菜品--->
                        <template v-if="c.combo_name">
                        <p :class="css_order.title">{{c.combo_name}}</p>
                            <div :class="css_order.sliderwrapper">
                                <div :class="css_order.slider" v-bind:style="{ width: c.foods.length*100 + '%' }">
                                    <template v-for="cp of c.foods">
                                        <div :class="css_order.slide"><img :src="cp.cover_img">{{cp.foods_name}}</div>
                                    </template>
                                    <template v-if="c.caipu" v-for="v of c.caipu.foodsdata">
                                      <div :class="css_order.slide"><img :src="v.cover_img">{{v.foods_name}}</div>
                                    </template>
                                </div>
                            </div>      
                        </template>
                        
                        <!--单独菜品--->
                        <template v-if="c.foods_name">
                            <img v-bind:src="c.cover_img">
                        <div :class="css_order.brife">
                            <p :class="css_order.title">{{c.foods_name}}</p>
                            <p :class="css_order.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;材：</p> 
                            <p :class="css_order.r_text">{{c.food_material}}</p>
                        </div>
                        </template>
                        
                    </div>
                    <div :class="css_order.num">
                        <p :class="css_order.head">数量</p>
                        <div :class="css_order.num_cont">
                            <template v-if="c.num">
                            	<a href="javascript:;" :class="css_order.but" v-on:click="minus(c)">-</a>
                            	<input v-if="c.num" type="text" value="{{c.num}}">
                            	<a href="javascript:;" v-on:click="add(c)" :class="css_order.but">+</a>
                            </template>
                        </div>
                    </div>
                    <div :class="css_order.discount">
                        <p :class="css_order.head">优惠</p>
                        <p v-if="c.combo_name" :class="css_order.text">{{(c.favorable*c.num).toFixed(2)}} 元</p>
                        <p v-if="c.foods_name" :class="css_order.text">{{((c.old_price-c.now_price)*c.num).toFixed(2)}} 元</p>
                    </div>
                    <div :class="css_order.price_cont">
                        <p :class="css_order.head">价格</p>
                        <p v-if="c.combo_name" :class="css_order.price">￥{{(c.price*c.num).toFixed(2)}} 元</p>
                        <p v-if="c.foods_name" :class="css_order.price">￥{{(c.now_price*c.num).toFixed(2)}} 元</p>
                        <a href="javascript:;" v-on:click="delorder(k)" :class="css_order.del_but">删除</a>
                    </div>
                </li>
                </template>
            </ul>
            <p :class="css_order.order_title">选择送餐地址<a href="javascript:;" v-on:click="shut()" :class="css_order.add_adres">新增地址<i :class="css_order.add_but"></i></a></p>
            <div :class="css_order.addres_cont">
                <template v-if="!data.status">
                    <div :class="css_order.noadres">{{addr.id}}您还没添加地址，请先<a href="javascript:;" :class="css_order.add_adres" v-on:click="shut()">添加送餐地址！</a></div>
                </template>
                <ul>
                    <template v-if="data.status==1 && v.id != del_id" v-for="(k,v) of data.addr">
                    <li>        
                       <input type="radio" name="addrid" value="{{v.id}}">
                       <p> <template v-for="a of data.area" v-if="v.area == a.id">{{a.name}} </template> <template v-for="a of data.area" v-if="v.bus_area == a.id">{{a.name}}</template> {{v.addr_name}} （ {{v.user_name}} 收） {{v.addr_phone}}</p> 
                       <a href="javascript:;" v-on:click="del(v.id)">删除</a>
                    </li>
                    </template>
                </ul>
                <div :class="css_order.info">
                    <p :class="css_order.text">共选中 <span>3</span> 个菜{{v.id}} </p>
                    <p :class="css_order.text">共计 <span>￥{{sum.toFixed(2)}}</span> </p>
                    <p :class="css_order.text">优惠 <span>￥{{free.toFixed(2)}}</span> </p>
                    <a href="javascript:;" v-on:click="paynow()" :class="css_order.pay">立即付款</a>
                    <p class="{{css_order.text}} {{css_order.r}}">需支付： <span>￥{{sum.toFixed(2)}}</span> </p>
                </div>
            </div>

        </div>
    </div>

    <!-- 地址弹窗 start -->
    <div v-if="open" class="{{css_order.popup_addres}} {{css_order.act}}">
        <div v-on:click="shut()" :class="css_order.close"></div>
        <ul>
            <li>
                <label><span>*</span>所在地区:</label>
                <select :class="css_order.style1" v-model="user_area">
                    <option v-for="option in data.area" v-if="option.pid == 0" v-bind:value="option.id">{{option.name}}</option>
                </select>
                <select :class="css_order.style1" v-model="user_bus_area">
                	<option>--请选择--</option>
					<option v-bind:value="option.id" v-for="option in data.area" v-if="option.pid == user_area && option.name" >{{option.name}}</option>
                </select>
            </li>
            <li>
                <label><span>*</span>详细地址：</label>
                <textarea v-model="user_addr" placeholder="&#x5EFA;&#x8BAE;&#x4F60;&#x5982;&#x5B9E;&#x586B;&#x5199;&#x8BE6;&#x7EC6;&#x9001;&#x9910;&#x5730;&#x5740;&#xFF0C;&#x4F8B;&#x5982;&#x8857;&#x9053;&#x540D;&#x79F0;&#xFF0C;&#x95E8;&#x724C;&#x53F7;&#x7801;&#xFF0C;&#x697C;&#x5C42;&#x548C;&#x623F;&#x95F4;&#x53F7;&#x7B49;&#x4FE1;&#x606F;&#x3002;"></textarea>
            </li>
            <li>
                <label><span>*</span>收货人姓名：{{username}}</label>
                <input v-model="user_name" type="text" :class="css_order.style1" placeholder="&#x957F;&#x5EA6;&#x4E0D;&#x8D85;&#x8FC7;25&#x4E2A;&#x5B57;&#x7B26;">
            </li>
            <li>
                <label><span>*</span>手机号码：</label>
                <select :class="css_order.style3">
                    <option>中国大陆  +86</option>
                </select>
                <input v-model="phone" type="text" :class="css_order.style2" placeholder="&#x8BF7;&#x8F93;&#x5165;11&#x4F4D;&#x624B;&#x673A;&#x53F7;&#x7801;">
            </li>
        </ul>
        <div :class="css_order.cont">
            <label><input v-model="is_default" type="checkbox">设置为默认收货地址</label>
        </div>
        <div :class="css_order.cont">
            <a href="javascript:;" v-on:click="add_addr(user_area,user_bus_area,user_addr,user_name,phone,is_default)" class="{{css_order.but}} {{css_order.act}}">保存</a>
            <a href="javascript:;" :class="css_order.but" v-on:click="shut()">取消</a>
        </div>
    </div>

    <!-- 支付弹窗 start -->
    <div :class="css_order.popup_pay" v-if="z_open == 1" style="top:20%">
        <div :class="css_order.close" v-on:click="paynow()"></div>
        <p :class="css_order.title">选择支付方式</p>
        <ul>
            <li class="weix">
                <img :src="./assets/images/weix.png">
                <p :class="css_order.text">微信支付<br><span>使用微信支付，支持AA付款</span></p>
                <i class=""></i>                
            </li>
            <div :class="css_order.cont">
                <div :class="css_order.con">
                    <input type="radio">
                    <p class="icon">任性全款</p>
                </div>
                <div :class="css_order.con">
                    <input type="radio">
                    <p :class="css_order.icon">AA支付</p>
                    <span :class="css_order.num">人数</span>
                    <a href="javascript:;" :class="css_order.but">-</a>
                    <input type="text" value="6">
                    <a href="javascript:;" :class="css_order.but">+</a>
                </div>
                <div class="{{css_order.con}} {{css_order.bot}}">
                    <p class="l">总计：<span>￥90</span></p>
                    <p class="r">小计（人均）：<span>￥15</span></p>
                </div>
            </div>
            <li>
                <img :src="./assets/images/pay.png">
                <p :class="css_order.text">支付宝<br><span>支持有支付宝，网银的用户使用</span></p>
                <i></i>
            </li>
        </ul>
        <a href="javasctipt:;" :class="css_order.submit_but">确认支付</a>
    </div>
    <div v-if="z_open || open" class="{{css_today.page_bg}} {{css_today.act}}"></div>
     <!-- menu start -->
    <mymenu v-bind:menus.sync="car" v-bind:show_menus.sync="show_menus"></mymenu>

    <!-- backtop start -->
    <div :class="css_order.gotop"></div>

    <!-- footer start -->
    <footpart></footpart>
</template>
<script>
	import store from '../store.js';
    import css_public from '../../static/css/public.css';
	import css_order from '../../static/css/order.css';
	import alertDialog from './common/alertDialog';
	
	//引入公共头部和尾部
	import footpart from './common/footer';
	import headpart from './common/header';
	import mymenu from './common/mymenu';
	export default {
	    components:{
	        css_public,
	        css_order,
	        store,
	        footpart,
         	headpart,
        	mymenu,
        	alertDialog
	    },
	    route:{
    	    data(){
    	    	//初始化css对象
            	this.css_public = css_public;
            	this.css_order = css_order;
            	var user = store.fetch('user');
    			this.$http.post('order/get_addr',{user:user}).then(response => {
                	this.$set('data', response.data.data);
                });
    		}
    	},
    	ready(){
            //如果未登录跳转
            if(store.fetch('user').length == 0){
                this.$route.router.go('/login');
            }
            //把本地保存的购物车列表取出来
            if(store.fetch('menus')){
               this.$set('car',store.fetch('menus'));
           }
        },
    	methods:{
    	    //菜品向右移动
            moveR(){
            
             },
             //计算商品总价格
             get_sum(k){
                 this.sum +=k
             },
    	    //删除用户收货地址
    	    del(id){
    	    	var user = store.fetch('user');
    	    	this.$http.post('order/deladdr',{id:id,user:user}).then(response => {
                    if(response.data.data == 1){
                    	this.msg = {msg: '删除成功', isErr: false};
                    	this.del_id = id;
                    	return;
                    }else{
                        this.msg = {msg: '操作失败'};
                    	return;
                    }   
                });
                
    	    },
    	    shut(){
    	        //添加收货地址时打开的弹出层
    	        if(this.open == 0){
    	            this.$set('open',1);
    	        }else{
    	            this.$set('open',0)
    	        }
    	    },
    	    //删除指定商品
    	    delorder(id){
    	        this.car.splice(id,1);
    	        store.save(this.car,'menus');
    	        this.msg = {msg: '删除成功', isErr: false};
                return;
    	    },
    	    add_addr(user_area,user_bus_area,user_addr,user_name,phone,is_default){
    	        if(user_area && user_bus_area && user_addr && user_name && phone){
    	            if(is_default){
    	                is_default = 1;
    	            }else{
    	            	is_default = 0;
    	            }
    	            var user = store.fetch('user');
    	            var addr_data = {user_area:user_area,user_bus_area:user_bus_area,user_addr:user_addr,user_name:user_name,phone:phone,is_default:is_default,user:user};
    	            this.$http.post('user/add_user_addr',addr_data).then(response => {
    	                this.$set('add_msg',response.data.msg);
    	                if(response.data.data.code ==1){
    	                	this.msg = {msg: response.data.data.msg, isErr: false};
    	                	this.shut();
    	            	}else{
    	            	    this.msg = {msg: this.add_msg.msg};
                    		return; 	                
    	            	}

    	            })
    	            .catch(function(error) {
    	                alert(error);
                  });
    	            
    	            
    	        }else{
    	            this.msg = {msg: '请完整信息!'};
                    return;
    	        }
    	    },
    	    //结算
    	    paynow(){
    	        if(this.open == 0){
    	            this.$set('z_open',1);
    	        }else{
    	            this.$set('z_open',0)
    	        }
    	    },
    	    minus: function(obj){
    	      if(obj.num === 1){
    	        this.msg = {msg: '不能再减了!如果不需要该菜，请点击删除'};
    	      }else{
    	        obj.num = obj.num -1 ;
    	      }
    	    },
    	    add: function(obj){
            if(obj.num > 100){
              //需要判断库存
              this.msg = {msg: '不能再加了!'};
            }else{
              obj.num = obj.num +1 ;
            }
          },
    	},
        data () {  
            return {
            	data:{},
            	addr:{},
            	show:0,
            	open:0,
            	foods:{},
            	car:{},
            	show_menus:false,
            	css_public:{},
            	css_order:{},
            	//sum:0,
            	user_area:1,
            	msg: {
              		msg: '',
            	},
            	add_msg:{},
            	del_id:-1,
            	z_open:0
    		}
    	},
    	computed:{
    		sum:function(){
    			var len = this.car.length;
    			var count1 = 0;
    			var count2 = 0;
    			for(var i=0; i<len; i++){
    				if(this.car[i].now_price){
    					count1 += parseFloat(this.car[i].now_price) * parseInt(this.car[i].num);
    				}
    				if(this.car[i].price){
    			        count2 += parseFloat(this.car[i].price)*parseInt(this.car[i].num);
    			    }
    			}
    			return count1+count2;
    		},
    		free:function(){
    			var len = this.car.length;
    			var count1 = 0;
    			var count2 = 0;
    			for(var i=0; i<len; i++){
    			    if(this.car[i].now_price){
    			        count1 += parseFloat((this.car[i].old_price)-(this.car[i].now_price)) * parseInt(this.car[i].num);
    			    }
    			    if(this.car[i].favorable){
    			        count2 += parseFloat(this.car[i].favorable)*parseInt(this.car[i].num);
    			    }
    			}
    			return count1+count2;
    		}
    	}
	}
</script>












