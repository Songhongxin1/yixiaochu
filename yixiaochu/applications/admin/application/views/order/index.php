<?php $this->load->view('common/header2')?>
<ol class="breadcrumb">
  <li><a href="#" >首页</a></li>
  <li><a href="/order/index" >订单管理</a></li>
  <li class="active">列表</li>
</ol>

<div class="container-fluid">
  <p class="text-center h2" id="refresh_text">
    19秒后刷新
  </p>
  <p class="text-center">
    <a href="/order/add" class="btn btn-primary" style="display:inline-block">手动添加订单</a>
    <button class="btn btn-primary" id="refresh_auto">手动刷新 <span class="glyphicon glyphicon-refresh"></span></button>
    <button class="btn btn-warning" id="refresh_open">开启 <span class="glyphicon glyphicon-off"></span></button>
    <button class="btn btn-default" id="refresh_close">关闭 <span class="glyphicon glyphicon-remove-sign"></span></button>
  </p>
  <hr>
  <form class="form-inline">
    <div class="form-group">
    <?php foreach ($status as $k => $v):?>
      <div class="radio"><label class="h4"><input type="radio" name="status" value="<?php echo $v['id']?>"><?php echo $v['name']?></label></div>
    <?php endforeach;?>
    </div>
    <br>
    <div class="form-group">
      <input type="text" class="form-control Wdate" name="time" placeholder="输入时间搜索" style="height:30px"/>
    </div>
    <div class="form-group">
      <button type="button" class="btn btn-primary" id="search">搜索</button>
    </div>
  </form>
  
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>编号</th>
        <th>订单编号</th>
        <th>联系人</th>
        <th>电话</th>
        <th>订单状态</th>
        <th>创建时间</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  
  <div class="pagin" id="pagestr">
    <ul class="paginList">
    
    </ul>
  </div>
</div>

<?php $this->load->view('common/footer')?>
<script>
seajs.use(['<?php echo css_js_url('order.js', 'admin')?>', 'base', 'datepicker'], function(a,b){
    a.onload();
    a.auto_refresh();
    a.search();
    a.detail();
    b.initDatePicker('yyyy-MM-dd');
})
</script>