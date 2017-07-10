<?php $this->load->view('common/header2');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#"><?php echo $title[0];?></a></li>
        <li><a href="#"><?php echo $title[1];?></a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="container-fluid">
    <div class="row">
    </div>
    <div class="row">
      <a class="btn btn-primary" id="action_add">添加 <span class="glyphicon glyphicon-plus-sign"></span></a>
    </div>
    <hr/>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>编号</th>
                <th>分类名称</th>
                <th>创建时间</th>
                <th>创建人</th>
                <th>更新时间</th>
                <th>更新人</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $k => $v): ?>
            <tr>
              <td><?php echo $k+1?></td>
              <td><?php echo $v['name']?></td>
              <td><?php echo $v['create_time']?></td>
              <td><?php echo $v['create_admin_name']?></td>
              <td><?php echo $v['update_time']?></td>
              <td><?php echo $v['update_admin_name']?></td>
              <td>
                <a href="#" class="action_edit" data-value="<?php echo $v['name']?>" data-id="<?php echo $v['id']?>" >修改</a>
                <a href="/foodstype/del/<?php echo $v['id']?>" class="del">删除</a>
              </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    </div>
</div>

<?php $this->load->view('common/footer')?>
<script type="text/javascript">
seajs.use(['dialog', '<?php echo css_js_url('foodstype.js', 'admin')?>'], function(a,b){
    b.add();
    b.edit();
    b.del();
})
</script>
