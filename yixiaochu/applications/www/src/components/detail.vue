<template>
<!-- header start -->
    <headpart show_item="detail"></headpart>

    <!-- main start -->
    <div :class="css_public.container">
        <div class="{{css_pay.page_main}} {{css_public.page_main}}">
            <div :class="css_pay.detail_cont">
                <div :class="css_pay.detail_left">
                    <div :class="css_pay.large_box">
                        <ul>
                        <template v-for="(k,v) of info.caipu">
                            <li  v-if="imgid == $index" style="display: list-item"><img :src="v.cover_img" style="display:block;"></li>
                            <li  v-else="imgid != $index" style="display: none"><img :src="v.cover_img"></li>
                        </template>
                        </ul>
                    </div>
                    <div :class="css_pay.small_box">
                        <span class="{{css_pay.btn}} {{css_pay.left_btn}}"></span>
                        <div :class="css_pay.small_list">
                            <ul>
                                <template v-for="(k,v) of info.caipu">
                                <li>
                                    <img :src="v.cover_img" v-on:click="show($index)">
                                    <div :class="css_pay.bun_bg"></div>
                                </li>
                                </template>
                            </ul>
                        </div>
                        <span class="{{css_pay.btn}} {{css_pay.right_btn}}"></span>
                    </div>
                </div>
                <div :class="css_pay.detail_right">
                    <p :class="css_pay.title">{{info.combo.cate_name}}<span>{{info.combo.combo_name}}</span></p>
                    <ul :class="css_pay.lists">
                        <template v-for="(k,v) of info.caipu">
                        <li>{{v.foods_name}}</li>
                        </template>
                    </ul>
                    <div :class="css_pay.price_cont">
                        <p :class="css_pay.text">价格：</p>
                        <p :class="css_pay.price">￥{{info.combo.price}}</p>
                        <p :class="css_pay.num"><span>{{info.combo.sell_number}}</span><br>交易成功</p>
                    </div>
                    <ul :class="css_pay.cont_list">
                        <li>
                            <label>配送至：</label>
                            <select name="area_id">
                                <option>---请选择送货地区---</option>
                                <template v-for="(ak,av) of info.area" >    
                                    <option vlue="{{av.id}}">{{av.name}}</option>
                                </template>
                            </select>
                        </li>
                        <li>
                            <label>数量：</label>
                            <a href="javascript:;" :class="css_pay.but" v-on:click="reduce()">-</a>
                            <input type="text" value="{{num}}">
                            <a href="javascript:;" :class="css_pay.but" v-on:click="add()">+</a>
                        </li>
                        <li>
                            <label>优惠：</label>
                            <p v-if="info.combo.favorable == 0">无优惠</p>
                            <p v-else="info.combo.favorable > 0">{{info.combo.favorable}} 元</p>
                        </li>
                    </ul>
                    <div :class="css_pay.but_cont">
                        <a href="javascript:;" v-on:click="add_menu()">加入菜单</a>
                        <a href="javascript:;" :class="css_pay.act">下单即获积分   65</a>
                    </div>
                </div>
            </div>

            <p :class="css_pay.pay_title">搭配技巧</p>
            <p :class="css_pay.pay_stitle">{{info.combo.description}}</p>
            <ul :class="css_pay.pay_lists">
                <template v-for="(k,v) of info.caipu">
                <li>
                    <img :src="v.cover_img">
                    <div :class="css_pay.info">
                        <p :class="css_pay.title">{{v.combo_name}}<span>{{v.description}}</span></p>
                        <div :class="css_pay.cont">
                            <p :class="css_pay.l_text">食&nbsp;&nbsp;&nbsp;&nbsp;材：</p>
                            <p :class="css_pay.r_text">{{v.food_material}}</p>
                            <p :class="css_pay.l_text">营养价值：</p>
                            <p :class="css_pay.r_text">{{v.nutritive_value}}</p>
                        </div>
                        <div :class="css_pay.bot">
                            <p :class="css_public.l">已售 {{v.sell_number}}</p>
                            <p :class="css_public.r"><span>赞  9</span>&nbsp;&nbsp;|&nbsp;&nbsp;评价 9&nbsp;&nbsp;|&nbsp;&nbsp;分享  9</p>
                        </div>
                    </div>
                </li>
                </template>
            </ul>

        </div>
    </div>


     <!-- menu start -->
    <mymenu v-bind:menus.sync="car" v-bind:show_menus.sync="show_menus"></mymenu>

    <!-- backtop start -->
    <div :class="css_pay.gotop"></div>

    <!-- footer start -->
    <footpart></footpart>
</template>

<script>
import store from '../store.js';
import css_public from '../../static/css/public.css';
import css_pay from '../../static/css/pay.css';

//引入公共头部和尾部
import footpart from './common/footer';
import headpart from './common/header';
import mymenu from './common/mymenu';

export default {
    components:{
        css_public,
        css_pay,
        footpart,
        headpart,
        mymenu
    },
    route:{
    	data(){
    		//初始化css对象
            this.css_public = css_public;
            this.css_pay = css_pay;
    	    this.$set('id',this.$route.params.id);
    		this.$http.post('detail/get_detail',{id:this.id}).then(response => {
             this.$set('info', response.data.data);
            });
    	}
    },
    methods:{
    	//菜品向右移动
        moveR(){
            
        },
        show(id){
            this.$set('imgid',id);
        },
        add(){
        	this.num +=1;
        },
        reduce(){
            if(this.num == 1){
                return;
            }
            this.num -=1;
        },
        //加入购物车
        add_menu(){
            this.show_menus = true;
            var combodata = this.info.combo;
            var foodsdata = this.info.caipu;
            var data = {'id':combodata.id,'cover_img':combodata.cover_img,'num':this.num,'combo_name':combodata.combo_name,'price':combodata.price,'favorable':combodata.favorable,'caipu':{foodsdata}};
            this.car.push(data);
            store.save(this.car, 'menus');
        }
        
    },
    ready(){
        this.i = 0;
            //把本地保存的购物车列表取出来
            if(store.fetch('menus')){
               this.$set('car',store.fetch('menus'));
           }
    },
    data () {    
        return {
            id:0,
        	info:{},
        	imgid:0,
        	num:1,
        	manual_list:[],
            manual_style:{display:'list-item'},
            manual_active_class:'active',
            menus:[],
            show_menus:false,
            css_public:{},
            css_pay:{},
            car:{}
    	}
    }
}
</script>







