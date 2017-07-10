<?php $this->load->view('common/header');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#"><?php echo $title[0];?></a></li>
        <li><a href="#"><?php echo $title[1];?></a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li onclick="javascript:window.location.href='/admin/add';"><span><img src="<?php echo $domain['static']['url'];?>/admin/images/t01.png" /></span>添加</li>
        </ul>
    </div>

    <div class="tools">
        <form method="get">
            <ul class="placeul">
                <li>
                    登录名：<input type="text" class="dfinput" name="name" value="<?php echo $name; ?>" style="width: 220px">
                    姓名：<input type="text" class="dfinput" name="fullname" value="<?php echo $fullname; ?>" style="width: 220px">
                    <input type="submit" value="搜 索" class="btn">
                </li>
            </ul>
        </form>
    </div>

    <table class="tablelist">
        <thead>
        <tr>
            <th>编号</th>
            <th>登陆名</th>
            <th>姓名</th>
            <th>Email</th>
            <th>角色</th>
            <th>机构</th>
            <th>创建者</th>
            <th>创建时间</th>
            <th>操作</th>
         </thead>
        <tbody>
        <?php
            if($admin_list){
                foreach($admin_list as $key=>$val){
        ?>
        <tr <?php if($key%2 !=0 ){ echo 'class="odd"';}?>>

            <td><?php echo $val['id'];?></td>
            <td><?php echo $val['name'];?></td>
            <td><?php echo $val['fullname'];?></td>
            <td><?php echo $val['email'];?></td>
            <td><?php echo @$groups[$val['group_id']];?></td>
               <td><?php echo @$organize[$val['type']];?></td>
            <td><?php echo @$admins[$val['create_admin']];?></td>
         
           <td><?php echo $val['create_time'];?></td>
            <td>
                <a href="/admin/edit/<?php echo $val['id'];?>">修改</a>
                <?php
                    if($val['id'] != 1){
                ?>
                <a href="/admin/del/<?php echo $val['id'];?>" title="删除">删除</a>
                <a href="/admin/purview/<?php echo $val['id'];?>">分配权限</a>
                <a href="/admin/read/<?php echo $val['id'];?>">查看</a>
                <a href="/admin/enable_disable?id=<?php echo $val['id'];if($val['disabled'] == 1){ echo "&disabled=2";}else{echo "&disabled=1";}?>">
                    <?php if($val['disabled'] == 1){ echo "禁用";}else{echo "启用";}?>
                </a>
                <?php }?>
            </td>

        </tr>
        <?php } } ?>
        </tbody>
    </table>

    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo $data_count;?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo $page;?>&nbsp;</i>页</div>
        <ul class="paginList">
            <?php echo $pagestr;?>
        </ul>
    </div>
</div>
	</body>
</html>
