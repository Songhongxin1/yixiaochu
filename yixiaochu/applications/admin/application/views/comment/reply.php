<?php $this->load->view('common/header');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/common">首页</a></li>
        <li><a href="/question">吐槽中心</a></li>
        <li><a href="javascript:;">回复吐槽</a></li>
    </ul>
</div>

<div class="formbody">

    <div class="formtitle"><span>修改问题</span></div>
    <ul class="forminfo">
        <li>
            <label>问题</label>
            <textarea name="title" class="textinput" /><?php echo $reply['content'];?></textarea>
        </li>
        <li>
            <label>回复内容</label>
    <form  method="post" id="form">
            <script id="editor" type="text/plain" style="float:left;width: 620px;" name="reply"></script>
            <input type="hidden" name="id" value="<?php echo $id?>">
        </li>
        <li><label>&nbsp;</label><br /><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
</div>
<script type="text/javascript" src="<?php echo css_js_url('jquery.min.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('common.js', 'admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('jquery.swfupload.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('swfupload.js', 'admin')?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('admin_upload.js', 'admin');?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
    var ue = UE.getEditor('editor');
</script>
	</body>
</html>
