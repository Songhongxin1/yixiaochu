<?php $this->load->view('common/header');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="/news">资讯管理</a></li>
        <li><a href="/news/add">发布资讯</a></li>
    </ul>
</div>  

<div class="formbody">
    <div class="formtitle"><span>发布资讯</span></div>
    <form action="" method="post">
        <ul class="forminfo">
            <li><label>资讯标题<b>*</b></label><input type="text" name="title" class="dfinput" required valType="required" msg="不能为空" /><i></i></li>
            <li><label>发布机构<b>*</b></label><input type="text" name="agency" class="dfinput" required valType="required" msg="不能为空"/><i></i></li>
            <li><label>视频链接<b></b></label><input type="text" name="video_url" class="dfinput"/></li>
            <li>
                <label>封面图<b>*</b></label>
                <ul id="uploader_cover_img">
                    <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                        <a href="javascript:;" class="up-img"  id="file_cover_img"><span>+</span><br>添加照片</a>
                    </li>
                </ul>
            </li>
            <li><label>排序<b>*</b></label><input type="text" name="sort" class="dfinput" required valType="required" msg="不能为空"/><i></i></li>
            <li>
                <label>资讯分类<b>*</b></label>
                <select class="dfinput selects" name="news_class_id" required msg="请选择资讯分类">
                    <option value="">---请选择资讯分类---</option>
                    <?php foreach ($news_class as $key => $val): ?>
                    <option value="<?php echo $val['id'];?>"><?php echo str_repeat('——', $val['level']).$val['name'];?></option>
                    <?php endforeach;?>
                </select>
            </li>
            <li><label>资讯摘要</label><textarea name="summary" class="textinput"></textarea><i></i></li>
            <li>
                <label>资讯内容</label>
                <script id="editor" type="text/plain" style="float:left;width: 620px;" name="content"></script>
                <div class="edit-img">
                    <ul id="uploader_rich_text_img" >
                    </ul>
                    <div class="pic pic-add add-pic" >
                        <a href="javascript:;" class="up-img"  id="file_rich_text_img" style="background: #238ccd;border: solid 1px #238ccd;width:225px;height:40px;border-radius:5px;">添加照片</a>
                    </div>
                </div>
            </li>
            <li>
                <label>官网首页推荐</label>
                <cite>
                    <input name="is_head_recommend" type="radio" value="1" />推荐
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="is_head_recommend" type="radio" value="0" checked="checked" />不推荐
                </cite>
            </li>
            <li>
                <label>资讯首页推荐</label>
                <cite>
                    <input name="is_news_recommend" type="radio" value="1" />推荐
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="is_news_recommend" type="radio" value="0" checked="checked" />不推荐
                </cite>
            </li>
            <li>
                <label>banner推荐</label>
                <cite>
                    <input name="is_banner_recommend" type="radio" value="1" />推荐
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="is_banner_recommend" type="radio" value="0" checked="checked" />不推荐
                </cite>
            </li>
            <li>
                <label>是否热门</label>
                <cite>
                    <input name="is_hot" type="radio" value="1" />是
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="is_hot" type="radio" value="0" checked="checked" />否
                </cite>
            </li>
            <li><label>发布时间</label><input name="publish_time" type="text" value="<?php echo date('Y-m-d H:i:s');?>" class="dfinput Wdate" style="height:32px;width:184px" required/><i></i></li>
            <li><label>SEO标题</label><input name="SEO_title" type="text" class="dfinput" /><i></i></li>
            <li><label>SEO关键字</label><input name="SEO_keywords" type="text" class="dfinput" /><i></i></li>
            <li><label>SEO关键字描述</label><textarea name="SEO_description" class="textinput"></textarea><i></i></li>
            <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="保 存"/></li>
        </ul>
    </form>
</div>

<script type="text/javascript" src="<?php echo css_js_url('jquery.min.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('datepicker/WdatePicker.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('jquery.swfupload.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('swfupload.js', 'admin')?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('admin_upload.js', 'admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('common.js', 'admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('jq.validate.js', 'admin');?>"></script>

<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/ueditor.all.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo $domain['admin']['url'];?>/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo css_js_url('selectbox.js','admin');?>"></script>
<script type="text/javascript">
	var ue = UE.getEditor('editor');
	$(function(){
        $(".Wdate").focus(function(){
            WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})
        });
    });
	 selectbox('.selects');
</script>
 
</body>
</html>