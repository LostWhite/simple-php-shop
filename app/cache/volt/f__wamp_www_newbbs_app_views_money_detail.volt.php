<?= $this->getContent() ?>

<?php
$domain="";
$url = BASE_DIR."/public/";
$site_url = "http://localhost/newbbs/";

//$site_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/";
$hs_view_include_path =APP_DIR. "/views/include/";
?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>public/css/new.css">
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>public/css/usbb.css">

<script type="text/javascript">
$(function(){
    var status = document.getElementById('status').value;
    status--;
    $("#menu_li li").removeClass("tab_on");
    $("#menu_li li:eq("+status+")").addClass("tab_on");
});
</script>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner"><?php if ((empty($logged_in))) { ?>
                       <script>window.location.href="/bbs_new/session/login"</script>
            <?php } ?>
			<div id="top_detail">
					<div id="top_detail_inner">
						<h3 class="p_per">总览：</h3>
						<div id="main_property">
							<div class="per_img"><img src="<?= $site_url ?>/img/test01_0.jpg" style="height:130px;" /></div>
							<div id="property_mess">
								<table class="property_mes">
								<tr>
								<th>用户名</th>
								<td><?= $logged_in ?></td>
								</tr>

								<tr>
								<th>账户余额</th>
								<td><?= $property->coin ?></td>
								</tr>

                                <tr>
								<th>冻结金额</th>
								<td><?= $property->freeze_coin ?></td>
								<th>可用金额</th>
                                <td><?= $property->remain_coin ?></td>
								</tr>

								<tr>
								<th>最近一次交易时间</th>
								<td><?= $property->t_property_dt ?></td>
								<th>消费金额</th>
								<td>
								    <?php if (isset($money->ps_price)) { ?>
								        <?= $money->ps_price ?>
								    <?php } ?>
								</td>

								</tr>
								</table>
							</div>
						</div>

						<!--tab开始-->
						<input type="hidden" name="status" id="status" value="<?= $status ?>">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="<?= $site_url ?>money/detail/1">所有</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/detail/2">充值记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/detail/3">提现记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/detail/4">收入记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/detail/5">支出记录</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="a-totle1">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <?php if ($count == 0) { ?>
                                <tr><td style="border-bottom:none; background:#fff">目前没有订单记录</td></tr>
                            <?php } else { ?>
                                <tr>
								<th><strong>交易时间</strong></th>
                                <th><strong>交易方式</strong></th>
                                <th><strong>收支</strong></th>
                                <th><strong>余额</strong></th>
                                <th><strong>注记</strong></th>
                                </tr>
                                    <?php foreach ($orders as $order) { ?>
                                        <tr>
                                        <td><?= $order->property_dt ?></td>
                                        <td><?= $order->type_memo ?></td>
                                        <td><?= $order->money ?></td>
                                        <td><?= $order->account ?></td>
                                        <td>
                                            <?= $order->order_id ?>
                                        </td>
                                        </tr>
                                    <?php } ?>
                            <?php } ?>
                            </tbody></table>

                            <?php if ($end != 1) { ?>
                                <?php include $hs_view_include_path.'page.inc';?>
                            <?php } ?>

                        </div>
                        </ol>
                        </div>
                        </div>


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