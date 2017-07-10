<?php $this->load->view("common/header");?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="/common">首页</a></li>
        <li><a href="/userfeedback">用户吐槽</a></li>
    </ul>
</div>
<form method="post">
    <select class="dfinput selects news-class" name="type">
        <option value="wetrf3">---请选择吐槽分类---</option>
        <option data-level="1" <?php if(isset($type) && $type==0){echo "selected";}?> value="0">--菜品吐槽--</option>    
        <option data-level="1" <?php if(isset($type) && $type==1){echo "selected";}?> value="1">--菜谱吐槽--</option>
        <option data-level="1" <?php if(isset($type) && $type==2){echo "selected";}?> value="2">--文章吐槽--</option>
    </select>
    <input type="submit" value="搜 索" class="btn">
</form>
<div class="rightinfo">
    
    <table class="tablelist">
        <thead>
        <tr>
    		<th>编号</th>
    		<th>吐槽人</th>
    		<th>吐槽对象</th>
    		<th>用户评分</th>
    		<th>吐槽内容</th>
    		<th>吐槽时间</th>
    		<th>后台回复时间</th>
    		<th>后台回复内容</th>
    		<th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
        <?php foreach ($list as $k=>$v):?>
        <tr <?php if($k%2 !=0 ){ echo 'class="odd"';}?>>
            <td><?php echo $v['id']?></td>
            <td></td>
            <td><?php echo $v['type']?></td>
            <td><?php echo $v['point']?></td>
            <td><?php echo $v['content']?></td>
            <td><?php echo $v['create_time']?></td>
            <td><?php echo $v['reply_time']?></td>
            <td><?php echo $v['reply_content']?></td>
            <td><a href="/Comment/reply/<?php echo $v['id']?>" class="tablelink">回复</a>
                <a href="/Comment/show/?id=<?php echo $v['id']?>&status=<?php echo $v['is_show']?>" class="tablelink"><?php if($v['is_show']==0){?>点击前台展示<?php }else{?>点击不展示<?php }?></a> 
            </td>
        </tr> 
      <?php endforeach;?>
    <?php endif;?>  
        
        </tbody>
    </table>
    
    <div class="pagin">
        <div class="message">共<i class="blue"><?php echo $data_count;?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo $page;?>&nbsp;</i>页</div>
        <ul class="paginList">
            <?php echo $pagestr;?>
        </ul>
    </div>
</div>
<?php $this->load->view("common/footer");?>
<script>
    seajs.use("<?php echo css_js_url('selectbox.js', 'admin');?>", function (select) {
    	selectbox('.selects');
    });
</script>
	</body>
</html>