	<!-- 弹出框 -->
	<?php $this->load->view('common/popup');?>
    <script src="<?php echo css_js_url('sea.js','common');?>"></script>
    <script type="text/javascript">
        seajs.config({
            base: "<?php echo $domain['static']['url'];?>",
            alias: {
              "jquery": "<?php echo css_js_url('jquery.min.js', 'common');?>",
              "base": "<?php echo css_js_url('base.js','admin');?>",
              "form": "<?php echo css_js_url('jquery.form.js','admin');?>",
              "rooms": "<?php echo css_js_url('rooms.js','admin');?>",
              "datepicker": "<?php echo $domain['static']['url'];?>/common/js/datepicker/WdatePicker.js",
              "dialog": "<?php echo css_js_url('dialog.js','common');?>",
              "tabs": "<?php echo css_js_url('jquery.idTabs.min.js', 'admin');?>",
              'jqueryswf':"<?php echo css_js_url('jquery.swfupload.js', 'common');?>",
              "swfupload" : "<?php echo css_js_url('swfupload.js', 'admin')?>",
              "admin_upload": "<?php echo css_js_url('admin_upload.js', 'admin');?>",
              "public":"<?php echo css_js_url('public.cmd.js', 'admin');?>",
              "jqvalidate":"<?php echo css_js_url('jq.validate.js', 'admin')?>"
            },
            preload: ["jquery"]
        });
    </script>
