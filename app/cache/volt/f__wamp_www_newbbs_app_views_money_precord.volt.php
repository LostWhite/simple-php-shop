<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>/public/css/new.css">
<script type="text/javascript">
$(function(){
    var status = document.getElementById('status').value;
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


                        <!--tab开始-->
						<input type="hidden" name="status" id="status" value="<?= $status ?>">
						<input type="hidden" name="site_url" id="site_url" value="<?= $site_url ?>">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="<?= $site_url ?>money/precord/1">我的预测项一览</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/precord/2">我的订单</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="p-totle1">
                        <table class="table-striped">
                            <?php if ($count == 0) { ?>
                                <tr><td style="border-bottom:none; background:#fff">目前没有订单记录</td></tr>
                            <?php } else { ?>
                                <th><strong>订单号</strong></th>
                                <th><strong>订单日期</strong></th>
                                <th><strong>服务项目</strong></th>
                                <th><strong>单价</strong></th>
                                <?php if ($status == 0) { ?>
                                    <th><strong>客户名</strong></th>
                                <?php } else { ?>
                                    <th><strong>预测师</strong></th>
                                <?php } ?>
                                <th><strong>状态</strong></th>
                                <th><strong>操作</strong></th>
                                </tr>
                                <?php foreach ($orders as $order) { ?>
                                    <tr>
                                    <td><?= $order['t_order_id'] ?></td>
                                    <td><?= $order['trade_date'] ?></td>
                                    <td><?= $order['ps_name'] ?></td>
                                    <td><?= $order['ps_price'] * $order['ps_nums'] ?></td>
                                    <?php if ($status == 0) { ?>
                                        <td><?= $order['login_id'] ?></td>
                                    <?php } else { ?>
                                        <td><?= $order['user_name'] ?></td>
                                    <?php } ?>
                                    <?php if ($order['status'] == 1) { ?>
                                        <td>进行中</td>
                                    <?php } ?>
                                    <?php if ($order['status'] == 2) { ?>
                                        <td>已完成</td>
                                    <?php } ?>
                                    <td><a href="javascript:order_delete('<?= $site_url ?>money/precord/<?= $status + 1 ?>',<?= $order['t_order_id'] ?>,<?= $order['status'] ?>)">删除记录</a><br>下载记录<br>发私信</td>
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