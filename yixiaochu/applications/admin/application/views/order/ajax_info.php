<html>
<head>
    <link href="<?php echo css_js_url('ui-dialog.css', 'admin')?>" type="text/css" rel="stylesheet">
  <link href="<?php echo css_js_url('bootstrap.min.css', 'admin')?>" type="text/css" rel="stylesheet">
</head>
<body>
<table class="table table-bordered">
  <tbody>
    <tr>
      <td>支付方式：<?php echo $info['pay_type_text']?></td>
      <td>订单状态：<?php echo $info['status_text']?></td>
      <td>订单类型：<?php echo $info['order_type_text']?></td>
      
    </tr>
    <tr>
      <td>顾客姓名：<?php echo $info['user_info']['user_name']?></td>
      <td>顾客电话：<?php echo $info['user_info']['addr_phone']?></td>
      <td>顾客地址：<?php echo $info['user_info']['bus_area'].$info['user_info']['area'].$info['user_info']['addr_name']?></td>
      
    </tr>
  </tbody>
</table>
<?php if($info['order_type'] == C('order.type.combo.id')):?>
<?php foreach($info['detail'] as $k => $v):?>

<p class="h3">
    套餐名称：<?php echo $v['order_name']?>&nbsp;份数：<?php echo $v['buy_number']?>
</p>
<table class="table table-bordered">
    
  <thead>
    <tr>
      <th>名称</th>
      <th>原价</th>
      <th>现价</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($v['foods'] as $key => $value):?>
    <tr>
      <td><?php echo $value['foods_name']?></td>
      <td><?php echo $value['old_price']?></td>
      <td><?php echo $value['now_price']?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>
<?php endforeach;?>
<?php elseif($info['order_type'] == C('order.type.single.id')):?>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>名称</th>
      <th>单价</th>
      <th>数量</th>
      <th>总价</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($info['detail'] as $k => $v):?>
    <tr>
      <td><?php echo $v['order_name']?></td>
      <td><?php echo $v['pay_price']/$v['buy_number']?></td>
      <td><?php echo $v['buy_number']?></td>
      <td><?php echo $v['pay_price']?></td>
    </tr>
<?php endforeach;?>
  </tbody>
</table>
<?php endif;?>
<p class="h3 text-right">
    价格总计：<?php echo $info['need_pay']?> 元
</p>
<div class="hidden-print">
<button class="btn btn-primary" onclick="window.print()">打印</button>
<?php if($info['status'] < C('order.status.sended.id')):?>
<?php if($info['status'] == C('order.status.wait_send.id')):?>
<button class="btn btn-primary" id="send" data-id="<?php echo $info['id']?>">发货</button>
<?php endif;?>
<button class="btn btn-primary" id="del" data-id="<?php echo $info['id']?>">删除</button>
<?php endif;?>
</div>
<script src="<?php echo css_js_url('jquery.min.js', 'admin')?>"></script>
<script src="<?php echo css_js_url('dialog.js', 'admin')?>"></script>
<script>
    //发货
    $('#send').click(function(){
        var d = dialog({
            title:'提示',
            content:'确认发货？',
            okValue:'确认',
            cancelValue:'取消',
            cancel:function(){},
            ok:function(){
                var obj = this;
                var id = $('#send').attr('data-id');
                $.post('/order/set', {key:'status', value:<?php echo C('order.status.sended.id')?>, id:id}, function(data){
                        if(data.status == 0){
                            var d2 = dialog({
                                title:'提示',
                                content:'操作成功',
                                okValue:'确认',
                                ok:function(){
                                    obj.remove();
                                }
                                
                            })
                            d2.width(200);
                            d2.show();
                        }else{
                            var d2 = dialog({
                                title:'提示',
                                content:data.msg,
                                okValue:'确认',
                                ok:function(){
                                    obj.remove();
                                }
                                
                            })
                            d2.width(200);
                            d2.show();
                        }
                })
                return false;
            }
        })
        d.width(320);
        d.show();
        
    })
    //删除
    $('#del').click(function(){
        var d = dialog({
            title:'提示',
            content:'确认删除？',
            okValue:'确认',
            cancelValue:'取消',
            cancel:function(){},
            ok:function(){
                var obj = this;
                var id = $('#send').attr('data-id');
                $.post('/order/set', {key:'is_del', value:1, id:id}, function(data){
                        if(data.status == 0){
                            var d2 = dialog({
                                title:'提示',
                                content:'操作成功',
                                okValue:'确认',
                                ok:function(){
                                    obj.remove();
                                }
                                
                            })
                            d2.width(200);
                            d2.show();
                        }else{
                            var d2 = dialog({
                                title:'提示',
                                content:data.msg,
                                okValue:'确认',
                                ok:function(){
                                    obj.remove();
                                }
                                
                            })
                            d2.width(200);
                            d2.show();
                        }
                })
                return false;
            }
        })
        d.width(320);
        d.show();
        
    })
</script>
</body>
</html>