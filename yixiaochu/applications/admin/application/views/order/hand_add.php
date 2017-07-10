<?php $this->load->view('common/header2')?>
<ol class="breadcrumb">
	<li><a href="#">首页</a></li>
	<li><a href="/order"><?php echo $title[0]?></a></li>
	<li class="active"><?php echo $title[1]?></li>
</ol>

<div class="formbody">
	<div class="formtitle">
		<span><?php echo $title[1]?></span>
	</div>
	<div class="container-fluid">
		<form class="form-horizontal" method="post">
			<div class="form-group">
				<label class="col-sm-1 control-label">手机号：</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="user_phone"  placeholder="请输入手机号" valType="MOBILE" msg="手机号格式不正确"/>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label">订单类型：</label>
				<div class="col-sm-3">
					<select id='order_type' class="form-control" name="order_type">
						<option value="0">---请选择类型---</option>
						<option value="1">套餐形式</option>
						<option value="2">单份形式</option>
					</select>
				</div>
			</div>
			<div id='caipu' style="display: none;" class="form-group">
				<label class="col-sm-1 control-label">当前选择：</label>
				<div id='list' class="col-sm-3"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label">支付方式：</label>
				<div class="col-sm-3">
					<select class="form-control" name="pay_type">
						<option value="">---请选择支付方式---</option>
						<option value="1">支付宝</option>
						<option value="2">微信支付</option>
						<option value="3">AA付款</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label">所在地区：</label>
				<div class="col-sm-3">
					<select id='area' class="form-control" name="area">
						<option value="">---请选择所在地区---</option>
						<?php foreach ($area as $k => $v) :?>
						      <option value="<?php echo $v['name']?>"><?php echo $v['name']?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label">所在商圈：</label>
				<div class="col-sm-3">
					<select id='bus_area' bus_area class="form-control" name="bus_area">
						<option value="">---请选择所在商圈---</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label">详细地址：</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="addr_name" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-1 control-label">收货人：</label>
				<div class="col-sm-3">
					<input type="text" class="form-control" name="user_name"  placeholder="请输入收货人" valType="required" msg="请输入收货人"/>
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit">添加订单</button>
			</div>
		</form>
	</div>
</div>

<?php $this->load->view('common/footer')?>
<script type="text/javascript" src="<?php echo css_js_url('jquery.min.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('dialog.js', 'common');?>"></script>
<script>
seajs.use(['<?php echo css_js_url('express.js', 'admin')?>', 'jqvalidate', 'swfupload', 'jqueryswf', 'admin_upload'], function(a){
    a.checkpassword();
})

//订单类型下拉框点击事件
$(document).ready(function () { 
    //当选择地区以后
	$("#area").bind("change",function(){
		var name = $(this).val();
        $.get('/order/get_bus_area',{'name':name},function(data){
            if(data){
            	$.each(data,function(){
            		var html = "<option value='"+this.name+"'>"+this.name+"</option>"
            		$('#bus_area').append(html);
                })
            }
        });
    });

	$("#order_type").bind("change",function(){ 
    if($(this).val()==0){
      return; 
    } 
    else if($(this).val()==2){
        //如果是单份形式
        $('#caipu').attr('style','block');
    	<?php
    $html = '<ul>';
    foreach ($foods as $k => $v) {
        $html .= "<li onclick=check(" . $v['id'] . ",'" . $v['foods_name'] . "'" . ") style='text-align:center;width:100px;height:100px;float:left;margin-left:5px;margin-bottom:25px;'><img value='0' id='f_" . $v['id'] . "' style='width:100px;height:100px;' src='" . get_full_img_url($v['cover_img']) . "'/> </br>" . $v['foods_name'] . "</br></li>";
    }
    $html .= '</ul>'?>
    	var html = "<?php echo $html;?>";
    	var d = dialog({
            id: 'GDAF',
    	    title: '菜谱列表',
    	    width: 425,
    	    content: html,
    	    okValue: '确定',
    	    ok:true,
    	    cancelValue: '取消',
    	    cancel: function () {
    	    	$('#caipu').attr('style','display:none');
    	    }
    	});
    	d.show();
    }else if($(this).val()==1){
        //如果是套餐
    	$('#caipu').attr('style','block');
    	<?php
            $html = '<ul>';
            foreach ($combo as $k => $v) {
            $html .= "<li onclick=checks(" . $v['id'] . ",'" . $v['combo_name'] . "'" . ") style='text-align:center;width:100px;height:100px;float:left;margin-left:5px;margin-bottom:25px;'><img value='0' id='f_" . $v['id'] . "' style='width:100px;height:100px;' src='" . get_full_img_url($v['cover_img']) . "'/> </br>" . $v['combo_name'] . "</br></li>";
            }
            $html .= '</ul>';
        ?>
    	    	var html = "<?php echo $html;?>";
    	    	var d = dialog({
                    id: 'FDSK',
    	    	    title: '套餐列表',
    	    	    width: 425,
    	    	    content: html,
    	    	    okValue: '确定',
    	    	    ok:true,
    	    	    cancelValue: '取消',
    	    	    cancel: function () {
    	    	    	$('#caipu').attr('style','display:none');
    	    	    }
    	    	});
    	    	d.show();
    }
  }); 
});
function  check(id,name){
	if($('#f_'+id).attr('value')==1){
    	//取消被选中
		$('#f_'+id).attr('style','width:100px;height:100px;');
		$('#f_'+id).attr('value',0);
		//将套餐菜谱删除
		$('#s_'+id).remove();
    }else{
        //将图片框样式设置成被选中状态
    	$('#f_'+id).attr('style','width:100px;height:100px;border:2px solid #357ebd');
    	$('#f_'+id).attr('value',1);
    	//选中菜谱时增加一个输入框
    	var str = $('#list').html();
        var input = "<span id='s_"+id+"'>"+name+" : x <input style='width:20px' type='text' value='"+1+"' name='ids["+id+"]' /> 份</span>"
    	$('#list').html(str+input);
        
    }
}
function  checks(id,name){
	if($('#f_'+id).attr('value')==1){
    	//取消被选中
		$('#f_'+id).attr('style','width:100px;height:100px;');
		$('#f_'+id).attr('value',0);
		//将套餐菜谱删除
		$('#s_'+id).remove();
    }else{
        //将图片框样式设置成被选中状态
        $("img[value='1']").attr('style','width:100px;height:100px;border:1px;');
    	$('#f_'+id).attr('style','width:100px;height:100px;border:2px solid #357ebd');
    	$('#f_'+id).attr('value',1);
    	//选中菜谱时增加一个输入框
        var input = "<span id='s_"+id+"'>"+name+" : x <input style='width:20px' type='text' value='"+1+"' name='ids["+id+"]' /> 份</span>"
    	$('#list').html(input);
        
    }
}
</script>