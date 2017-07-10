<!-- 带bootstrap的header -->
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8" >
	    <title>易小厨后台管理系统</title>
	    <link href="<?php echo css_js_url('style.css', 'admin');?>" type="text/css" rel="stylesheet" />
	    <link href="<?php echo css_js_url('admin.css', 'admin');?>" type="text/css" rel="stylesheet" />
	    <link href="<?php echo css_js_url('ui-dialog.css', 'common');?>" type="text/css" rel="stylesheet"/>
	    <link href="<?php echo css_js_url('bootstrap.min.css', 'admin')?>" type="text/css" rel="stylesheet"/>
	    <script type="text/javascript">
	    	var baseUrl = "<?php echo $domain['admin']['url'];?>";
	        var staticUrl = "<?php echo $domain['static']['url']?>";
	        var uploadUrl = "<?php echo $domain['admin']['url']?>";
	    </script>
	</head>
	<body>