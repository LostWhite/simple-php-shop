<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<script>

</script>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner">
				<div id="top_detail">
                    <h2 id="title_co_kyouhan" style="font-size:18px">服务评价</h2>
                    <div id="ass_detail">
                        <?= $this->tag->form([$site_url . 'order/adetail', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
                            <table class="ass_detail">
                                <?php foreach ($order as $o) { ?>
                                    <tr>
                                        <th>订单号：</th>
                                        <td><?= $o['t_order_id'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>订单日期：</th>
                                        <td><?= $o['trade_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>预测师：</th>
                                        <td><?= $o['user_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>服务项目：</th>
                                        <td><?= $o['ps_name'] ?></td>
                                    </tr>
                                    <?php if ($m == 'add') { ?>
                                        <tr>
                                            <th>评价：</th>
                                            <td><?= $ass->eval_score ?>星
                                                <ul class="rating fivestar">
                                                    <li class="one"><a href="#" title="1 Star">1</a></li>
                                                    <li class="two"><a href="#" title="2 Stars">2</a></li>
                                                    <li class="three"><a href="#" title="3 Stars">3</a></li>
                                                    <li class="four"><a href="#" title="4 Stars">4</a></li>
                                                    <li class="five"><a href="#" title="5 Stars">5</a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>现有：</th>
                                            <td><?= $ass->eval_memo ?></td>
                                        </tr>
                                        <tr>
                                            <th>追加：</th>
                                            <td><textarea id="ass_content" class="ass_content" name="eval_memo"></Textarea></td>
                                        </tr>
                                    <?php } elseif ($m == 'first') { ?>
                                        <tr>
                                            <th>评价：</th>
                                            <td><input type="text" name="eval_score"/>星</td>
                                        </tr>
                                        <tr>
                                            <th>内容：</th>
                                            <td><textarea id="ass_content" class="ass_content" name="eval_memo"></Textarea></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                            <div class="sub_btn">
                                <?= $this->tag->submitButton(['提交', 'class' => 'btn_sub']) ?>
                            </div>
                        </form>
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