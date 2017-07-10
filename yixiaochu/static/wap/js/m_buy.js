
$(function(){
	$(".sure").click(function(){
		var area_id = $("ul.area .click").val();
		var area_name = $("ul.area .click").text();
		var model_id = $("ul.bedroom_type .click").val();
		var price_id = $("ul.price .click").val();
		var type_id = $("ul.type .click").val();
		var character_id = $("ul.character .click").val();
		var hot_id = 0;
		var time_id = 0;
		if($("ul#sort .hot").hasClass('click')){
			hot_id = 1;
		}
		if($("ul#sort .new").hasClass('click')){
			time_id = 1;
		}
		window.location.href = base_url+'/loupan/a'+area_id+'m'+model_id+'p'+price_id+'t'+type_id+'c'+character_id+'sti'+time_id+'spr'+hot_id+'.html';
	});
	
	$("ul.area li").click(function(){
		var area_name = $(this).text();
		$("#area").text(area_name);
	});
	
	$("ul.bedroom_type li").click(function(){
		var model_name = $(this).text();
		$("#bedroom_type").text(model_name);
	});
	
	$("ul.price li").click(function(){
		var price = $(this).text();
		$("#price").text(price);
	});
	
	$("ul.type li").click(function(){
		var type = $(this).text();
		$("#type").text(type);
	});
	
	$("ul.character li").click(function(){
		var character = $(this).text();
		$("#character").text(character);
	});
	
	$('.J_load_more').click(function(){
		var next_page = $('.J_load_more').attr('next_page');
		$.post('',{page:next_page}, function(data){
	   		 var list_html = '';
	   		  $.each(data.list,function(index, value){
	   			var str = "";
    		    for(var i=0;i<value.tag.length;i++){
    			      str += '<span>'+value.tag[i]+'</span>';
        		}
	   			list_html += '<a href="/loupan/detail/'+value.id+'.html"><li class="buy-list"><div class="list-img">';
	   			list_html += '<img src="'+value.cover_img+'"><i></i></div>';
	   			list_html += '<div class="list-cont"><div class="title">'+value.house_name+'<p class="text">';
	   			list_html += '<span>'+value.aver_price+'</span>元/平</p></div>';
	   			list_html += '<p class="text">'+value.project_addr+'</p>';
	   			list_html += '<p class="text">开盘时间：'+value.last_open_time+'</p>';
	   			list_html += '<div class="icon">'+str;
	   			list_html += '</div></div></li></a>';
	   		  });
	   		$('.load_more').append(list_html);
	   		$('.J_load_more').attr('next_page', data.next_page);
	   		  if( !data.is_load_more){
	   			$('.J_load_more').hide();
   		      }
	   	 });
		
	});
})