<?php $this->load->view('common/header');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/">首页</a></li>
        <li><a href="/combo"><?php echo $title['0']?></a></li>
        <li><a href="#"><?php echo $title['1']?></a></li>
    </ul>
</div>

<div class="formbody">
<form  method="post" id="form">
    <div class="formtitle"><span>套餐内容</span></div>
    <ul class="forminfo">
        <li>
            <label>套餐分类<b>*</b></label>
            <select class="dfinput" name="combo_cate_id">
            <option value="">---请选择套餐分类---</option>
             <?php foreach ($combo as $k=>$v) :?>
                        <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
             <?php endforeach;?>
            </select>
        </li>
        <li><label>套餐标题</label><input name="combo_name" type="text" class="dfinput" /><i></i></li>
        <li><label>简介</label><input name="description" type="text" class="dfinput" /><i></i></li>
         <li><label>价格</label><input name="price" type="text" class="dfinput" /><i></i></li>
          <li><label>优惠</label><input name="favorable" type="text" class="dfinput" /><i></i></li>
        <li>
            <label>套餐封面<b>*</b></label>
            <ul id="uploader_img_url">
                <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
                    <a href="javascript:;" class="up-img"  id="file_img_url"><span>+</span><br>添加照片</a>
                </li>
            </ul>
        </li>
        <li>
            <label>排序</label>
            <input name="sort" type="text" class="dfinput"/><i></i>
        </li>
        <li>
            <label>套餐菜谱ID</label>
            <input id="relevance_id" name="relevance_id" type="text" class="dfinput"/> <input type="button" onclick="add()" class="btn" value="设置菜谱" />         
        </li>
        <li>
            <label>菜谱名称：</label>
            <span id="foodsname"></span>
        </li>
        <li>
            <label>是否今日&nbsp;&nbsp;
            <input name="is_today" checked type="radio"  value="1"/>是
            </label>
            <label>
            <input name="is_today" type="radio" value="0"/>否
            </label>
        </li>
        <li>
            <label>是否显示&nbsp;&nbsp;
            <input name="is_show" checked type="radio"  value="1"/>是
            </label>
            <label>
            <input name="is_show" type="radio" value="0"/>否
            </label>
        </li>
        <li><label>&nbsp;</label><input name="" type="submit" class="btn btn-primary" value="确认保存"/></li>
    </ul>
    </form>
</div>
<script type="text/javascript" src="<?php echo css_js_url('jquery.min.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('jquery.swfupload.js', 'common');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('swfupload.js', 'admin')?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('admin_upload.js', 'admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('common.js', 'admin');?>"></script>
<script src="<?php echo css_js_url('jq.validate.js','admin');?>"></script>
<script type="text/javascript" src="<?php echo css_js_url('dialog.js', 'common');?>"></script>
<script type="text/javascript">
    <?php 
        $html ='<ul>';
        foreach ($foods as $k => $v){
            $html .= "<li onclick=check(".$v['id'].",'".$v['foods_name']."'".") style='text-align:center;width:100px;height:100px;float:left;margin-left:5px;margin-bottom:25px;'><img value='0' id='f_".$v['id']."' style='width:100px;height:100px;' src='".get_full_img_url($v['cover_img'])."'/> </br>".$v['foods_name']."</br></li>";
        }
        $html .='</ul>'
    ?>
    var html = "<?php echo $html;?>";
    function add(){
    	var d = dialog({
    	    title: '菜谱列表',
    	    width: 425,
    	    content: html,
    	    ok:true
    	});
        d.show();
    }

    function  check(id,name){
    	if($('#f_'+id).attr('value')==1){
        	//取消被选中
    		$('#f_'+id).attr('style','width:100px;height:100px;');
    		$('#f_'+id).attr('value',0);
    		//将套餐菜谱id从输入框内删除
    		var ids = $('#relevance_id').attr('value');
    		var strs = $('#foodsname').html();
    		//如果只有一个id，则直接设置为空
    		if(ids.indexOf(',')==-1){
    			$('#relevance_id').attr('value','');
    			$('#foodsname').html('');
        	}else{
            	//包含多个id，将字符串转换成数组，删除指定元素
            	var arr = ids.split(',');
            	id = ''+id;
        		arr.splice($.inArray(id,arr),1);
            	$('#relevance_id').attr('value',arr.join(','));

            	//中文同步删除
            	var str = strs.split(',');
            	console.log(str);
            	str.splice($.inArray(name,arr),1);
            	$('#foodsname').html(str.join(','));
            }
        }else{
            //将图片框样式设置成被选中状态
        	$('#f_'+id).attr('style','width:100px;height:100px;border:2px solid #357ebd');
        	$('#f_'+id).attr('value',1);
        	//将id添加到关联套餐ID的输入框里
        	var ids = $('#relevance_id').attr('value');
        	if(!ids){
        		$('#relevance_id').attr('value',id);
        		$('#foodsname').html(name);
            }else{
            	$('#relevance_id').attr('value',ids+','+id);
            	var str= $('#foodsname').html();
            	$('#foodsname').html(str+','+name);
            }	
        }
    }
</script>

</body>
</html>