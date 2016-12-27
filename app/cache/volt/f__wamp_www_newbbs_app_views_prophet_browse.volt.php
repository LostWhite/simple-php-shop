<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>public/css/usbbb.css">

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="<?= $site_url ?>">返回首页</a></li>
				<li>预测师随笔</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
<h2 id="title_co_kyouhan">预测师随笔</h2>

<div id="article_table" style="min-height:800px;margin:10px 0 0 0;">
<table style="width : 100%; font-size:15px; color:#7c7c7c;">
    <tr style="background-color:#eee; padding:5px; text-align:left;">
        <td style="width:10%">文件类型</td>
        <td style="width:50%">标题</td>
        <td style="width:15%">作者</td>
        <td style="width:25%">日期</td>
    </tr>
<?php foreach ($notes as $note) { ?>
    <tr>
        <td style="width:10%">[文件类型]</td>
        <td style="width:50%"><a href="<?= $site_url ?>article/tarticle/<?= $note['id'] ?>"><?= $note['title'] ?></a></td>
        <td style="width:15%"><a href="<?= $site_url ?>online/tab1/<?= $note['ps_user_id'] ?>"><?= $note['user_name'] ?></a></td>
        <td style="width:25%"><?= $note['date'] ?></td>
    </tr>
<?php } ?>
</table>
<?php if ($end != 1) { ?>
    <?php include $hs_view_include_path.'page.inc';?>
<?php } ?>
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

		</section>
		<br clear="all">

	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>