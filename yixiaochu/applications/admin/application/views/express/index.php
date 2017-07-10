<?php $this->load->view('common/header2')?>
<ol class="breadcrumb">
  <li><a href="#">首页</a></li>
  <li><a href="/express/index"><?php echo $title[0]?></a></li>
  <li class="active"><?php echo $title[1]?></li>
</ol>

<div class="container-fluid">
  <div class="row">
    <form class="form-inline">
      <a href="/express/add" class="btn btn-primary">添加<span class="glyphicon glyphicon-plus-sign"></span></a>
    </form>
  </div>
  <hr/>
  
  <div class="row">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>编号</th>
          <th>头像</th>
          <th>用户名</th>
          <th>姓名</th>
          <th>手机号</th>
          <th>地址</th>
          <th>是否禁止登陆</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($list as $k => $v):?>
        <tr>
          <td><?php echo $k?></td>
          <td><img src="<?php echo $v['head_img']?>" style="width:50px; height:50px"></td>
          <td><?php echo $v['name']?></td>
          <td><?php echo $v['username']?>
          <td><?php echo $v['mobile']?></td>
          <td><?php echo $v['address']?></td>
          <td><?php echo $v['is_limit_text']?></td>
          <td>
            <a href="/express/modify/<?php echo $v['id']?>">修改</a>
            <a class="del" href="/express/set/<?php echo $v['id']?>/is_del/1">删除</a>
            <?php if($v['is_limit']):?>
            <a class="limit" href="/express/set/<?php echo $v['id']?>/is_limit/0">取消禁止</a>
            <?php else:?>
            <a class="limit" href="/express/set/<?php echo $v['id']?>/is_limit/1">禁止登陆</a>
            <?php endif;?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>

<?php $this->load->view('common/footer')?>
<script>
seajs.use(['<?php echo css_js_url('express.js', 'admin')?>'], function(a){
    a.del();
    a.limit();
})
</script>