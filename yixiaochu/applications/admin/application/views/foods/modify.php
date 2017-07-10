<?php $this->load->view('common/header2')?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="/foods/index"><?php echo $title[0];?></a></li>
        <li><a href="#"><?php echo $title[1];?></a></li>
    </ul>
</div>

<div class="formbody">
    <div class="formtitle">
      <span><?php echo $title[1]?></span>
    </div>
    <form method="post">
    <ul class="forminfo">
      <li>
        <label>菜名：</label>
        <input type="text" value="<?php echo $info['foods_name']?>" class="dfinput" name="foods_name" valType="required" msg="菜名不能为空！"/>
        <i><b>*</b></i>
      </li>
      <li>
        <label>封面图：</label>
        <ul id="uploader_cover_img">
          <li class='pic pro_gre' style='margin-right: 20px; clear:none;'>
              <a class='close del-pic' href='javascript:;'></a>
              <a href="<?php echo $info['cover_img_url'];?>" target="_blank"><img src="<?php echo $info['cover_img_url'];?>" style='width:100%;height:100%'/></a>
              <input type="hidden" name="cover_img" value="<?php echo $info['cover_img']?>"/>
          </li>
          <li class="pic pic-add add-pic" style="float: left;width: 220px;height: 175px;clear:none;">
            <a class="up-img" id="file_cover_img" ><span>+</span><br>添加照片</a>
          </li>
        </ul>
      </li>
      <li>
        <label>食材：</label>
        <textarea name="food_material" class="textinput"><?php echo $info['food_material']?></textarea>
      </li>
      <li>
        <label>营养价值：</label>
        <textarea name="nutritive_value" class="textinput"><?php echo $info['nutritive_value']?></textarea>
      </li>
      <li>
        <label>简介：</label>
        <textarea name="description" class="textinput"><?php echo $info['description']?></textarea>
      </li>
      <li>
        <label>原价：</label>
        <input type="text" name="old_price" class="dfinput" value="<?php echo $info['old_price']?>">
      </li>
      <li>
        <label>现价：</label>
        <input type="text" name="now_price" class="dfinput" valType="required" msg="现价不能为空" value="<?php echo $info['now_price']?>">
        <i><b>*</b></i>
      </li>
      <li>
        <label>分类：</label>
        <select name="type" class="dfinput" valType="required" msg="请选择分类">
          <?php foreach ($type as $k => $v):?>
          <?php if($v['id'] == $info['type']):?>
          <option value="<?php echo $v['id']?>" selected><?php echo $v['name']?></option>
          <?php else:?>
          <option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
          <?php endif;?>
          <?php endforeach;?>
        </select>
      </li>
      <li>
        <label>已售数量：</label>
        <input type="text" class="dfinput" name="sell_number" value="<?php echo $info['sell_number']?>" valType="NUMBER" msg="请输入数字"/>
        <i><b>*</b></i>
      </li>
      <li>
        <label>是否显示：</label>
        <label class="label-check"><input type="radio" name="is_show" value="1" <?php if($info['is_show'] == 1) echo 'checked';?>>是</label>
        <label class="label-check"><input type="radio" name="is_show" value="0" <?php if($info['is_show'] == 0) echo 'checked';?>>否</label>
      </li>
      <li>
        <label>是否今日菜品：</label>
        <label class="label-check"><input type="radio" name="is_today" value="1" <?php if($info['is_today'] == 1) echo 'checked';?>>是</label>
        <label class="label-check"><input type="radio" name="is_today" value="0" <?php if($info['is_today'] == 0) echo 'checked';?>>否</label>
      </li>
      <li>
        <input type="submit" value="保存" class="btn btn-primary"/>
      </li>
    </ul>
    </form>
</div>

<?php $this->load->view('common/footer')?>
<script>
seajs.use(['jqvalidate', 'swfupload', 'jqueryswf', 'admin_upload'], function(){})
</script>