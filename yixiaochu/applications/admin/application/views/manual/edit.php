<?php $this->load->view('common/header');?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/common">首页</a></li>
        <li><a href="/manual">手工位内容</a></li>
        <li><a href="javascript:;">修改</a></li>
    </ul>
</div>

<div class="formbody">
<form  method="post" id="form">
    <div class="formtitle"><span>手工内容</span></div>
    <ul class="forminfo">
        <li>
            <label>手工位置<b>*</b></label>
            <select class="dfinput selects" name="manual_class_id">
            <?php foreach ($manual_class as $k=>$v) :?>
                <option value="<?php echo $v['id']?>" <?php if($v['id']==$manual_class_id):?>selected="true"<?php endif;?>><?php echo $v['name']?></option>
            <?php endforeach;?>
            </select>
        </li>
        <li>
            <label>标题</label>
            <input name="title" type="text" class="dfinput" value="<?php echo $manual_info['title']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>链接地址</label>
            <input name="url" type="text" class="dfinput" value="<?php echo $manual_info['url']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>导读图片<b>*</b></label>
            <ul id="uploader_img_url">
                <?php if($manual_info['img_url']):?>
                <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                    <a class='close del-pic' href='javascript:;'></a>
                    <a href="<?php echo $manual_info['img_url'];?>" target="_blank"><img src="<?php echo get_full_img_url($manual_info['img_url']);?>" style='width:100%;height:100%'/></a>
                    <input type="hidden" name="img_url" value="<?php echo $manual_info['img_url'];?>"/>
                </li>
                <?php endif;?>
                <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                    <a href="javascript:;" class="up-img"  id="file_img_url"><span>+</span><br>添加照片</a>
                </li>
            </ul>
        </li>
        <li>
            <label>导读描述图片<b>*</b></label>
            <ul id="uploader_img_url1">
                <?php if($manual_info['img_url1']):?>
                <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                    <a class='close del-pic' href='javascript:;'></a>
                    <a href="<?php echo $manual_info['img_url1'];?>" target="_blank"><img src="<?php echo get_full_img_url($manual_info['img_url1']);?>" style='width:100%;height:100%'/></a>
                    <input type="hidden" name="img_url1" value="<?php echo $manual_info['img_url1'];?>"/>
                </li>
                <?php endif;?>
                <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                    <a href="javascript:;" class="up-img"  id="file_img_url1"><span>+</span><br>添加照片</a>
                </li>
            </ul>
        </li>
        <li>
            <label>导读背景图<b>*</b></label>
            <ul id="uploader_img_url2">
                <?php if($manual_info['img_url2']):?>
                <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
                    <a class='close del-pic' href='javascript:;'></a>
                    <a href="<?php echo $manual_info['img_url2'];?>" target="_blank"><img src="<?php echo get_full_img_url($manual_info['img_url2']);?>" style='width:100%;height:100%'/></a>
                    <input type="hidden" name="img_url2" value="<?php echo $manual_info['img_url2'];?>"/>
                </li>
                <?php endif;?>
                <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                    <a href="javascript:;" class="up-img"  id="file_img_url2"><span>+</span><br>添加照片</a>
                </li>
            </ul>
        </li>
        <li>
            <label>排序</label>
            <input name="sort" type="text" class="dfinput" value="<?php echo $manual_info['sort']?>" valType="required" msg="不能为空"/><i></i>
        </li>
        <li>
            <label>简介</label>
            <script id="editor" type="text/plain" style="float:left;width: 620px;" name="summary"><?php echo $manual_info['summary']?></script>
        </li>
        <li><label>&nbsp;</label><input id="btn" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
</div>

<script type="text/javascript" src="<?php echo css_js_url('jquery.min.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('jquery.swfupload.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('swfupload.js', 'admin')?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('admin_upload.js', 'admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('common.js', 'admin');?>"></script>
<script src="<?php echo css_js_url('jq.validate.js','admin');?>"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="<?php echo css_js_url('selectbox.js', 'admin');?>"></script>


<script type="text/javascript">
	var ue = UE.getEditor('editor', {
		maximumWords:255      //允许的最大字符数

	});
    	selectbox('.selects');
</script>
	</body>
</html>
