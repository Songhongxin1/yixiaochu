<template>
 <!-- header start -->
    <headpart show_item="today"></headpart>

    <!-- main start -->
    <div v-bind:class="css_public.container">
        <div v-bind:class="css_today.banner">
            <div v-bind:class="css_today.cont">
                <div v-bind:class="css_today.tip">
                    <div v-on:click="show()" v-bind:class="css_today.addres">
                        贵阳&nbsp;﹀
                        <ul v-if="act" v-bind:class="css_today.act">
                            <li>贵阳</li>                       
                            <li>重庆</li>
                            <li>重庆</li>
                        </ul>
                    </div>
                    <p><i class="weather"></i>多云   29 ~ 21 ℃</p>
                    <p>6月01日  周三</p>
                </div>
            </div>
        </div>
        <div class="{{css_today.page_main}} {{css_public.page_main}}">
            <p v-bind:class="css_today.page_title">今日菜单<span>每日不一样的菜品</span></p>
            <ul class="{{css_today.today_lists}}">
                <template v-for="(k,v) of data.foods" v-if="v.type == data.type.jinri.value">             
                <li>
                    <img v-on:click="fn(v.id)" v-bind:src="v.cover_img">
                    <div v-bind:class="css_today.bot">{{v.foods_name}}<p v-bind:class="css_today.price">￥{{v.now_price}}</p><a href="javascript:;" v-bind:class="css_today.join" v-on:click="add_menu(k)">加入菜单</a></div>
                    <div v-show="img == v.id && open"  class="{{css_today.list_detail}} {{css_today.act}}">
                        <p v-on:click="close()" v-bind:class="css_today.close"></p>
                        <img v-bind:src="v.cover_img">
                        <div v-bind:class="css_today.brife">
                            <p v-bind:class="css_today.title">{{v.foods_name}} <span>￥{{v.now_price}}</span></p>
                            <div v-bind:class="css_today.cont">
                                <p v-bind:class="css_today.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;材：</p>
                                <p v-bind:class="css_today.r_text">{{v.food_material}}</p>
                                <p v-bind:class="css_today.l_text">营养价值：</p>
                                <p v-bind:class="css_today.r_text">{{v.nutritive_value}}</p>
                            </div>
                            <div v-bind:class="css_today.link">
                                <p>已售  {{v.sell_number}}   |   <span>赞  9</span>    |    分享  9</p>
                                <a href="javascript:;" v-bind:class="css_today.buy" v-on:click="add_menu(k)" >加入菜单</a>
                            </div>
                        </div>
                    </div>
                </li>
                </template>
            </ul>
            <p v-bind:class="css_today.page_title">米饭.饮料.水果<span>新鲜水果享不停</span></p>
            <ul class="{{css_today.today_lists}}">
                <template v-for="(k,v) of data.foods" v-if="v.type == data.type.fushi.value">           
                <li>
                    <img v-on:click="fn(v.id)" v-bind:src="v.cover_img">
                    <div v-bind:class="css_today.bot">{{v.foods_name}}<p v-bind:class="css_today.price">￥{{v.now_price}}</p><a href="javascript:;" v-bind:class="css_today.join" v-on:click="add_menu(k)">加入菜单</a></div>
                    <div class="{{css_today.list_detail}} {{css_today.act}}" v-if="img == v.id && open">
                        <p v-on:click="close()" v-bind:class="css_today.close"></p>
                        <img v-bind:src="v.cover_img">
                        <div v-bind:class="css_today.brife">
                            <p v-bind:class="css_today.title">{{v.foods_name}} <span>￥{{v.now_price}}</span></p>
                            <div v-bind:class="css_today.cont">
                                <p v-bind:class="css_today.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;材：</p>
                                <p v-bind:class="css_today.r_text">{{v.food_material}}</p>
                                <p v-bind:class="css_today.l_text">营养价值：</p>
                                <p v-bind:class="css_today.r_text">{{v.nutritive_value}}</p>
                            </div>
                            <div v-bind:class="css_today.link">
                                <p>已售  {{v.sell_number}}   |   <span>赞  9</span>    |    分享  9</p>
                                <a href="javascript:;" v-bind:class="css_today.buy" v-on:click="add_menu(k)" >加入菜单</a>
                            </div>
                        </div>
                    </div>
                </li>
                </template>
            </ul>
        </div>
    </div>
    
    <div v-if="open" class="{{css_today.page_bg}} {{css_today.act}}"></div>

     <!-- menu start -->
    <mymenu v-bind:menus.sync="car" v-bind:show_menus.sync="show_menus"></mymenu>

    <!-- backtop start -->
    <div v-bind:class="css_today.gotop"></div>
    
   <!-- footer start -->
    <footpart></footpart>
</template>
<script>

import store from '../store.js';
import css_today from '../../static/css/today.css';
import css_public from '../../static/css/public.css';

//引入公共头部和尾部
import footpart from './common/footer';
import headpart from './common/header';
import mymenu from './common/mymenu';

export default {
    components:{
        css_today,
        css_public,
        footpart,
        headpart,
        mymenu
    },
    route:{
    	data(){
    	    //初始化css对象
            this.css_public = css_public;
            this.css_today = css_today;
            console.log(css_today.list_detail);
    		this.$http.get('today/get_today').then(response => {
               this.$set('data', response.data.data)
            });
    	}
    },
    ready(){
        this.i = 0;
            //把本地保存的购物车列表取出来
            if(store.fetch('menus')){
               this.$set('car',store.fetch('menus'));
           }
    },
    methods:{
    	//菜品向右移动
        moveR(){
            
        },
        fn(k){
             this.img=k;
             this.shutdown();
        },
        //加入购物车
        add_menu(id){
            this.show_menus = true;
            this.car.push(this.data.foods[id]);
            store.save(this.car, 'menus');
        },
        close(){
            this.shutdown();
        },
        show(){
            if(this.act == false){
                this.act = true;
            }else{
                this.act = false;
            }
        },
        shutdown(){
            if(this.open == false){
                this.open = true;
            }else{
                this.open = false;
            }
        }
    },
    data () {
        return {
      		data: [],
      		open:false,
      		img:'-1',
      		act:false,
      		car:{},
      		manual_list:[],
            manual_style:{display:'list-item'},
            manual_active_class:'active',
            menus:{},
            show_menus:false,
            css_public:{},
            css_today:{}
    }
  } 
}
</script>