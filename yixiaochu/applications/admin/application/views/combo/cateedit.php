<?php $this->load->view("common/header");?>
<div class="place">
	<span>位置：</span>
	<ul class="placeul">
		<li><a href="/home">首页</a></li>
		<li><a href="/combo/cate"><?php echo $title[0];?></a></li>
		<li><a href=""><?php echo $title[1];?></a></li>
	</ul>
	<span style="float: right; margin-top: 10px;"> <a href="/adminpurview"
		class="add-btn">列表</a>
	</span>
</div>

<div class="formbody">
	<div class="formtitle">
		<span><?php echo $title[1];?></span>
	</div>
	<ul class="forminfo">
		<li><label>分类名称</label><input type="text" id="name" name="name" value="<?php echo $info['name']; ?>" class="dfinput" /><i><b>*</b></i></li>
		<li><label>排序</label><input type="text" id="sort" name="sort" value="<?php echo $info['sort']; ?>" class="dfinput" /><i><b>*</b></i></li>
		<li><label>状态&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="is_del" <?php if($info['is_del']==0) echo 'checked';?> name="is_del" value='0' />保留</label>&nbsp;&nbsp;<label><input type="radio" id="is_del" name="is_del" value='1' <?php if($info['is_del']==1) echo 'checked';?> />删除</li>
		<li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确定" /></li>
	</ul>
</div>
<script src="<?php echo css_js_url('jquery.min.js','common');?>"></script>
<script src="<?php echo css_js_url('dialog.js','common');?>"></script>
<script type="text/javascript">
    $(function(){
    	$('.btn').click(function(){
        	var id = <?php echo $info['id'] ?>;
			var name = $('#name').val();
			var sort = $('#sort').val();
			var is_del = $("input:checked[name='is_del']").val();
    		if(name == ''){
        		error('分类名称不能为空！');
        		return false;
            }else if(sort == ''){
            	error('排序不能为空！');
            	return false;
            }else{
				//检测通过
				$.post('/combo/cateedit', {'id' : id, 'name': name, 'sort': sort, 'is_del': is_del}, function(data){
					if(data.code==1){
						dialog({
							id: 'GSDF',
							title: '系统提示信息',
							width:300,
							height:80,
							content: data.msg,
						    okValue: '关闭',
						    ok: function () {
						    	window.location.href='/combo/cate';
						    }
						}).show();
					}else{
						show(data.msg);
					}
			    });
            }
        });
    });
    
    function show(msg){
    	var d = dialog({
    		id: 'EF893L',
    		width:300,
    		height: 80,
		    title: '系统提示信息',
		    content: msg,
		    cancel: false,
		    ok: function () {}
		});
		d.show();
    }
    function error(msg){
    	var d = dialog({
    		id: 'EF893L',
    		width:300,
    		height: 80,
		    title: '请填写完整信息',
		    content: msg,
		    cancel: false,
		    ok: function () {}
		});
		d.show();
    }
</script>
<?php $this->load->view("common/footer");?>
</body>
</html>