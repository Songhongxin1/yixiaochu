/**
 * 评论页js
 */
define(function(require, exports, module){
	window.jQuery = window.$ = require("jquery");
	module.exports = {
			//加载更多
			load_more:function(){
				$(".check-more").click(function(){
					var page = $(this).attr('data-page');
					$.ajax({
						url:'/usercenter/comment',
						data:{
							page:page
						},
						type:'post',
						success:function(data){
							var content = '';
							$.each(data.data, function(k, v){
								content += '<table border="0" cellspacing="0" cellpadding="0">';
								content += '<tr>';
								content += '<td class="head1">编号</td>';
								content += '<td class="head2">'+v.id+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>楼盘名称</td>';
								content += '<td>'+v.house_name+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>周边配套评分</td>';
								content += '<td>'+v.support_score+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>变通环境评分</td>';
								content += '<td >'+v.traffic_score+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>绿化环境评分</td>';
								content += '<td>'+v.green_score+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>评价内容</td>';
								content += '<td class="text-blue">'+v.content+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>评价时间</td>';
								content += '<td>'+v.create_time+'</td>';
								content += '</tr>';
								content += '</table>';
							})
							$('.check-more').before(content);
							if(data.next_page){
								$('.check-more').attr('data-page', data.next_page);
							}else{
								$('.check-more').remove();
							}
						}
						
					})
				})
			}
	}
})