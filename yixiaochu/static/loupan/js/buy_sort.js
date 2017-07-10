define(function(require, exports, module){
window.jQuery = window.$ = require("jquery");
    module.exports = {
		select_sort:function(){
			$(".sort li").click(function(){ 
		    	var sort = $(this).val();
		    	var url = window.location.href;
		    	if(url.indexOf('loupan/') == -1){
		    		var url = url+'/'+'a0m0p0t0c0sti0spr0.html';
		    	}
		    	var new_url = url.replace(/sti[0-9]*/g,"sti0");
		    	var new_url = new_url.replace(/spr[0-9]*/g,"spr"+sort);
		    	window.location.href = new_url;
		    });
			
		},
		select_time:function(){
		    $(".time li").click(function(){ 
		    	var time = $(this).val();
		    	var url = window.location.href;
		    	if(url.indexOf('loupan/') == -1){
		    		var url = url+'/'+'a0m0p0t0c0sti0spr0.html';
		    	}
		    	var new_url = url.replace(/spr[0-9]*/g,"spr0");
		    	var new_url = new_url.replace(/sti[0-9]*/g,"sti"+time);
		    	window.location.href = new_url;
		    });
		},
		del:function(){
		    //删除所有选中标签
		    $(".del").click(function(){
		        window.location.href="/loupan";
		    });
		}
}
});
