<?php $this->load->view('common/header');?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">文章管理</a></li>
        <li><a href="#">评论列表</a></li>
    </ul>
</div>    

<div class="rightinfo">

    <table class="tablelist">
        <thead>
            <tr>
                <th><input name="check_all" class="check-all" type="checkbox"></th>
                <th>编号</th>
                <th>评论文章</th>
                <th>评论内容</th>
                <th>是否删除</th>
                <th>发布时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lists as $key => $val):?>
            <tr <?php if($key%2 !=0 ){ echo 'class="odd"';}?>>
                <td><input name="checkbox" type="checkbox" value="<?php echo $val['id'];?>"></td>
                <td><?php echo $val['id'];?></td>
                <td><?php echo $article_lists[$val['news_id']];?></td>
                <td><?php echo $val['comment'];?></td>
                <td><?php echo $val['is_del'] == 1 ? '<span style="color:red">已删除</span>' : '未删除';?></td>
                <td><?php echo $val['created_time'];?></td>
                <td>
                    <?php if($val['is_del'] == 1): ?>  
                    <a href="/news/com_del/<?php echo $val['id'];?>/0" class="tablelink"> 取消删除</a>
                    <?php else:?>
                    <a href="/news/com_del/<?php echo $val['id'];?>/1" class="tablelink"> 删除</a>
                    <?php endif; ?>
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
</div>
<?php $this->load->view('common/footer');?>
<script type="text/javascript">
    seajs.use("<?php echo css_js_url('news.js', 'admin');?>", function(a){
        a.batchPublish();
        a.checkAll('input[name="checkbox"]');
        a.selectChange();
    });
</script>
<script>
    seajs.use("<?php echo css_js_url('selectbox.js', 'admin');?>", function (select) {
    	selectbox('.selects');
    });
</script>
	</body>
</html>