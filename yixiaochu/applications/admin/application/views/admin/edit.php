<?php $this->load->view("common/header");?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#"><?php echo $title[0];?></a></li>
        <li><a href="#"><?php echo $title[1];?></a></li>
    </ul>
</div>

<div class="formbody">
    <div class="formtitle"><span><?php echo $title[1];?></span></div>
    <form action="" method="post">
    <ul class="forminfo">
        <li>
            <label>角色:</label>
            <select class="dfinput" name="group_id">
                <?php foreach($admin_group as $key=>$val){ ?>
                    <option <?php if($val['id']==$info['group_id']){ echo "selected";}?>  value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                <?php } ?>
            </select>
           <i> <b>*</b></i>
        </li>
         <?php if($developer){?>
         <li>
            <label>所属机构:</label>
            <select class="dfinput" name="developer_id">
                <?php foreach($developer as $key=>$val){ ?>
                <option <?php if($val['id'] == $info['developer_id']){ echo "selected";} ?> value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
                <?php } ?>
            </select>
           <i> <b>*</b></i>
        
        </li>
        <?php }?>
        <li>
            <label>登录名：</label><input name="name" value="<?php echo $info['name']?>" required type="text" class="dfinput" id="name" />
            <i id="name-msg" style="color: red">*</i>
        </li>
        <li>
            <label>密码:</label><input name="password" type="password" value="" type="text" class="dfinput" id="password" />
            <i  style="color: red">*</i>
        </li>

        <li><label>姓名:</label><input name="fullname"  value="<?php echo $info['fullname']?>" type="text" class="dfinput" id="fullname" />
            <i  style="color: red">*</i>
        </li>
        <li><label>Email:</label><input name="email" value="<?php echo $info['email']?>"  type="text" class="dfinput" id="email" /><i></i></li>
        <li><label>手机:</label><input name="tel" value="<?php echo $info['tel']?>" type="text" class="dfinput" id="tel" /><i></i></li>
        <li><label>描述:</label><input name="describe" value="<?php echo $info['describe']?>"   type="text" class="dfinput" id="describe" /><i></i></li>
        <li><label>状态:</label>
            <input type="radio" value="1" name="disabled" <?php if($info['disabled'] == 1){ echo "checked";}?> >正常 &nbsp;&nbsp;
            <input type="radio" value="2" name="disabled" <?php if($info['disabled'] == 2){ echo "checked";}?> >禁用</li>
        <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="修改"/></li>
    </ul>
    <form>
</div>
<?php $this->load->view("common/footer");?>
	</body>
</html>
