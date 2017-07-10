<template>
<headpart show_item="scoff"></headpart>

    <!-- main start -->
    <div v-bind:class="css_public.container">
        <!--dm start-->
        <div v-bind:class="css_scoff.dm">
            <!--d_screen start-->
            <div v-bind:class="css_scoff.d_screen">
                <div v-bind:class="css_scoff.d_mask"></div>
                <div v-bind:class="css_scoff.d_show">
                	
                    	<div v-for="(k,v) in content" track-by="$index"  :transition="staggereds[Math.floor(Math.random()*1000)%6]"
                        stagger="300"><img src="../../static/images/image/head.jpg"><span>{{v.content}}</span></div>
                	
                </div>
            </div>
            <!--end d_screen-->

            <!--send start-->
            <div v-bind:class="css_scoff.send">
                <div v-bind:class="css_scoff.s_fiter">
                    <div v-bind:class="css_scoff.s_cont">
                        <ul>
                            <li>
                                <label>口感</label>
                                <p>
                                <template v-for="(k,v) in kougan">
                                    <span v-on:click="tag(v, t='0')" >{{v}}</span>
                                </template>
                                </p>
                            </li>
                            <li>
                                <label>外观</label>
                                <p>
                                <template v-for="(k,v) in waiguan">
                                    <span v-on:click="tag(v, t='1')" >{{v}}</span>
                                </template>
                                </p>
                            </li>
                            <li>
                                <label>服务</label>
                                <p>
                                <template v-for="(k,v) in fuwu">
                                    <span v-on:click="tag(v, t='2')" >{{v}}</span>
                                </template>
                                </p>
                            </li>
                            <li>
                                <label>送餐速度</label>
                                <p>
                                <template v-for="(k,v) in sudu">
                                    <span v-on:click="tag(v, t='3')" >{{v}}</span>
                                </template>
                                </p>
                            </li>

                        </ul>
                    </div>
                    <div v-bind:class="css_scoff.s_con">
                        <i></i>
                        <input type="text" v-bind:class="css_scoff.s_txt" placeholder="&#x8272;&#x9999;&#x5473;&#x4FF1;&#x5168;" v-model="content1">
                        <input type="button" value="&#x53D1;&#x9001;" v-bind:class="css_scoff.s_sub" v-on:click="discuss()">
                    </div>
                </div>
            </div>
            <!--end send-->
        </div>
        <!--end dm-->

        <div class="{{css_scoff.page_main}} {{css_public.page_main}}">
            <p v-bind:class="css_scoff.scoff_title">欢乐不停  吐槽不止</p>
            <p v-bind:class="css_scoff.scoff_text">您对我们有什么建议和意见，给我们提出来，我们一定会改进</p>
            <p v-bind:class="css_scoff.scoff_text">或者对生活有什么要吐槽的，都可以在这里尽情的释放，我们会随机抽取幸运的顾客送出精美的礼品</p>
        </div>

    </div>


    <!-- footer start -->
    <footpart></footpart>
</script>
</template>

<style>

.staggered-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 20px;
  margin-left:1500px;
}
.staggered-enter {
  opacity: 1;
  margin-top: 20px;
  margin-left:-200px;
}
.staggered-leave {
  opacity: 1;
  margin-top: 20px;
  margin-left:1501px;
}


.staggered1-transition {
  transition: all 10.5s ease-in;
overflow: hidden;
margin-top: 120px;
margin-left:1500px;
}
.staggered1-enter {
  opacity: 1;
margin-top: 120px;
margin-left:-200px;
}
.staggered1-leave {
  opacity: 1;
margin-top: 120px;
margin-left:1501px;
}

.staggered2-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 220px;
  margin-left:1500px;
}
.staggered2-enter {
  opacity: 1;
  margin-top: 220px;
  margin-left:-200px;
}
.staggered2-leave {
  opacity: 1;
  margin-top: 220px;
  margin-left:1501px;
}

.staggered3-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 320px;
  margin-left:1500px;
}
.staggered3-enter {
  opacity: 1;
  margin-top: 320px;
  margin-left:-200px;
}
.staggered3-leave {
  opacity: 1;
  margin-top: 320px;
  margin-left:1501px;
}

.staggered4-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 420px;
  margin-left:1500px;
}
.staggered4-enter {
  opacity: 1;
  margin-top: 420px;
  margin-left:1500px;
}
.staggered4-leave {
  opacity: 1;
  margin-top: 420px;
  margin-left:1501px;
}

.staggered5-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 520px;
  margin-left:1500px;
}
.staggered5-enter {
  opacity: 1;
  margin-top: 520px;
  margin-left:-200px;
}
.staggered5-leave {
  opacity: 1;
  margin-top: 520px;
  margin-left:1501px;
}

