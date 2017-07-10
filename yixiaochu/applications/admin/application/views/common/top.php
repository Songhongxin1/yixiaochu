<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?php echo css_js_url('style.css', 'admin');?>" type="text/css" rel="stylesheet" />
<link href="<?php echo css_js_url('admin.css', 'admin');?>" type="text/css" rel="stylesheet"/>
<script src="<?php echo css_js_url('jquery.min.js','admin');?>"></script>
<script type="text/javascript">
$(function(){
    //顶部导航切换
    $(".nav li a").click(function(){
        $(".nav li a.selected").removeClass("selected")
        $(this).addClass("selected");
    })
})
</script>


</head>

<body class="top-body">
    <div class="topleft">
        <a href="/home" target="_parent"><img src="<?php echo $domain['static']['url'];?>/admin/images/logo.png" title="系统首页" /></a>
    </div>
            
    <div class="topright">
        <ul>
            <li><a href="/admin/set_admin" target="rightFrame">个人设置</a></li>
            <li><a href="/login/out" target="_parent">退出</a></li>
        </ul>
        <div class="user">
            <span>当前用户：<?php echo $userInfo['name'];?></span>
        </div>
    </div>
</body>
</html>
