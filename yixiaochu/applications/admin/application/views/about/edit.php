<?php $this->load->view('common/header');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">系统管理</a></li>
        <li><a href="/about">关于我们</a></li>
        <li><a href="#">修改</a></li>
    </ul>
</div>

<div class="formbody">
<form  method="post" id="form">
    <div class="formtitle"><span>编辑</span></div>
    <ul class="forminfo">
        <li>
            <label>视频标题</label>
            <input name="vedio_title" type="text" class="dfinput" value="<?php echo $info['vedio_title']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>视频链接地址</label>
            <input name="vedio_url" type="text" class="dfinput" value="<?php echo $info['vedio_url']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>视频预览图<b>*</b></label>
            <ul id="uploader_vedio_img">
                <?php if($info['vedio_img']):?>
                <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                    <a class='close del-pic' href='javascript:;'></a>
                    <a href="<?php echo $info['vedio_img'];?>" target="_blank"><img src="<?php echo $info['vedio_img'];?>" style='width:100%;height:100%'/></a>
                    <input type="hidden" name="vedio_img" value="<?php echo $info['vedio_img'];?>"/>
                </li>
                <?php endif;?>
                <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                    <a href="javascript:;" class="up-img"  id="file_vedio_img"><span>+</span><br>添加照片</a>
                </li>
            </ul>
        </li>
        <li>
            <label>客服电话</label>
            <input name="customer_service_tel" type="text" class="dfinput" value="<?php echo $info['customer_service_tel']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>客服邮箱</label>
            <input name="customer_service_email" type="text" class="dfinput" value="<?php echo $info['customer_service_email']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>微信公众号</label>
            <input name="wechat_public_number" type="text" class="dfinput" value="<?php echo $info['wechat_public_number']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>工作时间</label>
            <input name="working_hours" type="text" class="dfinput" value="<?php echo $info['working_hours']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>公司地址</label>
            <input id="address" name="address" type="text" class="dfinput" value="<?php echo $info['address']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>公司地理坐标</label>
            <input id="coordinate" name="coordinate" type="text" class="dfinput" value="<?php echo $info['coordinate']?>" valType="required" msg="不能为空"/><i></i>
            <i>填写公司地址即可自动获取坐标，如果获取不到，请点击<a href="http://api.map.baidu.com/lbsapi/getpoint/index.html" target="_blank"style="color:blue;">这里</a>手动拾取坐标</i>
        </li>
        <li>
            <label>简介</label>
            <script id="editor" type="text/plain" style="float:left;width: 620px;" name="desc"><?php echo $info["desc"]; ?></script>
            <div class="edit-img">
                <ul id="uploader_rich_text_img" >
                </ul>
                <div class="pic pic-add add-pic" >
                    <a href="javascript:;" class="up-img"  id="file_rich_text_img" style="background: #238ccd;border: solid 1px #238ccd;width:225px;height:40px;border-radius:5px;">添加照片</a>
                </div>
            </div>
        </li>
        <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
</div>
<script src="<?php echo css_js_url('jquery.min.js','admin');?>"></script>
<script src="<?php echo css_js_url('jq.validate.js','admin');?>"></script>
<script src="<?php echo css_js_url('jquery.form.js','admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('jquery.swfupload.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('swfupload.js', 'admin')?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('admin_upload.js', 'admin');?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<script src="<?php echo css_js_url('common.js','admin');?>"></script>
<script type="text/javascript">
    $(function(){
        $("#address").blur(function(){
            var address = $("input[name='address']").val();
            if(address){
                $.post("/about/get_Map",{map:address}, function(data) {
                    if(data){
                       $("#coordinate").val(data.lng+','+data.lat);
                    }
                });
           }

        });
    });
    
    var ue = UE.getEditor('editor');
</script>
</body>
</html>