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
        <form class="form-inline">
            <div class="form-group">
              <a class="btn btn-primary" href="/foods/add">添加 <span class="glyphicon glyphicon-plus-sign"></span></a>
              <label>菜名：</label>
              <input type="text" class="form-control" name="foods_name"/>
              <button class="btn btn-default" type="submit">搜索 <span class="glyphicon glyphicon-search"></span></button>
            </div>
            <div class="form-group">
              <a class="btn btn-primary" href="/foods/index">显示所有</a>
            </div>
        </form>
    </div>
    <hr/>
        <?php foreach($list as $k => $v):?>
        <?php if($k%5 == 0):?>
        <div class="row">
          <?php if($k != 0): $i=$k+1; else:$i = $k; endif; for ($i; $i<count($list) && $i<=$k+5; $i++):?>
          <div class="col-sm-2">
            <a href="/foods/detail/<?php echo $list[$i]['id']?>" class="detail"><img style="height: 100px" src="<?php if(!empty($list[$i]['cover_img'])): echo $list[$i]['cover_img']; else: echo $domain['static']['url'].'/admin/images/no_image.gif'; endif; ?>" class="img-responsive"/></a>
            <ul class="list-inline">
              <li><?php echo $list[$i]['foods_name']?></li>
              <li><?php echo $list[$i]['old_price']?>元|<?php echo $list[$i]['now_price']?>元</li>
              <li><?php echo $list[$i]['is_today_text']?></li>
            </ul>
            <ul class="list-inline">
              <li><a href="/foods/modify/<?php echo $list[$i]['id']?>">修改</a></li>
              <li><a href="/foods/detail/<?php echo $list[$i]['id']?>" class="detail">详情</a>
              <li><a class="del" href="/foods/set/<?php echo $list[$i]['id']?>/is_del/1">删除</a></li>
              <?php if($list[$i]['is_today']):?>
              <li><a class="today" href="/foods/set/<?php echo $list[$i]['id']?>/is_today/0">取消今日</a></li>
              <?php else:?>
              <li><a class="today" href="/foods/set/<?php echo $list[$i]['id']?>/is_today/1">设置今日</a></li>
              <?php endif;?>
            </ul>
          </div>
          <?php endfor;?>
        </div>
        <hr/>
        <?php endif;?>
        <?php endforeach;?>
        <!-- 分页 -->
        <div class="row">
          <div class="pagin">
              <div class="message">共<i class="blue"><?php echo $count;?></i>条记录，当前显示第&nbsp;<i class="blue"><?php echo $page;?>&nbsp;</i>页</div>
              <ul class="paginList">
                  <?php echo $pagestr;?>
              </ul>
          </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/footer')?>
<script>
seajs.use(['<?php echo css_js_url('foods.js', 'admin')?>'], function(a){
    a.del();
    a.today();
    a.detail();
})
</script>