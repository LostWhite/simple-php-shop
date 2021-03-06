<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="http://127.0.0.1:8080/bbs_new/public/css/new.css">
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
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on">黑名单列表<span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="a-totle1">
                            <table width="100%" class="table-striped">
                                <?php if ($count == 0) { ?>
                                    <tr><td style="border-bottom:none; background:#fff">目前没有黑名单</td></tr>
                                <?php } else { ?>
                                    <tr>
                                        <th style="width:20%"><strong>用户名</strong></th>
                                        <th style="width:20%"><strong>添加时间</strong></th>
                                        <th style="width:20%"><strong>操作</strong></th>
                                    </tr>
                                    <?php foreach ($users as $user) { ?>
                                        <tr>
                                        <td><?= $user['user_name'] ?></td>
                                        <td><?= $user['start_time'] ?></td>
                                        <td><a href="">删除</a></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
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