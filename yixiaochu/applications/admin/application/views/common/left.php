<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo css_js_url('style.css', 'admin');?>" type="text/css" rel="stylesheet" />
<script src="<?php echo css_js_url('jquery.min.js','admin');?>"></script>
</head>
<body style="background:#f0f9fd;">
    <div class="lefttop"><span></span>导航菜单</div>
    
    <dl class="leftmenu">

        <!-- 其他菜单 -->
        <?php if($menu): ?>
            <?php foreach($menu as $key=>$val):?>
            <dd>
                <div class="title">
                    <span><img src="<?php echo $domain['static']['url'];?>/admin/images/leftico01.png" /></span><?php echo $key;?>
                </div>
                <ul class="menuson" style="display:none">
                    <?php if($val['list']):?>
                        <?php foreach($val['list'] as $k=>$v):?>
                            <li class="menuson-top"><cite></cite><a href="<?php echo $v[0];?>" target="rightFrame"><?php echo $v[1];?></a><i></i></li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
            </dd>
            <?php endforeach;?>
        <?php endif;?>
                    
   </dl>
   
<script type="text/javascript">
$(function(){
    //导航切换
    $(".menuson li").click(function(){
        $(".menuson li.active").removeClass("active")
        $(this).addClass("active");
    });
    
    $('.title').click(function(){
        var $ul = $(this).next('ul');
        $('dd').find('ul').slideUp();
        if($ul.is(':visible')){
            $(this).next('ul').slideUp();
        }else{
            $(this).next('ul').slideDown();
        }
    });
})
</script>
</body>
</html>