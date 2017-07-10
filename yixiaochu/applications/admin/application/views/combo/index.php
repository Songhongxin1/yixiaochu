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
			<li><a href='/combo/add'><span><img
						src="<?php echo $domain['static']['url'];?>/admin/images/t01.png" /></span>添加套餐</a></li>
		</ul>
		<form>
			<ul>
				<li>套餐名称：
				<input type="text" style="width:150px;" class="dfinput" name="combo_name" value="<?php if(!empty($names)){echo $names;}?>" />
				<select style="width:150px;" class="dfinput" name="cate_id">
                    <option value="">---请选择套餐分类---</option>
                    <?php foreach ($catename as $k=>$v) :?>
                        <option <?php if(!empty($cate_id)){if($v['id'] == $cate_id){echo 'selected';}}?> value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
                    <?php endforeach;?>
                </select>
                <input name="update_time" type="text" placeholder="<?php echo date("Y-m-d"); ?>" value="<?php if(!empty($time)){echo $time;}?>" class="dfinput Wdate" style="height:32px;width:184px" />
				<input type="submit" value="搜索" class="btn" />
				</li>
			</ul>
		</form>
	</div>
	<ul class="foods-lists">
	<?php foreach ($list as $k => $v) :?>
	    <li><img src="<?php echo get_full_img_url($v['cover_img'])?>">
			<div class="detail">
				<p class="title">
					<span class="cont"><?php echo $v['combo_name']?></span><span
						class="price">￥<?php echo $v['price']?></span>
				</p>
				<p class="text">
					<?php echo $v['description']?><a href="javascript:;">详情&gt;&gt;</a>
				</p>
				<div class="slider">
					<?php if($v['foods']) :?>
						<?php foreach($v['foods'][0] as $kk => $vv): ?>	
					<div class="slide">
						<img src="<?php echo get_full_img_url($vv['cover_img']);?>"><?php echo $vv['foods_name'];?>
					</div>
					<?php endforeach;?>
					<?php endif;?>
				</div>
				<div class="bot">
					<a href="/combo/edit/<?php echo $v['id']?>" class="destine">编辑</a><span>已售 <?php echo $v['sell_number']?></span>
				</div>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
	<div class="pagin">
		<ul class="paginList">
            <?php echo $pagestr;?>
        </ul>
	</div>
</div>
<script src="<?php echo css_js_url('jquery.min.js','common');?>"></script>
<script src="<?php echo css_js_url('jquery.bxslider.js','common');?>"></script>
<script src="<?php echo css_js_url('index.js','common');?>"></script>
<script type="text/javascript" src="<?php echo $domain['static']['url'];?>/common/js/datepicker/WdatePicker.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
          $('.slider').bxSlider({
            slideWidth: 80,
            minSlides: 1,
            maxSlides: 3,
            moveSlides: 1,
            slideMargin: 10
          });
        });
        $(".Wdate").focus(function(){
            WdatePicker({dateFmt:'yyyy-MM-dd'})
        });
    </script>
</body>
</html>
