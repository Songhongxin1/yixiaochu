<template>
    <!-- header start -->
    <headpart show_item="home"></headpart>
    <!-- main start -->
    <div v-bind:class="css_public.container"> 
        <div class="{{css_index.page_main}} {{css_public.page_main}}">
            <div v-bind:class="css_public.page_cont">
                <div v-bind:class="css_index.out">
                    <ul class="img" v-show="manual_list" >
                        <li v-for="(k,v) in manual_list"
                          v-show="k==index"  
                          transition="staggered"
                          stagger="100">
                          <a href="{{v.url}}"><img v-bind:src="v.img_url"></a>
                          </li>
                    </ul>
                    <ul v-bind:class="css_index.num">
                        <template v-for="(k,v) in manual_list">
                        <li :class="{[css_index.active]: k==index}" @click="changePhoto(k)"></li>
                        </template>
                    </ul>
                </div>
                <div v-bind:class="css_index.story">
                    <p v-bind:class="css_index.title">小厨故事<a v-link="'story'">more</a></p>
                    <img v-bind:src="home_story.cover_img">
                    <p v-bind:class="css_index.s_title">{{home_story.title}}</p>
                    <p v-bind:class="css_index.s_text">{{home_story.summary}}</p>
                </div>
            </div>
            <div :class="css_index.index_tip"><img src="../../static/images/adven.jpg"></div>
            <div :class="css_index.page_cont">
                <div :class="css_index.index_nav">
                    <p :class="css_index.title">今日特推</p>
                    <ul>
                        <li v-for="(k,v) in menus_cate" class="{{v.id == show_cate ? css_index.act : ''}}" v-on:click="cate_change(v.id)">{{v.name}}</li>
                    </ul>
                </div>
                <ul :class="css_index.foods_lists" v-show="menus_list">
                    
                    <li v-for="(k,v) in menus_list" :combo_cate_id="v.combo_cate_id" :show_cate="show_cate" v-if="v.combo_cate_id == show_cate" :i="i" style="{{++i%2 == 0 ? 'margin-right:0' : ''}}">
                        <a href="/detail/{{v.id}}">
                        <img v-bind:src="v.cover_img">
                        <div :class="css_index.detail">
                            <p :class="css_index.title">{{v.combo_name}}<span class="price">{{v.price}}</span></p>
                            <p :class="css_index.text">{{v.description}}<a href="/detail/{{v.id}}">详情>></a></p>
                            <div :class="css_index.wrapper">
                                <div :class="css_index.slider_wrapper">
                                <div :class="css_index.slider" style="width:{{v.foods.length*100}}%;">
                                    <div :class="css_index.slide" v-for="(key, value) in v.foods"><img v-bind:src="value.cover_img">{{value.foods_name}}</div>
                                </div>
                                </div>
                            </div>
                            <div :class="css_index.bot"><a href="javascript:;" :class="css_index.destine" v-on:click="add_menu(k)">立即预定</a><span>已售  {{v.sell_number}}</span></div>
                        </div>
                        </a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
    <!-- menu start -->
    <mymenu v-bind:menus.sync="car" v-bind:show_menus.sync="show_menus"></mymenu>

    <div :class="css_index.page_bg"></div>

    <!-- backtop start -->
    <div :class="css_index.gotop"></div>
    
    <!-- footer start -->
    <footpart></footpart>
    
</template>

<style>
.staggered-transition {
  transition: all .7s ease;
  overflow: hidden;
  margin: 0;

}
.staggered-enter, .staggered-leave {
  opacity: 0;
}
</style>

<script>
import css_index from '../../static/css/index.css';
import css_public from '../../static/css/public.css';
import store from '../store.js';
//引入公共头部和尾部
import footpart from './common/footer';
import headpart from './common/header';
import mymenu from './common/mymenu';

export default {
    components:{
        css_index,
        css_public,
        footpart,
        headpart,
        mymenu
    },
    route:{
        data(){
            //初始化css对象
            this.css_public = css_public;
            this.css_index = css_index;
            //获取数据
            this.$http.get('home/index').then((response) => {          
            //设置首页小厨故事
            this.home_story = response.body.data.home_story;
            //设置首页套餐分类
            this.menus_cate = response.body.data.menus_cate;
            //设置显示的套餐分类id
            this.show_cate = response.body.data.menus_cate[0].id;
            //设置套餐列表
            this.menus_list=response.body.data.menus_list;
            //设置轮播列表
            this.manual_list = response.body.data.manual_list;          
	        },(response) => {        
	        })        
        }
    },
    created(){
    },
    data(){
        return {
            manual_list:[],
            manual_style:{display:'list-item'},
            manual_active_class:'active',
            //轮播索引
            index:0,
            //循环索引
            i:0,
            home_story:[],
            menus_list:[],
            menus_cate:[],
            //时间循环变量
            t:[],
            //显示的套餐分类id
            show_cate:0,
            menus:false,
            show_menus:false,
            css_public:{},
            css_index:{},
            car:this.menus
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
        //分类切换
        cate_change(id){
            this.show_cate = id;
            this.i = 0;
        },
        //加入购物车
        add_menu(id){
            this.show_menus = true;
            this.car.push(this.menus_list[id]);
            store.save(this.car, 'menus');
        },
        changePhoto: function(newIndex){
          this.index = newIndex;
        },
        single_detail: function(id){
          this.$route.router.go('single_detail');
        }
    },
    watch:{
        'manual_list':function(val, oldval){
            this.size = val.length;
            var obj = this;
            this.t = setInterval(function(){
                obj.index++;
                if(obj.index == obj.size){
                    obj.index = 0;
                }
            }, 3500);
        }
    }
}

</script>
