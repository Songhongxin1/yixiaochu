
define(function(require, exports, module){
    window.jQuery = window.$ = require('jquery');
    require('dialog');
    
    module.exports = {
            onload:function(){
                $(function(){refresh()});
            },
            //自动刷新
            auto_refresh:function(){
                var interval;
                var time = 20;
                //自动刷新
                interval = setInterval(function(){
                    $('#refresh_text').text((time--)+'秒后刷新');
                    if(time < 1){
                        refresh();
                        time = 20;
                    }
                }, 1000);
                //开启/关闭自动刷新
                $('#refresh_open').click(function(){
                    $(this).removeClass('btn-default').addClass('btn-warning');
                    $('#refresh_close').removeClass('btn-warning').addClass('btn-default');
                    interval = setInterval(function(){
                        $('#refresh_text').text((time--)+'秒后刷新');
                        if(time < 1){
                            refresh();
                            time = 20;
                        }
                    }, 1000);
                })
                $('#refresh_close').click(function(){
                    $(this).removeClass('btn-default').addClass('btn-warning');
                    $('#refresh_open').removeClass('btn-warning').addClass('btn-default');
                    clearInterval(interval);
                })
                //手动刷新
                $('#refresh_auto').click(function(){
                    refresh();
                })
            },
            //搜索
            search:function(){
                $('#search').click(function(){
                    var time = $('input[name=time]').val();
                    var status = $('input:checked[name=status]').val();
                    //关闭自动刷新
                    $('#refresh_close').trigger('click');
                    refresh(status, time);
                })
            },
            //查看详情
            detail:function(){
                $(document).on('click', '.detail', function(){
                    var id = $(this).attr('data-id');
                    var content = '<iframe src="/order/info/'+id+'" style="width:100%;height:100%"></iframe>';
                    var d = dialog({
                        title:'订单详情',
                        content:content,
                        
                    })
                    d.width(500);
                    d.height(800)
                    d.showModal();
                    
                })
            }
    }
    //刷新操作
    function refresh(){
        var status = arguments[0] ? arguments[0] : 0;
        var time = arguments[1] ? arguments[1] : 0;
        var page = arguments[2] ? arguments[2] : 0;
        
        $('.table tbody').html('<tr><td colspan="8">加载中...</td></tr>');
        $.post('/order/get_list', {status:status,time:time,page:page}, function(data){
            if(data.status == 0){
                var content = '暂无数据';
                $.each(data.data.list, function(k, v){
                    content += '<tr>';
                    content += '<td>'+(k+1)+'</td>';
                    content += '<td>'+v.order_number+'</td>';
                    content += '<td>'+v.user_name+'</td>';
                    content += '<td>'+v.user_phone+'</td>';
                    content += '<td>'+v.status_text+'</td>';
                    content += '<td>'+v.create_time+'</td>';
                    content += '<td><a href="#" class="detail" data-id="'+v.id+'">详情</a></td>';
                    content += '</tr>';
                })
                $('.table tbody').html(content);
                $('#pagestr').html(data.data.pagestr);
            }
        })
    }
    
})