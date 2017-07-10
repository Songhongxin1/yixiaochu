<template>
<headpart show_item="story"></headpart>
    <!-- main start -->
    <div v-bind:class="css_public.container">
        <div class="{{css_story.page_main}} {{css_public.page_main}}">
            <div v-bind:class="css_public.l">
                <div v-bind:class="css_story.story_detail">
                    <p v-bind:class="css_story.title">{{info.title}}</p>
                    <div v-bind:class="css_story.info">
                        <p v-bind:class="css_public.l">作者：花儿为什么这样红      {{info.publish_time}}</p>
                        <p v-bind:class="css_public.r">赞  {{info.good}}  |  评论 {{size}}  |  阅读  {{info.read}}</p>
                    </div>
                    <div v-bind:class="css_story.cont">
                        {{{info.content}}}
                    </div>
                    <a href="javascript:;" v-bind:class="css_story.laud" title="点赞" v-on:click="zan(info.id)"></a>
                    <ul>
                    <template v-if="up">
                        <li>上一篇：<a v-link="{name : 'story_detail', params: { id: up.id }}">{{up.title}}</a></li>
                    </template>
                    
                    <template v-if="down">
                        <li>下一篇：<a v-link="{name : 'story_detail', params: { id: down.id }}">{{down.title}}</a></li>
                    </template>
                    </ul>
                    
                    <div v-bind:class="css_story.link_cont">
                        <p><i v-bind:class="css_story.share"></i>分享</p>
                        <a href="javascript:;" v-bind:class="css_story.qq"></a>
                        <a href="javascript:;" v-bind:class="css_story.weix"></a>
                        <a href="javascript:;" v-bind:class="css_story.weibo"></a>
                    </div>
                </div>
                <div v-bind:class="css_story.comment_cont">
                    <div v-bind:class="css_story.cont">
                        <img src="../../static/images/image/head.jpg">
                        <textarea v-model="content"></textarea>
                        <a href="javascript:;" v-bind:class="css_story.but"  v-on:click="discuss(info.id)">评论</a>
                    </div>
                    <ul>
                    <template v-for="(k,v) in comment">
                        <li>
                            <img src="../../static/images/image/head.jpg">
                            <div v-bind:class="css_story.info">
                                <p v-bind:class="css_story.title">花儿为什么这样红<span>- {{v.created_time}} 说：</span></p>
                                <p v-bind:class="css_story.text">{{v.comment}}</p>
                            </div>
                            <i></i>
                        </li>
                   
                    </template>
                    </ul>
                </div> 
            </div>

            <div v-bind:class="css_public.r">
                <div v-bind:class="css_story.hot_cont">
                    <p v-bind:class="css_story.list_title">热门标签</p>
                    <ul>
                    	<template v-for="(k,v) in tags">
                    	
                        <li><a v-link="{name : '/story', params: { type: v.id }}">{{v.name}}</a></li>
                        
                        </template>
                    </ul>
                </div>
                <ul v-bind:class="css_story.right_lists">
                    <p v-bind:class="css_story.list_title">热文推荐</p>
                    <template v-for="(k,v) in hot_lists">
                    <li>
                   	    <a v-link="{name : 'story_detail', params: { id: v.id }}">
                        <p v-bind:class="css_story.title"><span>1</span>{{v.title}}</p>
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
    <div class="gotop"></div>

    <!-- footer start -->
	<footpart></footpart>
</template>

<script>
import css_story from '../../static/css/story.css';
import css_public from '../../static/css/public.css';
import store from '../store.js';
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
        mymenu
    },
    route:{
    	data(){
    		this.css_public = css_public;
            this.css_story = css_story;
    		this.id = this.$route.params.id;
		    this.$http.get('news/comment?id='+this.id).then(function(response) {
			var comment = response.data.data.comment_lists;
			var hot_lists = response.data.data.is_news_recommend;
			var size = response.data.data.comment_lists.length;
			this.$set('comment', comment);
			this.$set('hot_lists', hot_lists);
			this.$set('size', size);
			}, function(response) {
	        });
        
	        this.$http.get('story/lists').then(function(response) {
	        	this.$set('tags', response.data.data.tags);
	        }, function(response) {
	        });
    		//console.log(this.$route.params.id);
    	}
    },
    data(){
    	//var id = this.$route.params.id;
    	//console.log(this.id);
       
        
    	return {
    		info: {},
    		tags: {},
    		comment: {},
    		hot_lists: {},
    		content: '',
    		size: {},
    		id: {},
    		up:{},
    		down:{},
    		css_public:{},
            css_story:{}
    	}
    },
    methods:{
    	zan(id){
    		var article_id = id;
    		if(!store.fetch('zan_key'+article_id) || store.fetch('zan_key'+article_id) == 0){
	    		this.$http.get('news/get_zan?id='+id).then(function(response) {
	    			var number =  response.data.data;
	    			this.$set('info.good', number);
	    			store.save(number, 'zan_key'+article_id);
		        	}, function(response) {
		        });
    		}
    		
    	},
    	discuss(id){
    		if(!store.fetch('content_key'+id) || store.fetch('content_key'+id) == 0){
	            this.$http.post('news/comment', {content:this.content, id:id}).then((response)=>{
	            	var content = response.data.data;
	            	store.save(content, 'content_key'+id);
	                this.$set('comment', content);
	                var size = response.data.data.length;
	                this.$set('size', size);
	            })
            }
        }
        
    },
    watch:{
    	'id':function(val,oldval){
    		this.$http.get('story/get_info?id='+this.id).then(function(response) {
			var info = response.data.data.info;
			var up = response.data.data.up;
			var down = response.data.data.down;
			this.$set('up', up);
			this.$set('down', down);
			//阅读数量
			this.$http.get('news/get_read?id='+this.id).then(function(response) {
				var read_number = response.data.data;
				this.$set('info.read', read_number);
			 }, function(response) {
	        });
			
			this.$set('info', info);
		}, function(response) {
        });
    	},
    	
    }
   
    
}

</script>