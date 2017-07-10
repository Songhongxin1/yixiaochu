jQuery.fn.bindAll = function(options) {
    var $this = this;
    jQuery.each(options, function(key, val){
        $this.bind(key, val);
    });
    return this;
}
//图片上传限制数量
var upload_limit = 1;
$(function(){
    
    var listeners = {
        swfuploadLoaded: function(event){
            $('.log', this).append('<li>Loaded</li>');
        },
        fileQueued: function(event, file){
            $('.log', this).append('<li>File queued - '+file.name+'</li>');
            // start the upload once it is queued
            // but only if this queue is not disabled
            if (!$('input[name=disabled]:checked', this).length) {
                $(this).swfupload('startUpload');
            }
        },
        fileQueueError: function(event, file, errorCode, message){
            $('.log', this).append('<li>File queue error - '+message+'</li>');
        },
        fileDialogStart: function(event){
            $('.log', this).append('<li>File dialog start</li>');
        },
        fileDialogComplete: function(event, numFilesSelected, numFilesQueued){
            $('.log', this).append('<li>File dialog complete</li>');
        },
        uploadStart: function(event, file){
            $('.log', this).append('<li>Upload start - '+file.name+'</li>');
            // don't start the upload if this queue is disabled
            if ($('input[name=disabled]:checked', this).length) {
                event.preventDefault();
            }
            var html = "<li id='"+file.id+"' class='pic pro_gre' style='margin-right: 10px'>"+
                        "<div class='proCont'>"+
                        "<p class='progress'>0%</p>"+
                        "<div class='pro_pic'>"+
                            "<i  class='pro_cont' style='width:0%'></i>"+
                        "</div>"+
                    "</div></li>";
            $(this).find(".add-pic").before(html);
        },
        uploadProgress: function(event, file, bytesLoaded){
            $('.log', this).append('<li>Upload progress - '+bytesLoaded+'</li>');
            var value = bytesLoaded/file.size*100+'%';
            $("#"+file.id).find(".progress").html(value);
            $("#"+file.id).find(".pro_cont").css({'width':value});
        },
        uploadSuccess: function(event, file, serverData){
            $('.log', this).append('<li>Upload success - '+file.name+'</li>');
            if(this.id == 'uploader_card_front'){
                var name = 'card_front';
            } else if (this.id == 'uploader_card_back') {
                var name = 'card_back';
            }
            
            var data = $.parseJSON(serverData);
            if(data.error == 0){
                var html = '';
                html += "<a class='close del-pic' href='javascript:;'></a>";
                html += "<img src='"+data.full_url+"'/>";
                $('#cover_img').val($('#cover_img').val()+data.url+',');
            }else{
                var html =     "<p>"+file.name+"上传异常</p>"
            }
            $("#"+file.id).html(html);
        },
        uploadComplete: function(event, file){
            $('.log', this).append('<li>Upload complete - '+file.name+'</li>');
            // upload has completed, lets try the next one in the queue
            // but only if this queue is not disabled
            if (!$('input[name=disabled]:checked', this).length) {
                $(this).swfupload('startUpload');
            }
        },
        uploadError: function(event, file, errorCode, message){
        	$('.log', this).append('<li>Upload error - '+message+'</li>');
        	/*var html =     "<p>"+file.name+"上传异常:"+message+"</p>";
        	$("#"+file.id).html(html);*/
            
        }
    };

    $('#img_box').bindAll(listeners);
});
        
$(function(){
    $('#img_box').swfupload({
        upload_url: uploadUrl+"/file/upload",
        file_size_limit : "10240",
        file_types : "*.jpg;*.png;*.gif",
        file_types_description : "All Files",
        file_upload_limit : 0,
        flash_url : staticUrl+"/common/css/swfupload.swf",
        button_image_url : staticUrl+'/www/images/add_pic.png',
        button_width : 220,
        button_height : 175,
        button_placeholder_id : 'filePicker',
        debug: false,
        post_params: {
            'type': 'image'
        }
    });
    $('#img_box').on('click', '.del-pic', function(){
        $(this).parent().remove();
    });

});    
