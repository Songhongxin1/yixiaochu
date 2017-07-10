<table class="table table-bordered">
  <tbody>
    <tr>
      <td>名称：</td>
      <td><?php echo $info['foods_name']?></td>
    </tr>
    <tr>
      <td>封面图：</td>
      <td><img src="<?php echo $info['cover_img_url']?>" style="width:200px; height:180px;"></td>
    </tr>
    <tr>
      <td>食材：</td>
      <td><?php echo $info['food_material']?></td>
    </tr>
    <tr>
      <td>营养价值：</td>
      <td><?php echo $info['nutritive_value']?></td>
    </tr>
    <tr>
      <td>简介：</td>
      <td><?php echo $info['description']?></td>
    </tr>
    <tr>
      <td>原价：</td>
      <td><?php echo $info['old_price']?></td>
    </tr>
    <tr>
      <td>现价：</td>
      <td><?php echo $info['now_price']?></td>
    </tr>
    <tr>
      <td>分类：</td>
      <td><?php echo $info['type_text']?></td>
    </tr>
    <tr>
      <td>已售数量</td>
      <td><?php echo $info['sell_number']?></td>
    </tr>
    <tr>
      <td>是否显示：</td>
      <td><?php echo $info['is_show'] ? '是' : '否'?></td>
    </tr>
    <tr>
      <td>是否今日菜品：</td>
      <td><?php echo $info['is_today'] ? '是' : '否'?></td>
    </tr>
  </tbody>
</table>