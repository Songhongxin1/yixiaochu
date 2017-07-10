<?php $this->load->view('common/header2')?>
<ol class="breadcrumb">
  <li><a href="#">首页</a></li>
  <li><a href="/express/index"><?php echo $title[0]?></a></li>
  <li class="active"><?php echo $title[1]?></li>
</ol>

<div class="formbody">
  <div class="formtitle">
      <span><?php echo $title[1]?></span>
    </div>
  <div class="container-fluid">
    <form class="form-horizontal" method="post">
      <div class="form-group">
        <label class="col-sm-1 control-label">账号：</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="name" placeholder="请输入账号名" valType="required" msg="请输入账号名"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">姓名：</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="username" placeholder="请输入姓名" valType="required" msg="请输入账号名"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">密码：</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" name="password" placeholder="请输入密码"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">确认密码：</label>
        <div class="col-sm-3">
          <input type="password" class="form-control" name="repassword" placeholder="请再次输入密码"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">手机号：</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="mobile" placeholder="请输入手机号" valType="MOBILE" msg="手机号格式不正确"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">地址：</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="address" placeholder="请输入地址"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-1 control-label">头像：</label>
        <div class="col-sm-3">
          <ul id="uploader_head_img">
            <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
              <a class="up-img" id="file_head_img" ><span>+</span><br>添加照片</a>
            </li>
          </ul>
        </div>
        <span class="help-block">请上传一张图片，多张默认只采用第一张！</span>
      </div>
      <div class="form-group">
        <button class="btn btn-primary" type="submit">保存</button>
      </div>
    </form>
  </div>
</div>

<?php $this->load->view('common/footer')?>
<script>
seajs.use(['<?php echo css_js_url('express.js', 'admin')?>', 'jqvalidate', 'swfupload', 'jqueryswf', 'admin_upload'], function(a){
    a.checkpassword();
})
</script>