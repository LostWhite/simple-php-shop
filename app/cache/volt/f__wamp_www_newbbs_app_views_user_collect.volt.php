<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">

			<div id="top_detail">

					<div id="top_detail_inner">
						<p>被收藏的预测师</p>
						<?php foreach ($services as $service) { ?>
                            <div id="collect_pro">
                                <div class="yuce_img"><img src="<?= $site_url ?>/img/pro/<?= $service['ps_user_id'] ?>/s_<?= $service['ps_user_id'] ?>.jpg" style="height:130px;" /></div>
                                <div id="yuce_mes">
                                    <span class = "pro_0"><?= $service['user_name'] ?></span>
                                    <span class = "yuceshi"><a href="<?= $site_url ?>online/tab1/<?= $service['ps_user_id'] ?>">点此进入预测师页面</a></span><br>
                                    <span class = "pro_1">总成交量：</span><span class = "pro_2"><?= $service['sale_total'] ?></span>
                                    <span class = "pro_1">总好评率：</span><span class = "pro_2"><?= $service['eval_percent'] ?></span>
                                    <span class = "pro_1">成交指数：</span><span class = "pro_2"><?= $service['sale_point'] ?></span>
                                    <br /><br />
                                    <div id="pro_2">
                                        简介：<?= $service['user_content'] ?><a href="<?= $site_url ?>online/tab1/<?= $service['ps_user_id'] ?>">更多……</a>
                                    </div>
                                </div>
                            </div>
						<?php } ?>
						<?php if ($end != 1) { ?>
                            <?php include $hs_view_include_path.'page.inc';?>
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