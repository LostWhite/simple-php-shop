
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
		<ol id="pan">
			<li><a href="<?= $site_url ?>">返回首页</a></li>
						<li>预测师简介</li>
		</ol>
			<div id="main_inner">
				<div id="top_detail">
					<div id="item_info">
                        <input type="hidden" name="site_url" id="site_url" value="<?= $site_url ?>">
						<div id="title">
							<h1>预测师简介和服务页面</h1>
							<h2></h2>
						</div>

						<div id="item_image">
							<p><a href="" target="_blank" rel="lightbox"><img src="<?= $site_url ?>/img/per/<?= $service->ps_user_id ?>/b.jpg" onerror="javascript:this.src='<?= $site_url ?>img/per/default_user.jpg'"></a></p>
							<!-- <a href="" target="_blank" rel="lightbox">画像を拡大</a> -->
						</div>


						<div id="prophesy_detail">
							<span class = "pro_name"><?= $service->user_name ?></span><br>
                            <span class = "pro_1">总成交量：</span><span class = "pro_2"><?= $service->sale_total ?></span>
                            <span class = "pro_1">总好评率：</span><span class = "pro_2"><?= $service->eval_percent ?></span>
                            <span class = "pro_1">成交指数：</span><span class = "pro_2"><?= $service->sale_point ?></span>
							<br />
							<br />
							<div id="pro_2">
								简介：<?= $service->user_content ?>
							</div>
							<br />
							<br />
							<span class ="pro_a1">
							    <?php if (isset($count_o)) { ?>
							        <a href="<?= $site_url ?>chat/index?room_id=<?= $service->ps_user_id ?>_<?= $user_id ?>">订单聊天</a>
							    <?php } else { ?>
							        <a href="javascript:online_chat(<?= $service->ps_user_id ?>,<?php if (isset($user_id)) { ?><?= $user_id ?><?php } else { ?>000<?php } ?>)">试测聊天</a>
							    <?php } ?>
							</span>
                            <span class ="pro_a2" ><a href="javascript:collection(<?= $service->ps_user_id ?>,<?php if (isset($user_id)) { ?><?= $user_id ?><?php } else { ?>000<?php } ?>)">收藏预测师</a></span>
						</div>
					</div>

                        <!--tab开始-->
						<input type="hidden" name="status" id="status" value="<?= $status ?>">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class=""><a href="<?= $site_url ?>online/tab1/<?= $service->ps_user_id ?>">服务项目</a><span class="tab-bn"></span></li>
                        		<li class="tab_on"><a href="<?= $site_url ?>online/tab2/<?= $service->ps_user_id ?>">详细介绍</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>online/tab3/<?= $service->ps_user_id ?>">评价记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>online/tab4/<?= $service->ps_user_id ?>">预测师随笔</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0" style="width:100%;min-height:800px">
                        <ol id="recordList">
                        <div class="a-totle1">
                            <br/><br/>
                            <?= $service->expert_content ?>

                        </div>
                        </ol>
                        </div>
                        </div>


				</div>
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
			<!--
<ul id="ranking">
<li class="rank_no1">
<p id="rank_1">第1位</p>
<a href="" title=""><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_1.png" /></a>
<h5><a href="/item/618">Air Care Diffuser （エアケア ディフューザー）</a></h5>
<em>定価：15,750円（税込）</em>
</li>

<li>
<p id="rank_2">第2位</p>
<a href="" title=""><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_1.png" /></a>
<h5><a href="/item/617">Steam Humidifier</a></h5>
<em>定価：13,230円（税込）</em>
</li>

<li>
<p id="rank_3">第3位</p>
<a href="" title=""><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_1.png" /></a>
<h5><a href="/item/614">ロボット掃除機 kobold ( コーボルト ) VR100</a></h5>
<em>定価：82,688円（税込）</em>
</li>

<li>
   第4位
<h5><a href="/item/611">SBSes7353</a></h5>
</li>

<li>
   第5位
<h5><a href="/item/613">kMix ドリップコーヒーメーカー「CMB6」</a></h5>
</li>

<li>
   第6位
<h5><a href="/item/609">LE MACCHINE DI MUNARI</a></h5>
</li>

<li>
   第7位
<h5><a href="/item/608">DE PAS D’URBINO LOMAZZI</a></h5>
</li>

<li>
   第8位
<h5><a href="/item/607">I LIBRI DI ETTORE SOTTSASS</a></h5>
</li>

<li>
   第9位
<h5><a href="/item/606">Eau</a></h5>
</li>

</ul>

			<ol id="lclm_banners">
				<li><a href="javascript:;" title="banner"><img src="../pc/assets/images/banners/1.gif" alt=""/></a></li>
			</ol>-->
		</section>
		
		
		<br clear="all">

	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>