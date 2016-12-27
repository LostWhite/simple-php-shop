<?= $this->getContent() ?>

<?php
$domain="";
$url = BASE_DIR."/public/";
$site_url = "http://localhost/newbbs/";

//$site_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/";
$hs_view_include_path =APP_DIR. "/views/include/";
?>
<link rel="stylesheet" type="text/css" href="<?= $site_url ?>public/css/new.css">
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">

			<div id="top_detail">
					<div id="top_detail_inner">


                        <!--tab开始-->
                        <input type="hidden" name="site_url" id="site_url" value="<?= $site_url ?>">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on">我的订单<span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="p-totle1">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-striped">
                            <?php if ($count == 0) { ?>
                                <tr><td style="border-bottom:none; background:#fff">目前没有订单记录</td></tr>
                            <?php } else { ?>
                                <th><strong>订单号</strong></th>
                                <th><strong>订单日期</strong></th>
                                <th><strong>服务项目</strong></th>
                                <th><strong>单价</strong></th>
                                <th><strong>预测师</strong></th>
                                <th><strong>状态</strong></th>
                                <th><strong>操作</strong></th>
                                </tr>
                                <?php foreach ($orders as $order) { ?>
                                    <tr>
                                    <td><?= $order['t_order_id'] ?></td>
                                    <td><?= $order['trade_date'] ?></td>
                                    <td><?= $order['ps_name'] ?></td>
                                    <td><?= $order['ps_price'] * $order['ps_nums'] ?></td>
                                    <td><?= $order['user_name'] ?></td>
                                    <?php if ($order['status'] == 1) { ?>
                                        <td>进行中</td>
                                    <?php } ?>
                                    <?php if ($order['status'] == 2) { ?>
                                        <td>已完成</td>
                                    <?php } ?>
                                    <td><a href="javascript:order_delete('<?= $site_url ?>order/orders',<?= $order['t_order_id'] ?>,<?= $order['status'] ?>)">删除记录</a><br>下载记录</td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody></table>

                            <!--?php include $hs_view_include_path.'page.inc';?-->
                            <?php if ($end != 1) { ?>
                                	<?php
	if($end > 0){
		if($current == 1){
			echo "<div class='page'><em>上一页&nbsp;</em>";
		}else{
			$pages = $current-1;
			echo "<div class='page'><a href='$url_page?p=$pages' >上一页&nbsp;</a>";
		}
		
		for($p = 1;$p <= $end;$p ++){
			if($p == $current){
				echo "<strong>$p</strong>&nbsp;";
			}else{
				echo "<a href='$url_page?p=$p' >$p&nbsp;</a>";
			}
		}
		if($current == $end){
			echo "<em>下一页&nbsp;</em></div>";
		}else{
			$pages = $current+1;
			echo "<a href='$url_page?p=$pages' >下一页&nbsp;</a></div>";
		}
	}
?>
                            <?php } ?>
                        </div>
                        </ol>
                        </div>

                        </div>

					</div>
</div>


              <!--?php include $hs_view_include_path.'listleft.inc';?-->
              <div id="l_clm">
    <h5><a href="">个人财务</a></h5>
	    <ul>
	        <li><a href="<?php echo $site_url;?>money/detail/1">财务明细</a></li>
	        <li><a href="<?php echo $site_url;?>order/orders">我的订单</a></li>
	        <li><a href="<?php echo $site_url;?>money/recharge/1">购买/提现算卦币</a></li>
        </ul>
    <h5><a href="">个人信息</a></h5>
	    <ul>
            <li><a href="<?php echo $site_url;?>user">个人资料</a></li>
	   	    <li><a href="<?php echo $site_url;?>user/increase">个人信息完善及修改</a></li>
	        <li><a href="<?php echo $site_url;?>user/modipass">密码修改</a></li>
	        <li><a href="<?php echo $site_url;?>user/icon">设置头像</a></li>
            <li><a href="<?php echo $site_url;?>user/blacklist">黑名单</a></li>
        </ul>
    <h5><a href="">预测师相关</a></h5>
	    <ul>
	        <li><a href="<?php echo $site_url;?>user/collect">收藏的预测师</a></li>
	        <li><a href="<?php echo $site_url;?>order/assess">我的评价</a></li>
	        <li><a href="<?php echo $site_url;?>order/test">测试记录</a></li>
	    </ul>
    <h5><a href="">站内消息</a></h5>
	    <ul>
	        <li><a href="<?php echo $site_url;?>message/information">我的消息</a></li>
	        <li><a href="<?php echo $site_url;?>message/record">交谈记录</a></li>
	    </ul>
    <h5><a href="">待定</a></h5>
	    <ul>
	        <li><a href="">待定</a></li>
	        <li><a href="">待定</a></li>
	        <li><a href="">待定</a></li>
	        <li><a href="">待定</a></li>
        </ul>
    <h5><a href="">待定</a></h5>
	    <ul>
	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	      	   	   	</ul>
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

	<!--?php include $hs_view_include_path.'footer.inc';?-->
	<footer>
			<p class="btn_gototop"><a href="#pagetop" onFocus="this.blur()" onClick="smoothScroll();return false;" onKeyPress="smoothScroll();return false;" title="このページのトップへ">このページのトップへ</a></p>

			<!-- <ul>
				<li><a href="/pc_topLogin_login.html">ログイン</a></li>
				<li><a href="/pc_cart_index.html">買い物カゴ</a></li>
				<li><a href="/pc_topMypage_index1.html">マイページ</a></li>
				<li><a href="/shop/etc/guide.html">ご利用案内</a></li>
				<li><a href="/shop/etc/privacy.html">プライバシーポリシー</a></li>
				<br clear="all">
			</ul>
			<ul class="line2nd">
				<li><a href="/pc_top_index.html">ホーム</a></li>
				<li><a href="/shop/etc/recruit.html">求人案内</a></li>
				<li><a href="/shop/etc/kyouhan.html">図書取扱店</a></li>
				<li><a href="/shop/etc/topics.html">トピックス</a></li>
				<li><a href="/shop/etc/profile.html">会社概要</a></li>
				<li><a href="/shop/etc/kojin.html">お問い合せ</a></li>
				<li><a href="/shop/etc/sitemap.html">サイトマップ</a></li>
				<br clear="all">
			</ul> -->
			<address>Copyright &copy; 2015 大连华思软件有限公司 / All Rights Reserved.</address>
</footer>
</body>