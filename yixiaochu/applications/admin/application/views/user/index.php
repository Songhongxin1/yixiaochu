<?php $this->load->view('common/header');?>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">会员管理</a></li>
            <li><a href="#">会员列表</a></li>
        </ul>
    </div> 
    <div class="tools">
        <form method="post">
            <ul class="placeul">
                <li>  
                                                            用户名:<input type="text" class="dfinput" placeholder="请输入要搜索的用户名" value="<?php echo @$user_name;?>" name="user_name" style="width: 220px">
                         <input type="submit" value="搜 索" class="btn">
                </li>
            </ul>
        </form>
    </div> 
    <table class="tablelist">
        <thead>
            <tr>
                <th>编号</th>
                <th>用户名</th>
                <th>性别</th>
                <th>手机号</th>
                <th>登录限制</th>
                <th>注册时间</th>
                <th>更新时间</th>
                <th>用户地址</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($log_list as $key => $val):?>
                <tr <?php if($key%2 !=0 ){ echo 'class="odd"';}?>>
                    <td><?php echo $val['id'];?></td>
                    <td><?php echo $val['user_name'];?></td>
                    <td><?php echo $val['sex'] == 1 ? '男' : '女';?></td>
                    <td><?php echo $val['user_phone'];?></td>
                    <td><?php echo $val['is_limit'] == 1 ? '<span style="color: red">禁止登录</span>' : '正常';?></td>
                    <td><?php echo $val['create_time'];?></td>
                    <td><?php echo $val['update_time'];?></td>
                    <td><?php echo $val['update_time'];?></td>
                    <td>
                        <a href="/user/info/<?php echo $val['id'];?>" class="tablelink">查看收货地址 </a>
                        <?php if($val['is_limit'] == 1):?> 
                        <a href="/user/set_login/<?php echo $val['id'];?>/0" class="tablelink">取消禁止登录</a>   
                        <?php else:?>
                        <a href="/user/set_login/<?php echo $val['id'];?>/1" class="tablelink">禁止登录</a>   
                        <?php endif;?>
                    </td>
                </tr> 
            <?php endforeach;?>
        </tbody>
    </table>
    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo $data_count;?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo $page;?>&nbsp;</i>页</div>
            <ul class="paginList">
                <?php echo $pagestr;?>
            </ul>
    </div>
</body>
</html>