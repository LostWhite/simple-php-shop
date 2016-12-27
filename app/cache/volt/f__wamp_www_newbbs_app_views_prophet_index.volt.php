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
            						<h3 class="p_per">预测师资料:</h3>
            						<div id="porphet_menu">
                                        <div class="per_img">
                                            <div><img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" /></div>
                                            <div class = "per_img_mes"><?= $service->user_name ?></div>
                                        </div>
                                        <div id="per_mes">
                                            <span class="span_th">用户名:</span><span class="span_td"><?= $logged_in ?></span>
                                            <span class="span_th">预测师名:</span><span class="span_td"><?= $service->user_name ?></span><br><br>
                                            <span class="span_th">邮箱:</span><span class="span_td"><?= $user->email ?></span>
                                            <span class="span_th">账户号:</span><span class="span_td"><?= $service->ps_user_id ?></span><br><br>
                                            <span class="span_th">真实姓名:</span><span class="span_td"><?= $service->real_name ?></span>
                                            <span class="span_th">性别:</span><span class="span_td"><?= $user->sex ?></span><br><br>
                                            <span class="span_th">手机:</span><span class="span_td"><?= $user->mobile_number ?></span>
                                            <span class="span_th">qq:</span><span class="span_td"><?= $user->qqno ?></span><br><br>
                                            <span class="span_th">联系地址:</span><span class="span_td"><?= $user->address5 ?></span>
                                            <span class="span_th">申请时间:</span><span class="span_td">user_name</span>
                                        </div>
            						</div>
            						<h3>预测师简介：</h3>
            						<div id="prophet_cont">
            							<br/>
            							<?= $service->user_content ?>
            						</div>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <h3>详细介绍：</h3>
            						<div id="prophet_cont">
            							<br/>
            							<?= $service->expert_content ?>
            						</div>

            					</div>
            </div>


              <?php include $hs_view_include_path.'/prophet/listleft.inc';?>

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