/**
 * 惠民安居首页
 * @author chaokai@gz-zc.cn
 */
define(function(require, exports, module){
	window.jQuery = window.$ = require("jquery");
	require('swiper');
	module.exports = {
			swiper_show:function(){
				var swiper = new Swiper('.wap-banner', {
	                pagination: '.swiper-pagination',
	                paginationClickable: true,
	                autoplay:2000
	            });
			},
			//下拉列表
			select_list:function(){
				$('.select-list').click(function() {
	                $(this).children('.list').toggleClass('act');
	            });
			},
			//半价购房、安居资讯切换
			switch_show:function(){
				$('.index-lists .link').click(function() {
	                $(".index-lists .link.act").removeClass("act");
	                $(this).addClass("act");
	                $(".index-listcont.act").removeClass("act");
	                $(".index-listcont").eq($(this).index()).addClass("act");
	            });
			},
			//视频播放
			media_play:function(){
				$('#media_video').click(function() {
					$('.page-bg').show();
					$(this).children('.video-play').show();
					$('.close-video').click(function() {
						$(".page-bg").hide( function() {});
						$(".video-play").hide( function() {});
					});
				});
			},
			//加载更多
			load_more:function(){
				$('.check-more').click(function(){
					var type = $(this).attr('data-type');
					var page = $(this).attr('data-page');
					var load_more = $(this);
					$.post('/home/load_more', {type:type,page:page}, function(data){
						var content = "";
						if(type == 'loupan'){
							//楼盘加载更多
							$.each(data.data, function(k, v){
								content += '<li class="buy-list">';
								content += '<a href="/loupan/detail/'+v.id+'.html">';
								content += '<div class="list-img"><img src="'+v.cover_img+'"><i></i></div>';
								content += '<div class="list-cont">';
								content += '<div class="title">'+v.house_name+'<p class="text"><span>'+v.aver_price+'</span>元/平</p></div>';
								content += '<p class="text">'+v.project_addr+'</p>';
								content += '<p class="text">开盘时间：'+v.last_open_time+'</p>';
								content += '<div class="icon">';
								$.each(v.tag, function(key, value){
									content += '<span>'+value+'</span>';
								})
								content += '</div>';
								content += '</div>';
								content += '</a>';
								content += '</li>';
							})
						}else if(type == 'news'){
							//资讯加载更多
							$.each(data.data, function(k, v){
								content += '<li>';
								content += '<a href="/news/detail/'+v.id+'">';
								content += '<img src="'+v.cover_img+'">';
								content += '<div>';
								content += '<p class="title">'+v.title+'</p>';
								content += '<i class="tip">热点</i>';
								content += '<p class="text">'+v.summary+'</p>';
								content += '<p class="bot">';
								content += v.agency+' | '+v.publish_time;
								content += '</p>';
								content += '</div>';
								content += '</a>';
								content += '</li>';
							})
						}
						load_more.prev('ul').append(content);
						if(data.next_page != 0){
							load_more.attr('data-page', data.next_page);
						}else{
							load_more.html('没有更多了！');
							load_more.unbind('click');
						}
					})
				})
			}
	}
});