$(function(){
//评论弹窗
    $('.write').click(function() {
        if($("#user_id").val() == ""){
            showDialog("请先登录，再评论！","",baseUrl+"/passport/login");
            return false;
        }
        $('.page-bg').addClass('act');
        $('.ases-box').addClass('act');
    });

    $("#sub").click(function(){
      var intention =  $(".box-cont a.act").html();
      var support_score =  $(".rev_pro .zb").html();
      var traffic_score =  $(".box-cont .jt").html();
      var green_score =  $(".box-cont .lh").html();
      var content =  $("#content").val();
      var img_url =  $("#cover_img").val();
    if($("#user_id").val() == ""){
        showDialog("请先登录，再评论！");
        return false;
    }
        if(content == ""){
            showDialog("请填写评论内容!");
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
                showDialog(data.msg);
               setTimeout(function(){
                   $(".close-box").trigger("click");
               },3000);
            },
            error : function() {
                showDialog("网络错误");
            }
        });
    });
    //填写身份证号
    $("#card_number_show").bind('input', function(){
    	$("#card_number").val($(this).val());
    })
    //提交申请
    $('.submit').click(function() {
        var phone_number = $("#phone_number").val();

        var card_number = $("#card_number").val();
        var card_expiration = $("#card_expiration").val();
        var auth_status = $("#auth_status").val();
        var email = $("#email").val();
        var sex = $('input[name="sex"]:checked ').val();

        var reg = /^1[3|4|5|8|7][0-9]\d{8}$/;
        var car_reg =  /^\d{6}(18|19|20)?\d{2}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}(\d|X)$/;
        var email_reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        if (!reg.test(phone_number)) {
            $("#phone_number").next("label").html("电话格式不对！");
            return false;
        }
        if(auth_status != 2){

            if(email != ""){
                if (!email_reg.test(email)) {
                    $("#email").next("label").html("邮箱格式不正确！");
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
                showDialog("请上传身份证正面！");
                return false;
            }
            if($("#card_back").val() == ""){
                showDialog("请上传身份证反面！");
                return false;
            }

            if($("#card_expiration").val() == ""){
                showDialog("请填写身份证到期日期！");
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
                        if(n<=-2){
                            window.location.href = baseUrl+"/usercenter/buy_apply";
                        }
                    },1000);
                }else{
                    showDialog(data.msg);
                }
            },
            error : function() {
                showDialog("网络错误");
            }
        });

    });

    //删除照片
    $("#index1-del").click(function(){
        var dataSrc = $("#index1").attr("data-src");
        $("#index1").attr("src",dataSrc);
        $("#card_front").val("");
    });
    $("#index2-del").click(function(){
        var dataSrc = $("#index2").attr("data-src");
        $("#index2").attr("src",dataSrc);
        $("#card_back").val("");
    });

    $(".close").click(function(){
        $('.page-bg').hide();
        $('.message-cont').hide();
        window.location.href = baseUrl+"/usercenter/buy_apply";
    });

    //选择户型

   $("#xz-model-select li").click(function(){
       $("#xz-model").html($(this).html());
       var totalPrice = $(this).attr("data-value");
       $("#total-price").val(totalPrice);

    });

    $("#jicheng-select li").click(function(){
        $("#jicheng-name").html($(this).html());
        var key = $(this).attr("data-value");
        $("#jicheng").val(key);

    });

    $("#level-select li").click(function(){
        $("#level-name").html($(this).html());
        var key = $(this).attr("data-value");
        $("#bjbt-level").val(key);

    });

    $("#rate-type-select li").click(function(){
        $("#rate-type-name").html($(this).html());
        var key = $(this).attr("data-value");
        $("#rate-type").val(key);
        $("#gjjdk,#sydk").hide();

    });

    $("#times-select li").click(function(){
        $("#times-name").html($(this).html());
        var key = $(this).attr("data-value");
        $("#times").val(key);

    });
    $(".dk-type-3").click(function(){
        $("#gjjdk,#sydk").show();
    });


    $(".house_id").change(function(){
        var _obj = $(this);
        var url = "/buy/get_ajax_model";
        var str = "----请选择户型----";
        getinfo(_obj,url,str);
    });

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



    function showDialog(msg, title, url){
        var title = arguments[1] ? arguments[1] : '提示信息';
        var url = arguments[2] ? arguments[2] : '';
        var d = dialog({
            title: title,
            content: msg,
            modal:false,
            okValue: '确定',
            ok: function () {
                if(url != '')
                {
                    window.location.href=url;
                }
                return true;
            }
        });
        d.width(320);
        d.show();
    }

    $("#jisuan").click(function(){

       var rate = $("#rate-type").val();
        var totalPrice = parseInt($("#total-price").val())?parseInt($("#total-price").val()):0;
        $("#zj").html(totalPrice+"万");
        var jicheng = parseInt($("#jicheng").val());
        var shoufu_je = Math.round(totalPrice*(jicheng/10));
        $("#text1").html('首付：    '+shoufu_je+'万 '+jicheng+'成');
        $(".text2").html('贷款金额：    '+(totalPrice-shoufu_je)+'万');

        //判断贷款类别
        var rate_type = parseInt($("#rate-type").val());
        var dklv = 0;
        if(rate_type == 1){ //商贷
            dklv = 4.9/100;
         }else{
            dklv = 3.25/100;
        }

        //选择半价后补贴
        var level_val =  $("#bjbt-level").val();

        var dk_money = (totalPrice-shoufu_je)*10000; //贷款总额
        var type =  parseInt($(".left-link").find("a[class='check act']").attr("data-value"));
        var month = parseInt($("#times").val());//贷款时间
        var zhifu_lixi1 = 0;
        if(rate_type == 3){
            //--  组合型贷款(组合型贷款的计算，只和商业贷款额、和公积金贷款额有关，和按贷款总额计算无关)
            var total_gjj = parseInt($("#total_gjj").val())*10000;
            var total_sy = parseInt($("#total_sy").val())*10000;
            if(isNaN(total_gjj) || total_gjj== ""){
                showDialog("公积金贷款表单请输入数字！");
                return false;
            }
            if(isNaN(total_sy) || total_sy== ""){
                showDialog("公积金贷款表单请输入数字！");
                return false;
            }

            //贷款总额
            var dk_money = total_sy + total_gjj;

            var lilv_sd =  4.9/100;
            var lilv_gjj =   3.25/100;
            var all_total2 = 0;
            var month_money2 = "";
            for(j = 0; j < month; j++){
                //调用函数计算: 本金月还款额
                huankuan = getMonthMoney2(lilv_sd, total_sy, month, j) + getMonthMoney2(lilv_gjj, total_gjj, month, j);
                all_total2 += huankuan;
                huankuan = Math.round(huankuan * 100) / 100;
                month_money2 += (j + 1) + "月," + huankuan + "(元)\n";
            }


            if(type == 2){//等额本金
                //还款总额
                var huankuan_total = Math.round(all_total2 * 100) / 100;
                var total_hk = Math.round((huankuan_total/10000)* 100) / 100;
                var final_total_hk = Math.round((total_hk+shoufu_je)* 100) / 100;
                $("#total-hk").html(final_total_hk+"万");

                //支付利息款
                var zhifu_lixi1 = Math.round( (all_total2 - dk_money) * 100) / 100;

                $(".text3").html('偿还利息：    '+zhifu_lixi1+'元');
                yuejun_huankuan = Math.round((huankuan_total/month)*100)/100;
                $("#huaikuan").html(yuejun_huankuan+"元");
                getLevelValue(level_val,final_total_hk,zhifu_lixi1,yuejun_huankuan,2);
            }

            if(type==1){  //等额本息

                //月均还款
                var month_money1 = getMonthMoney1(lilv_sd, total_sy, month) + getMonthMoney1(lilv_gjj, total_gjj, month);//调用函数计算
                yuejun_huankuan = Math.round(month_money1 * 100) / 100 + "(元)";

                //还款总额
                var all_total1 = month_money1 * month;
                var total_hk = Math.round((all_total1/10000)* 100) / 100;
                var final_total_hk = Math.round((total_hk+shoufu_je)* 100) / 100;
                $("#total-hk").html(final_total_hk+"万");

                //支付利息款
                zhifu_lixi1 = Math.round((all_total1 - dk_money) * 100) / 100;
                $(".text3").html('偿还利息：    '+zhifu_lixi1+'元');
                $("#huaikuan").html(yuejun_huankuan);
                getLevelValue(level_val,final_total_hk,zhifu_lixi1,yuejun_huankuan,2);
            }


        }else{

            if($("#total-price").val() == ""){
                showDialog("请选择户型！");
                return false;
            }

            var all_total2 = 0;
            var month_money2 = "";

            for(j = 0; j < month; j++){
                //调用函数计算: 本金月还款额
                huankuan = getMonthMoney2(dklv, dk_money, month, j) ;
                all_total2 += huankuan;
                huankuan = Math.round(huankuan * 100) / 100;
                month_money2 += (j + 1) + "月," + huankuan + "(元)\n";
            }

            if(type == 2){//等额本金
                //还款总额
                var huankuan_total = Math.round(all_total2 * 100) / 100;
                var total_hk = (Math.round((huankuan_total/10000)* 100) / 100);
                var final_total_hk = Math.round((total_hk+shoufu_je)* 100) / 100;
                $("#total-hk").html(final_total_hk+"万");


                //支付利息款
                var zhifu_lixi1 = Math.round( (all_total2 - dk_money) * 100) / 100;

                $(".text3").html('偿还利息：    '+zhifu_lixi1+'元');
                yuejun_huankuan = Math.round((huankuan_total/month)*100)/100;
                $("#huaikuan").html(yuejun_huankuan+"元");

                getLevelValue(level_val,totalPrice,zhifu_lixi1,yuejun_huankuan,1);
            }

            if(type == 1){ //等额本息
                var month_money1 = getMonthMoney1(dklv, dk_money, month);//调用函数计算
                var yuejun_huankuan = Math.round(month_money1 * 100) / 100 ;

                //还款总额
                var all_total1 = Math.round(month_money1 * month * 100) / 100;
                var total_hk = (Math.round((all_total1/10000)* 100) / 100);
                var final_total_hk = Math.round((total_hk+shoufu_je)* 100) / 100;
                $("#total-hk").html(final_total_hk+"万");

                //支付利息款
                zhifu_lixi2 = (Math.round( (all_total1 - dk_money) * 100) / 100);
                zhifu_lixi1  = zhifu_lixi2;
                $(".text3").html('偿还利息：    '+zhifu_lixi2+'元');
                //月均还款 (参数: 年利率/贷款总额/贷款总月份)
                $("#huaikuan").html(yuejun_huankuan+"元");

                //选择半价后补贴
                getLevelValue(level_val,totalPrice,zhifu_lixi1,yuejun_huankuan,1);
            }
        }
        $("#echart-count").html("");
        $.ajax({
            url: '/buy/jisuan',
            data:{
                "shoufu_je":shoufu_je*10000,
                "zhifu_lixi1":zhifu_lixi1,
                "dk_money":dk_money
            },
            type:'POST',
            dataType: 'json',
            success: function (data) {
                 baiduEcharts(data);
            }
        });

    });

    function getLevelValue(level,total,lixi,money_hk,type){

        $.ajax({
            url: '/buy/ajax_level_value',
            data:{
                "level":level,
                "total":total
              },
            type:'POST',
            dataType: 'json',
            success: function (data) {
                if(type == 2){
                    var bj_money =  Math.round( (total-data.total_butie) * 100) / 100;
                 }else{
                    var final_tital = parseInt(total)+(lixi/10000);
                    var bj_money =  Math.round( (final_tital-data.total_butie) * 100) / 100;
                }
                var bt_hk = Math.round( (money_hk-(data.month_butie*10000)) * 100) / 100;

                $("#bj-total-hk").html(bj_money+"万");
                $("#last-huaikuan").html(bt_hk+"元");
            }
        });
    }

    //本金还款的月还款额(参数: 年利率 / 贷款总额 / 贷款总月份 / 贷款当前月0～length-1)
    function getMonthMoney2(lilv, total, month, cur_month){
        var lilv_month = lilv / 12;//月利率
       var benjin_money = total / month;
        return (total - benjin_money * cur_month) * lilv_month + benjin_money;
    }
   //本息还款的月还款额(参数: 年利率/贷款总额/贷款总月份)
    function getMonthMoney1(lilv, total, month){
        var lilv_month = lilv / 12;//月利率
        return total * lilv_month * Math.pow(1 + lilv_month, month) / ( Math.pow(1 + lilv_month, month) -1 );
    }


    function baiduEcharts(data){
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('echart-count'));

        option = {
            tooltip : {
                trigger: 'item',
                formatter: "{b}({d}%)"
            },
            series : [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius : '80%',
                    center: ['50%', '50%'],
                    data:data,
                    color:['#F0C7C5','#fad797','#B8DBF1'],
                    itemStyle: {
                        normal:{
                            label:{
                                show: false,
                                formatter: null
                            },

                            labelLine :{show:false}

                        }
                    }
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    }

});
