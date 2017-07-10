<?php $this->load->view("common/header");?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="/admin"><?php echo $title[0];?></a></li>
        <li><a href="#"><?php echo $title[1];?></a></li>
    </ul>
</div>

<div class="formbody">
    <div class="formtitle"><span><?php echo $title[1];?></span></div>
    <ul class="forminfo">
        <li>
            <label>角色:</label>
            <select class="dfinput" name="group_id">
                <?php foreach($admin_group as $key=>$val){ ?>
                <option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                <?php } ?>
            </select>
           <i> <b>*</b></i>
        </li>
        <li>
            <label>登录名：</label><input name="name" type="text" class="dfinput" id="name" />
            <i id="name-msg" style="color: red">*</i>
        </li>
        <li>
            <label>密码:</label><input name="password" type="password" class="dfinput" id="password" />
            <i  style="color: red">*</i>
        </li>
        <li><label>重复密码:</label><input name="confirpassword" type="password" class="dfinput" id="confirpassword" />
            <i id="confirpassword-msg" style="color: red">*</i>
        </li>
        <li><label>姓名:</label><input name="fullname" type="text" class="dfinput" id="fullname" />
            <i  style="color: red">*</i>
        </li>
        <li><label>Email:</label><input name="email" type="text" class="dfinput" id="email" /><i></i></li>
        <li><label>手机:</label><input name="tel" type="text" class="dfinput" id="tel" /><i></i></li>
        <li><label>描述:</label><input name="describe" type="text" class="dfinput" id="describe" /><i></i></li>
        <li><label>状态:</label>
            <input type="radio" value="1" name="disabled" checked>正常 &nbsp;&nbsp;
            <input type="radio" value="2" name="disabled">禁用</li>
        <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="添加"/></li>
    </ul>
</div>
<script type="text/javascript" src="<?php echo css_js_url('jquery.min.js','common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('dialog.js','common');?>"></script>
<script type="text/javascript">
	$(function(){
		$('#name').focusout(function(){
			var name = $(this).val();
			if(name == ''){
				error('登陆名不能为空！');
			}else{
				$.post('/admin/add_check',{'name':name}, function(data){
					if(data){
						if(data.code == 0){
							error(data.msg);
						}
					}else{
						error('网络异常');
					}
				})
			}
		});
		$(".btn").click(function(){
			var group_id = $("select:eq(0) option:selected").val();
			var developer_id = $("select:eq(1) option:selected").val();
			var name = $('#name').val();
			var password = $('#password').val();
			var confirpassword = $('#confirpassword').val();
			var fullname = $('#fullname').val();
			var email = $('#email').val();
			var tel = $('#tel').val();
			var describe = $('#describe').val();
			var disabled = $("input:checked").val();
			if(name == ''){
				error('登陆名不能为空！');
				return false;
			}
			if(password == ''){
				error('密码不能为空！');
				return false;
			}
			if(confirpassword == ''){
				error('重复密码不能为空！');
				return false;
			}
			if(password != confirpassword){
				error('两次密码不一致！');
				return false;
			}
			if(fullname == ''){
				error('姓名不能为空！');
				return false;
			}
			$.post(
				'/admin/add',
				{
					'group_id':group_id,
					'developer_id':developer_id,
					'name':name,
					'password':password,
					'confirpassword':confirpassword,
					'fullname':fullname,
					'email':email,
					'tel':tel,
					'describe':describe,
					'disabled':disabled
				},
				function(data){
                    if(data){
						if(data.code == 1){
							success(data.msg);
						}else{
							error(data.msg);
						}
                    }else{
						error('网络异常！');
                    }
			   });
		});
  	})
  	function error(msg){
  		var d = dialog({
				id : 'FADO',
				title: '系统提示',
				content: msg,
	            width: 300,
	            okValue: '确定',
	            ok : function(){
					return true;
			    }
  	  		})
  	  	  	d.show();
	}
	function success(msg){
  		var d = dialog({
				id : 'FADO',
				title: '系统提示',
				content: msg,
	            width: 300,
	            okValue: '确定',
	            ok : function(){
	            	window.location.href='/admin';
					return true;
			    }
  	  		})
  	  	  	d.show();
	}
</script>
	</body>
</html>
