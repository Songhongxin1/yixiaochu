$('.search-but').click(function(){
	var keywords = $(this).prev($('input[name="search"]')).val();
    if(keywords == ''){
    	 return false;
    }
    window.location.href="/buy?keywords="+keywords;
}); 