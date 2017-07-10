<template>
<headpart show_item="story"></headpart>
    <!-- main start -->
    <div v-bind:class="css_public.container">
        <div class="{{css_story.page_main}} {{css_public.page_main}}">
            <div v-bind:class="css_story.out">
                <ul :class="css_story.img"  >
                    
                    <li v-for="(k,v) in is_banner_recommend" 
                        v-show="k==index" 
                        transition="staggered"
                        stagger="100">
                      <a href=""><img :src="v.cover_img"></a>
                    </li>
                    
                </ul>
                <ul v-bind:class="css_story.num">
                    <template v-for="(k,v) in is_banner_recommend">
                    <li :class="{[css_story.active]: k==index}" @click="changePhoto(k)"></li>
                    </template>
                </ul>

            </div>
            <div v-bind:class="css_story.r">
                <div v-bind:class="css_story.hot_cont">
                    <p v-bind:class="css_story.list_title">热门标签</p>
                    <ul>
                    	<template v-for="(k,v) in tags">
                        <li v-on:click="tag(v.id)">{{v.name}}</li>
                        </template>
                    </ul>
                </div>
            </div>
            <ul v-bind:class="css_story.story_lists">
            <template v-for="(k,v) in story">
            
                <li>
                <a v-link="{name : 'story_detail', params: { id: v.id }}">
                    <img v-bind:src="v.cover_img">
                    <div v-bind:class="css_story.brife">
                        <p v-bind:class="css_story.title">{{v.title}}</p>
                        <p v-bind:class="css_story.text">{{v.summary}}</p>
                        <div v-bind:class="css_story.bot">
                            <p v-bind:class="css_public.l">作者：{{v.publisher}}      {{v.publish_time}}</p>
                            <p v-bind:class="css_public.r">赞  {{v.good}}  |  评价  9  |  阅读  {{v.read}}</p>
                        </div>
                    </div>
                    </a>
                </li>
                
                </template>
                <div v-bind:class="css_story.more"  v-on:click="add()" v-if="show == 0">加载更多</div>
                <div v-bind:class="css_story.more"  v-if="show == 1">没有更多了</div>
                
            </ul>
            <div v-bind:class="css_story.r">
                <ul v-bind:class="css_story.right_lists">
                    <p v-bind:class="css_story.list_title">热文推荐</p>
                    <template v-for="(k,v) in is_news_recommend">
	                    <li>
	                    	<a v-link="{name : 'story_detail', params: { id: v.id }}">
	                        <p v-bind:class="css_story.title"><span>1</span>{{v.title}}.</p>
	                        <p v-bind:class="css_story.text">{{v.summary}}</p>
	                        </a>
	                    </li>
               		</template>   
                    
                </ul>
                <div v-bind:class="css_story.ewm_cont">
                    <p v-bind:class="css_story.ewm"><img src="../../static/images/ewm1.png"></p>
                    <p v-bind:class="css_story.text">扫一扫关注易小厨微信公众号订餐更方便</p>
                </div>

            </div>                                

        </div>
    </div>


    <!-- menu start -->
     <mymenu v-bind:menus.sync="menus" v-bind:show_menus.sync="show_menus"></mymenu>

    <!-- backtop start -->
    <div v-bind:class="css_story.gotop"></div>

    <!-- footer start -->
	<footpart></footpart>
    <!-- 引入项目js资源文件,并配置构建地址演示 -->

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
import css_story from '../../static/css/story.css';
import css_public from '../../static/css/public.css';
var merge = require('webpack-merge');
//引入公共部分
import footpart from './common/footer';
import headpart from './common/header';
import mymenu from './common/mymenu';

export default {
    components:{
        css_story,
        css_public,
        footpart,
        headpart,
        mymenu,
    },
    route:{
    	data(){
	    	if(this.$route.params.type){
	    		this.type = this.$route.params.type;
	    	}
			
    	}
    },
    data(){
    	return {
    		story: {},
    		is_news_recommend: {},
    		is_banner_recommend: {},
    		tags:{},
    		cur_page:{},
    		type:0,
    		show:0,
    		css_public:{},
        css_story:{},
        index: 0,
        size: 0,
    	}
    },
    methods:{
    	add(){
    		this.cur_page++;
    		this.show = 0;
    		this.$http.get('story/lists?cur_page='+this.cur_page+'&type='+this.type).then(function(response) {
    			var merge_story = merge(this.story, response.data.data.lists);
    			this.$set('story', merge_story);
    			if(!response.data.data.lists){
    				this.$set('show', 1);
    			}
	    	});
    	},
    	tag(id){
    		var type = id;
    		var cur_page = 1;
    		this.$set('type', type);
    		this.$set('cur_page', cur_page);
	    	this.$http.get('story/lists?cur_page='+this.cur_page+'&type='+type).then(function(response) {
    			var tag_story = response.data.data.lists;
    			this.$set('story', tag_story);
    			this.$set('show', 0);
    			//console.log(response.data.data.lists);
	    	}, function(response) {
	        });
    	},
    	changePhoto: function(newIndex){
        this.index = newIndex;
      }
    },
    watch:{
    	'type':function(val,oldval){
    		var cur_page = 1;
    		this.$set('cur_page', cur_page);
    		this.$http.get('story/lists?cur_page='+this.cur_page+'&type='+this.type).then(function(response) {
			var tag_story = response.data.data.lists;
			this.$set('story', tag_story);
		}, function(response) {
        });
    	},
    	
    },
    ready(){
    	this.css_public = css_public;
      this.css_story = css_story;
      this.$http.get('story/lists').then(function(response) {
        this.$set('story', response.data.data.lists)
        this.$set('is_news_recommend', response.data.data.is_news_recommend)
        this.$set('is_banner_recommend', response.data.data.is_banner_recommend)
        this.$set('tags', response.data.data.tags)
        this.$set('cur_page', 1)
        this.size = response.data.data.is_banner_recommend.length;
      });
      
      setInterval(()=>{
          this.index++;
          if(this.index == this.size){
            this.index = 0;
          }
        }, 3500);

	  },

    
}

</script>