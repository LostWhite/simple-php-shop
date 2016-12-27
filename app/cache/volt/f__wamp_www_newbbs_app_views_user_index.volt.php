
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>public/css/usbbb.css">
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">
			<div id="top_detail">
					<div id="top_detail_inner">
						<h3 class="p_per">个人资料:</h3>
						<div id="main_image">
							<div class="per_img">
							    <a href="<?= $site_url ?>user/icon"><div><img src="<?= $site_url ?>/img/per/<?= $user_id ?>/m.jpg" onerror="javascript:this.src='<?= $site_url ?>/img/per/default_user.jpg';" style="height:130px;" /></div></a>
							    <div class = "per_img_mes">
							        <a href="<?= $site_url ?>user/increase">修改资料</a>
							        <!--input type="button" value="修改资料" class="btn btn-primary" id="btn_sub"-->
							    </div>
							</div>
							<div id="per_mes"  >
								
								<table>

								<tr>
								<th class=""><div>用户名:</div></th>
								<td class=""><?= $user_message->login_id ?></td>
								<th class=""><div>邮箱:</div></th>
								<td class=""><?= $user_message->email ?></td>
								</tr>
								
						
								
								
								<tr>
								<th class=""><div>账户余额:</div></th>
								<td class="">11111</td>
								<th class=""><div>姓名:</div></th>
								<td class=""><?= $user_message->user_name ?></td>
								</tr>
								<tr>
								<th class="thdisp">性别:</th>
								<td class=""><?= $user_message->sex ?></td>
								<th class="thdisp">出生年月:</th>
								<td class=""><?= $user_message->birth ?></td>
								</tr>
								<tr>
								<th class="thdisp">手机:</th>
								<td class=""><?= $user_message->mobile_number ?></td>
								<th class="thdisp">电话:</th>
								<td class=""><?= $user_message->tel_number ?></td>
								</tr>
								
								<tr>
								<th class="thdisp">交易次数:</th>
								<td class="">11111</td>
								<th class="thdisp">联系地址:</th>
								<td class=""><?= $user_message->address5 ?></td>
								</tr>
							
							

								</table>
						
							</div>
						</div>
						<h3>预测师记录：</h3>
						<div id="per_pro">
						    <?php foreach ($services as $service) { ?>
                                <div class="per_img">
                                    <div class="per_img_true">
                                        <img src="<?= $site_url ?>/img/per/<?= $service['pay_to_user_id'] ?>/m.jpg" style="height:100px;width:100px;"  onerror="javascript:this.src='<?= $site_url ?>img/per/default_user.jpg'" />
                                        <h2><?= $service['user_name'] ?></h2>
                                        <em><a style="color: red" href="<?= $site_url ?>online/tab1/<?= $service['pay_to_user_id'] ?>">查看详细</a></em>
                                    </div>
                                </div>
							<?php } ?>
						</div>
						<h3>预测师推荐：</h3>
						<ul id="newRelease">
                            <?php foreach ($prophets as $prophet) { ?>
                                <div class="per_img">
                                    <div class="per_img_true">
                                        <img src="<?= $site_url ?>/img/per/<?= $prophet['ps_user_id'] ?>/m.jpg" style="height:100px;width:100px;"  onerror="javascript:this.src='<?= $site_url ?>img/per/default_user.jpg'"/>
                                        <h2><?= $prophet['user_name'] ?></h2>
                                        <em><a style="color: red" href="<?= $site_url ?>online/tab1/<?= $prophet['ps_user_id'] ?>">查看详细</a></em>
                                    </div>
                                </div>
							<?php } ?>
					</div>
</div>


              <?php include $hs_view_include_path.'listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			
			<h4>Menu1</h4>
			<ul id="info">
				<li><a href="<?= $site_url ?>user">个 人 中 心<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
                    <li><a href="<?= $site_url ?>prophet/index">预 测 师 管 理<span></span></a></li>
                     <li><a href="<?= $site_url ?>chat/index">交 谈 管 理 <span></span></a></li>
                <?php }else{?>
                    <li><a href="<?= $site_url ?>user/apply">申 请 预 测 师<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>reward/search">赏 金 求 测 大 厅<span></span></a></li>
				<li><a href="<?= $site_url ?>money/recharge/1">购 买 算 卦 币<span></span></a></li>
                <li><a href="<?= $site_url ?>reward/public">发 布 赏 金 求 测<span></span></a></li>
                <li><a href="">百 家 争 鸣<span></span></a></li>
                <li><a href="<?= $site_url ?>order/orders">我 的 订 单<span></span></a></li>
                <!--li><a href="<?= $site_url ?>chat/teacher">试 测 验 证<span></span></a></li-->
				<li><a href="<?= $site_url ?>prophet/browse">预 测 师 随 笔<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
				    <li><a href="<?= $site_url ?>article/particle">写 随 笔<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>message/information?status=1">意 见 反 馈<span></span></a></li>
			</ul>

	<!-- JiaThis Button BEGIN -->
<div class="jiathis_style_24x24">
	
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_weixin"></a>
	
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>