<?php $this->load->view('common/header');?>

<div class="place">
    <span>位置：</span>
    <ul class="placeul">
        <li><a href="#">首页</a></li>
        <li><a href="#">会员管理</a></li>
        <li><a href="#">会员详情</a></li>
    </ul>
</div>    

<div class="formbody">
    <div id="print_area" >
        <table class="detail-info">
            <tr>
                <td colspan="6" class="info-title">收货地址</td>
            </tr>
            <?php foreach ($details as $val){?>
            <tr>
                <td class="info-item" >地址：<?php echo $val['bus_area'].' '.$val['area'].' '.$val['addr_name']?></td>
                <td class="info-item"> 电话：<?php echo $val['addr_phone']?></td>
                <td class="info-item"> 创建时间：<?php echo $val['create_time']?></td>
                <td class="info-item"> 修改时间：<?php echo $val['update_time']?></td>
                <td class="info-item"> 是否默认收货地址：<?php if($val['is_default']==0){echo "否";}else{echo "默认";} ?></td>
                <td class="info-item"> 是否删除：<?php if($val['is_del']==0){echo "否";}else{echo "已删除";} ?></td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>

</body>
</html>

