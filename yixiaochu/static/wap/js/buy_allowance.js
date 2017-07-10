/**
 * 补贴记录查询
 * @author chaokai@gz-zc.cn
 */
define(function(require, exports, module){
	window.jQuery = window.$ = require("jquery");
	module.exports = {
			//加载更多
			load_more:function(){
				$(".check-more").click(function(){
					var page = $(this).attr('data-page');
					$.ajax({
						url:'/usercenter/buy_allowance',
						data:{
							page:page
						},
						type:'post',
						success:function(data){
							var content = '';
							$.each(data.data, function(k, v){
								content += '<table border="0" cellspacing="0" cellpadding="0">';
								content += '<tr>';
								content += '<td class="head1">申请ID</td>';
								content += '<td class="head2">'+v.id+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>楼盘名称</td>';
								content += '<td>'+v.house_name+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>名称</td>';
								content += '<td>'+v.model_name+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>补贴开始时间</td>';
								content += '<td class="text-yellow">'+v.start_time+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>补贴结束时间</td>';
								content += '<td>'+v.end_time+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>补贴发放地点</td>';
								content += '<td>'+v.place+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>补贴金额（元）</td>';
								content += '<td>'+v.money+'</td>';
								content += '</tr>';
								content += '<tr>';
								content += '<td>发放时间</td>';
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