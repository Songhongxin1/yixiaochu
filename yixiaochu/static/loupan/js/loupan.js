define(function(require, exports, module){
window.jQuery = window.$ = require("jquery");
    module.exports = {
    		ajaxGetLoupan:function(){
    			$('.premises.new li:nth-child(3n)').css("margin-right", "0");
        	    $('.premises.row2 li:nth-child(2n)').css("margin-right", "0");
        	    $('.dynamic li:nth-child(2n)').css("margin-right", "0");
        	    $('.premises .icon span:nth-child(2n)').css("background", "#c5a9dd");
        	    $('.premises .icon span:nth-child(3n)').css("background", "#ecc896");
        	    $(".new_area li ").click(function(){ 
        	    	$(this).parents("ul").find("a").removeClass('act');
        	        $(this).find("a").addClass('act');
        	    	var area_id = $(this).val();
        	    	$.post("/buy/ajax_data",{area_id:area_id},function(data){
        	    		html = '';
        	    		$.each(data.list,function(index, value){
        		    		var str = "";
        	    		    for(var i=0;i<value.tag.length;i++){
        	    			      str += '<span>'+value.tag[i]+'</span>';
        	        		}
        		    		if(index%2==1){
        		    			html += '<li style="margin-right: 0px;"><a href="/loupan/detail/'+value.id+'.html"><img src="'+value.cover_img+'">';
        		    		}else{
        		    			html += '<li><a href="/loupan/detail/'+value.id+'.html"><img src="'+value.cover_img+'">';
        		    		}
        	    	    	html += '<div class="info"><p class="l">'+value.house_name+'</p>';
        	    	    	html += '<p class="r">'+value.aver_price+'元/平米</p></div>';
        	    	    	html += '<p class="icon">'+str+'</p>';
        	        	    html += '<p class="time">开盘时间：'+value.last_open_time+'</p>';
        	        	    html += '<p class="addres">楼盘地址：'+value.project_addr+'</p>';
        	        	    html += '</li>';
        	    		});
        	    	    $(".new_list").html(html);
        	    	  });
        	    	
        	    });
    			
    		}
    		
    }

});
 