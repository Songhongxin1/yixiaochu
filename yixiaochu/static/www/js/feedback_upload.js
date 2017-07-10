jQuery.fn.bindAll = function(options) {
    var $this = this;
    jQuery.each(options, function(key, val){
        $this.bind(key, val);
    });
    return this;
}
var var_file_upload_limit = 1; //图片上传数量限制
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
            var html = "<li id='"+file.id+"' class='pic pro_gre' style='margin-right: 20px'>"+
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
            var value = parseInt(bytesLoaded/file.size)+'%';
            $("#"+file.id).find(".progress").html(value);
            $("#"+file.id).find(".pro_cont").css({'width':value});
        },
        uploadSuccess: function(event, file, serverData){
            $('.log', this).append('<li>Upload success - '+file.name+'</li>');
            if(this.id == 'uploader_feedback_img'){
                var name = 'feedback_img';
            }
            
            var data = $.parseJSON(serverData);
            if(data.error == 0){
                var html = '';
                html += "<a class='close del-pic' href='javascript:;'></a>";
                html += "<img src='"+data.full_url+"'/>";
                html += "<input type='hidden' name='"+name+"' value='"+data.full_url+"'/>";
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
            if($(this).find(".pro_gre").length >= var_file_upload_limit){
            	$(this).find(".add-pic").css({'width':0,'height':0,'border-color':'white'});	//如果已上传的图片数量大于限制数，则隐藏增加按钮
            }
            
        },
        uploadError: function(event, file, errorCode, message){
        	$('.log', this).append('<li>Upload error - '+message+'</li>');
        	/*var html =     "<p>"+file.name+"上传异常:"+message+"</p>";
        	$("#"+file.id).html(html);*/
            
        }
    };

    $('#uploader_feedback_img').bindAll(listeners);
});
        
$(function(){
    var object =[
        {"obj":"#uploader_feedback_img", "btn":"#filePicker"}              //用户反馈的照片
    ];

    $.each(object,function(key,value) {
        $(value.obj).swfupload({
            upload_url: uploadUrl+"/file/upload",
            file_size_limit : "10240",
            file_types : "*.jpg;*.png;*.gif",
            file_types_description : "All Files",
            file_upload_limit : 5,
            flash_url : staticUrl+"/common/css/swfupload.swf",
            button_image_url : staticUrl+'/www/images/add_pic.png',
            button_width : 232,
            button_height : 175,
            button_placeholder : $(value.btn)[0],
            debug: false,
            post_params: {
                'type': 'image'
            }
        });

        $(value.obj).on('click', '.del-pic', function(){
        	$(this).parent().parent().find(".add-pic").css({'width':'220px','height':'175px','border-color':'#a0a0a0'});
            $(this).parent().remove();
        });
    }); 

});    