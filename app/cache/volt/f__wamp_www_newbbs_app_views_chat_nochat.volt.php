
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<section id="main">
			<ol id="pan">
				<li>预测师聊天室</li>
			</ol>
            <link href="<?= $site_url ?>public/css/chat.css" rel="stylesheet" type="text/css" />
            <link href="<?= $site_url ?>public/css/add/chat.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo $site_url; ?>public/js/ajaxfileupload.js"></script>

                </head>
                <body >
                <center>
<div class="chatContainer" style="min-height: 720px;">
 <!-- 预测师状态，忙碌时显示，或预测师与自己对话时信息-->
     <?php if ($roomstatus == 1) { ?>
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02" style="color:red">
                    预测师不能跟自己对话。
              </div>
              <div class="chat_not_03">
                    您可以试试<a href="<?= $site_url ?>">其他预测师</a>。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
    <?php } ?>
     <?php if ($roomstatus == 2) { ?>
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02">
                    预测师&nbsp;&nbsp;预测师名&nbsp;&nbsp;目前不在线，请稍后再来预测。
              </div>
              <div class="chat_not_03">
                    您可以<a href="">直接下单</a>后，等候预测师上线。试试<a href="<?= $site_url ?>">其他预测师</a>，或稍后再试。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
    <?php } ?>
         <?php if ($roomstatus == 3) { ?>
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02">
                    预测师&nbsp;&nbsp;预测师名&nbsp;&nbsp;目前忙碌中，请稍后再来预测。
              </div>
              <div class="chat_not_03">
                    您可以<a href="">直接下单</a>后，进入预测师排队等候。试试<a href="<?= $site_url ?>">其他预测师</a>，或稍后再试。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
        <?php } ?>
     <?php if ($roomstatus == 4) { ?>
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02" style="color:red">
                    预测师拒绝跟你交谈。
              </div>
              <div class="chat_not_03">
                    您可以试试<a href="<?= $site_url ?>">其他预测师</a>。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
        <?php } ?>

                </center>
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
