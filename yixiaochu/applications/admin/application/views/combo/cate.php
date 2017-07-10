<?php $this->load->view('common/header');?>
<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#"><?php echo $title[0];?></a></li>
    </ul>
</div>

<div class="rightinfo">
    <div class="tools">
        <ul class="toolbar">
            <li><a href='/combo/cateadd'><span><img src="<?php echo $domain['static']['url'];?>/admin/images/t01.png" /></span>添加</a></li>
        </ul>
    </div>
    <div class="tools">
        <form>
            <ul>
                <li>
                    套餐名：<input type="text" class="dfinput" name="name" value="<?php if(!empty($names)){echo $names;}?>" />
                    <input type="submit" value="搜索" class="btn" />
                </li>
            </ul>
        </form>
    </div>
    
    <table class="tablelist">
        <thead>
            <tr>
                <th>编号</th>
                <th>套餐分类</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $k => $v):?>
            <tr>
                <td><?php echo $v['id']?></td>
                <td><?php echo $v['name'] ?></td>
                <td><?php echo $v['sort'] ?></td>
                <td><a href="/combo/cateedit/<?php echo $v['id'] ?>">编辑</a>&nbsp;&nbsp;<a href="/combo/del/<?php echo $v['id'] ?>">删除</a></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>