.staggered6-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 620px;
  margin-left:1500px;
}
.staggered6-enter {
  opacity: 1;
  margin-top: 620px;
  margin-left:1500px;
}
.staggered6-leave {
  opacity: 1;
  margin-top: 620px;
  margin-left:1501px;
}

.staggered7-transition {
  transition: all 10.5s ease-in;
  overflow: hidden;
  margin-top: 720px;
  margin-left:1500px;
}
.staggered7-enter {
  opacity: 1;
  margin-top: 720px;
  margin-left:-200px;
}
.staggered7-leave {
  opacity: 1;
  margin-top: 720px;
  margin-left:1501px;
}

</style>

<script>
import css_scoff from '../../static/css/scoff.css';
import css_public from '../../static/css/public.css';
//引入公共头部
import headpart from './common/header';
import footpart from './common/footer';
var merge = require('webpack-merge');
export default {
    components:{
        css_scoff,
        css_public,
        headpart,
        footpart
    },
    data(){
   		return {
   			content:'',
   			content1:'',
   			kougan:{},
   			waiguan:{},
   			fuwu:{},
   			sudu:{},
   			css_public:{},
        css_scoff:{},
        staggereds:['staggered','staggered1','staggered2','staggered3','staggered4','staggered5','staggered6','staggered7'],
   		}
    },
    methods:{
    	discuss(){
    	if(this.content1 && this.content1!=' '){
    	 	this.$http.post('scoff/write', {content1:this.content1}).then((response)=>{
            	this.$set('content1', ' ');
            	
            	this.$http.get('scoff/get_read').then((response)=>{
        		var content = response.data.data;
        		this.$set('content', content);
		    	init_screen();
       			});
       			
       			
       			window.jQuery = window.$ = require('jquery');
		    	function init_screen(){
				      var _top=0;
				      $(".d_show").find("div").show().each(function(){
				      var _left=$(window).width()-$(this).width();
				      var _height=$(window).height();
					  //console.log(_left);
				      _top=_top+76;
				      if(_top>=_height-100){
				        _top=0;
				      }
				
				      $(this).css({left:_left,top:_top,color:getReandomColor()});
				      var time=25000;
				      if($(this).index()%2==0){
				        time=15000;
				      }
				      $(this).animate({left:"-"+_left+"px"},time,function(){
				      });
				    });
				}
       			
       			//随机获取颜色值
				  function getReandomColor(){
				    return '#'+(function(h){
				    return new Array(7-h.length).join("0")+h
				    })((Math.random()*0x1000000<<0).toString(16))
				  }
       			
       			
       			
            })
		}
           
        },
        tag(value, type){
        	if(type == 0){
        		var string="口感"+value;
        	}
        	if(type == 1){
        		var string="外观"+value;
        	}
        	if(type == 2){
        		var string="服务"+value;
        	}
        	if(type == 3){
        		var string="送餐速度"+value;
        	}
        	this.$set('content1', string);
        }
    
    },
    ready(){
    	//获取标签
    	this.css_public = css_public;
        this.css_scoff = css_scoff;
   		this.$http.get('scoff/get_tag').then((response)=>{
    		var tag = response.data.data;
    		//console.log(tag.kougan);
    		this.$set('kougan', tag.kougan);
    		this.$set('waiguan', tag.waiguan);
    		this.$set('fuwu', tag.fuwu);
    		this.$set('sudu', tag.sudu);
   		});
    
    	var obj = this;
    	window.jQuery = window.$ = require('jquery');
    	function init_screen(){
		      var _top=0;
		      $(".d_show").find("div").show().each(function(){
		      var _left=$(window).width()-$(this).width();
		      var _height=$(window).height();
			  //console.log(_left);
		      _top=_top+76;
		      if(_top>=_height-100){
		        _top=0;
		      }
		
		      $(this).css({left:_left,top:_top,color:getReandomColor()});
		      var base = Math.random()*1.5+1;
		      var time=base*10000;
		      if($(this).index()%2==0){
		        time=base*10000;
		      }
		      $(this).animate({left:"-"+_left+"px"},time,function(){
		      });
		    });
		}
		//随机获取颜色值
		  function getReandomColor(){
		    return '#'+(function(h){
		    return new Array(7-h.length).join("0")+h
		    })((Math.random()*0x1000000<<0).toString(16))
		  }
		  
		  obj.$http.get('scoff/get_read').then((response)=>{
        		var content = response.data.data;
        		obj.$set('content', content);
		    	init_screen();
       		});
       		
		    setInterval(function(){
				obj.$http.get('scoff/get_read').then((response)=>{
	        		var content = response.data.data;
	        		obj.$set('content', content);
			    	init_screen();
	       		});
			}, 15000);
		    
		    setInterval(function(){
		      obj.$set('content', '');  
	      }, 15000);
		    
		    
			
	    	return{}
    },
    route:{
    }
    
}

</script>