/**
 * @author: james
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('iscoller');
    require('dialog');
    var common = require('common');
     require('touchSlider');

    module.exports = {
        album: function(){
            $dragBln = false;
            $(".main_img").touchSlider({
                flexible : true,
                speed : 200,
                counter : function (e){
                }
            });
            $(".main_img").bind("mousedown", function() {
                $dragBln = false;
            });
            $(".main_img").bind("dragstart", function() {
                $dragBln = true;
            });
            $(".main_img a").click(function(){
                if($dragBln) {
                    return false;
                }
            });

            $(".album-con .nav li").click(function(){
                $(".album-con .nav li.act").removeClass("act");
                $(this).addClass("act");
                $(".img_gallery.act").removeClass("act");
                $(".img_gallery").eq($(this).index()).addClass("act");
            });

            $('.album-cont').click(function(){
                $('.page-bg.bg000').addClass('act');
                $('.album-con').addClass('act');
            });
            $('.close-album').click(function(){
                $('.page-bg.bg000').removeClass('act');
                $('.album-con').removeClass('act');
            });
        },
        ditu: function(){
            $(".map-icon").click(function(){
                var lng = $(this).attr("data-lng");
                var lat = $(this).attr("data-lat");
                var content = $(this).attr("data-title");

                map = new BMap.Map("allmap");
                map.centerAndZoom(new BMap.Point(lng,lat), 17);

                var point = new BMap.Point(lng,lat);
                var label = new BMap.Label(content,{offset:new BMap.Size(15,-20)});
                label.setStyle({
                    "color":"#636262", //颜色
                    "fontSize":"14px", //字号
                    "border":"0", //边
                    "textAlign":"center", //文字水平居中显示
                    "cursor":"pointer",
                    "padding":"6px",
                    "background:":"#ffffff"

                });
                addMarker(point,label);
            });
        },
        domain: function() {
            $('.write').click(function() {

                if($("#user_id").val() == ""){
                    common.showDialog("请先登录，再评论！","","/passport/login");
                    return false;
                }else{
                    window.location.href = $(this).attr("data-url");
                }
            });

            $(".check-more").click(function(){
                var _self = $(this);
                var page = _self.attr("data-page");
                var id = _self.attr("data-id");
                if(page == "1"){
                    $.ajax( {
                        url:"/buy/get_house_assess",
                        data: {
                            'id': id,
                            'house_id': $("#house_id").val()
                        },
                        type:'POST',
                        dataType:'json',
                        success:function(data) {
                            html = "";
                            if(data.status == 1){
                                for(var i= 0; i<data.data.length;i++){
                                    html += '<li><div class="com-left">';
                                    html += '<img src="'+data.data[i]['userinfo']['portrait']+'">';
                                    html += '<p>'+data.data[i]['userinfo']['phone_number']+'</p><br>使用惠民安居7天';
                                    html += '</div> <div class="com-right"> <p class="com-text">';
                                    html += ' 配套：'+data.data[i]['support_score']+'分';
                                    html += ' 交通：'+data.data[i]['traffic_score']+'分';
                                    html += ' 环境：'+data.data[i]['green_score']+'分';
                                    html += '<p class="com-info">'+data.data[i]['content']+'</p>';
                                    html += '<div class="com-text">'+data.data[i]['create_time']+'<p class="good"><i></i>1</p></div>';
                                    html += '</div></li>';
                                }
                                $(".com-lists").append(html);

                                if(data.is_page){
                                    _self.attr("data-page",1);
                                    _self.attr("data-id",data.data[data.length-1]['id']);
                                }else{
                                    _self.attr("data-page",0);
                                    _self.html("没有数据了~");
                                }
                            }

                        }

                    });
                }

            });
        },

    	zan : function() {
    		 //赞评论
    	    $(".zan").click(function(){
    	        var _obj = $(this);
    	        var number = parseInt(_obj.attr("data-num"));
    	        var  id = parseInt(_obj.attr("data-id"));
    	        $.ajax( {
    	            url:'/buy/get_ajax_zan',
    	            data: {
    	                'id': id,
    	                'number': number
    	            },
    	            type:'POST',
    	            dataType:'json',
    	            success:function(da) {
    	                if(da.status == 0){
    	                    _obj.attr("data-num",number+1);
    	                    _obj.next("label").html(number+1);
    	                }
    	            }

    	        });
    	    });
    	},
        apply: function() {
            $(".up-img").click(function(){
                var _self = $(this);
                $('#uploadImg').trigger('click');
                showPreview(_self,2);
            });
            $(".house_id").change(function(){

                var _obj = $(this);
                var url = "/buy/get_ajax_model";
                var str = "----请选择户型----";
                getinfo(_obj,url,str);
            });
            //提交申请
            $('.submit').click(function() {
                var phone_number = $("#phone_number").val();

                var card_number = $("#card_number").val();
                var card_expiration = $("#card_expiration").val();
                var auth_status = $("#auth_status").val();
                var email = $("#email").val();
                var sex = $('input[name="sex"]:checked ').val();

                var reg = /^1[3|4|5|8|7][0-9]\d{8}$/;
                var car_reg =  /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i;
                var email_reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                if (!reg.test(phone_number)) {
                    $("#phone_number").next("label").html("电话格式不对！");
                    return false;
                }
                if(auth_status != 2){

                    if(email != ""){
                        if (!email_reg.test(email)) {
                            $("#email").next("label").html("邮箱格式不正确！").css({"font-size":"12px","color":"red"});
                            $("#email").focus();
                            return false;
                        }
                        else{
                            $("#email").next("label").html("");
                        }
                    }

                    if($("#real_name").val() == ""){
                        $("#real_name").next("label").html("真实姓名不能为空！");
                        $("#real_name").focus();
                        return false;
                    }else{
                        $("#real_name").next("label").html("");
                    }

                    if(card_number == ""){
                        $("#card_number").next("label").html("身份证号码不能为空！");
                        $("#card_number").focus();
                        return false;
                    }
                    if (!car_reg.test(card_number)) {
                        $("#card_number").next("label").html("身份证格式不对！");
                        $("#card_number").focus();
                        return false;
                    }else{
                        $("#card_number").next("label").html("");
                    }
                    if($("#card_front").val() == ""){
                        common.showDialog("请上传身份证正面！");
                        return false;
                    }
                    if($("#card_back").val() == ""){
                        common.showDialog("请上传身份证反面！");
                        return false;
                    }

                    if($("#card_expiration").val() == ""){
                        common.showDialog("请填写身份证到期日期！");
                        return false;
                    }

                }


                if($(".house_id").val() == ""){
                    $(".house_id").next("label").html("请选择楼盘！");
                    return false;
                }else{
                    $(".house_id").next("label").html("");
                }

                if($(".model_id").val() == ""){
                    $(".model_id").next("label").html("请选择户型！");
                    return false;
                }else{
                    $(".model_id").next("label").html("");
                }

                $.ajax( {
                    url:'/buy/apply',
                    data: $("#form").serialize(),
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
                        if(data.code == 0){
                        	 $('.page-bg').show();
                             $('.message-cont').show();
                             var n = 3
                             setInterval(function(){
                                 if(n>=0){
                                     $("#time").html(n);
                                 }
                                  n--;
                                 if(n<0){
                                     window.location.href = mobileUrl+"/usercenter/buy_apply";
                                 }
                             },1000);
                        }else{
                        	common.showDialog(data.msg);
                        }
                    },
                    error : function() {
                        common.showDialog("网络错误");
                    }
                });

            });

        },
        comment: function() {
            $('.coment .chose').click(function() {
                $('.coment .chose.act').removeClass('act');
                $(this).addClass('act');
            });

         $(".up-img").click(function(){
                var imgLength= $(".img-lists").find("img").length;
                if(imgLength>5){
                    common.showDialog("上传图片超过上限了！");
                    return false;
                }
                var _self = $(this);
                $('#uploadImg').trigger('click');
                showPreview(_self,1);
            });
           
            $(".img-lists").on('click', '.del', function(){
                $(this).parent(".img-cont").remove();
            });

            $(".submit").click(function(){
                if($("#user_id").val() == ""){
                    showDialog("请先登录，再评论！");
                    return false;
                }

                var intention =  $(".coment p.act").html();
                var support_score =  $(".support_score").val();
                var traffic_score =  $(".traffic_score").val();
                var green_score =    $(".green_score").val();
                var content =  $("#content").val();
                var imgLength= $(".img-lists").find("img").length;
                var img_url = "";

                if(imgLength>0){
                    for(var i=0;i<imgLength;i++){
                        var url = $(".img-lists").find("input").eq(i).val();
                        img_url+=url+",";
                    }
                }

                if(content == ""){
                    common.showDialog("请填写评论内容!");
                    return false;
                }

                $.ajax( {
                    url:'/buy/add_house_assess',
                    data: {
                        'intention': intention,
                        'support_score':parseInt(support_score),
                        'traffic_score':parseInt(traffic_score),
                        'green_score':parseInt(green_score),
                        'content':content,
                        'img_url':img_url,
                        'house_id':$("#house_id").val()
                    },
                    type:'POST',
                    dataType:'json',
                    success:function(data) {
                        url = "/loupan/detail/"+$("#house_id").val()+'.html';
                        common.showDialog(data.msg,"",url);
                     },
                    error : function() {
                        common.showDialog("网络错误");
                    }
                });
            });
        }
    }
    function getinfo(_obj,url,str){
        $.ajax( {
            url:url,
            data: {
                'id': _obj.val()
            },
            type:'POST',
            dataType:'json',
            success:function(data) {
                html = "";
                html += '<option value="">'+str+'</option>';

                if(data.status == 0){
                    for(var i= 0; i<data.data.length;i++){
                        html += ' <option value="'+data.data[i]['id']+'">'+data.data[i]['model_name']+'</option>';
                    }

                    $(".model_id").html(html);

                }
                else{
                    $(".model_id").html(html);
                }

            }

        });
    }
    function showPreview(_self,type) {
        $('#uploadImg').on('change',function(e){
            var data = new FormData();
            $.each($('#uploadImg')[0].files, function(i, file) {
                data.append('fileData', file);
            });
            $.ajax({
                url:'/File/upload',
                type:'POST',
                data:data,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data){
                    $("#uploadImg").unbind("change");
                    if(type == 1){
                        var html = "";
                        if (data.status == 0) {
                            html += '<div class="img-cont"><img  src="'+data.data.url+'"><a href="javascript:;" class="del"></a><input type="hidden" class="img-url" value="'+data.data.file_name+'"></div>';

                            $(".img-lists").append(html);
                        }
                    }else
                    if(type == 2){
                        _self.find("img").attr("src",data.data.url).show();
                        _self.find("input").val(data.data.file_name);
                    }
                    _self = "";
                    e.stopPropagation();

                }
            });
        })
    }
});