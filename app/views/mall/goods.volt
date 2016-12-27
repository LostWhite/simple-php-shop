{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
		<ol id="pan">
			<li><a href="{{ site_url }}">返回首页</a></li>
						<li>xxx商城</li>
		</ol>
			<div id="main_inner">
				<div id="top_detail">
					<div id="item_info">

						<div id="title">
							<h1>xxx商品名称</h1>
							<h2></h2>
						</div>

						<div id="item_image">
							<p><a href="" target="_blank" rel="lightbox"><img src="<?php echo $site_url; ?>/img/test01_0.jpg"></a></p>
							<a href="" target="_blank" rel="lightbox">商品图片</a>
						</div>


						<div id="goods_detail">
							<table class="goods_mes">
								<tr>
								<th class="goods_td1"><strong>商品名</strong></th>
								<td></td>
								<th class="goods_td1">单价：</th><td>111</td>
								</tr>

								<tr>
								<th class="goods_td1">总成交量：</th><td>1111</td>
								<th class="goods_td1">剩余数量：</th><td>1111</td>
								</tr>

								<tr>
								<th class="goods_td1">总好评率：</th><td>1111</td>
								<th class="goods_td1">购买数量：</th>
								<td><input type="text" name="num" value="" size="5" maxlength="3"></td>
								</tr>

								<tr>
								<th class="goods_td1">成交指数：</th>
								<td>1111</td>
								<th class="goods_td1">总价：</th>
								<td>1111</td>
								</tr>
							</table>

							<a class="goods_a1" href="">立刻购买</a>
							<a class="goods_a2" href="">加入购物车</a>
						</div>
					</div>

						<h2 class="h2_goods_content">商品详情</h2>

					<div id="down_detail">
						<p>aaa aa a a a a  aaaaaa aaaaa a a a a a  aa  a  aaa a a  aa a  a a a  </p>
						<p> aa a a a aa a aa  a a a</p>
					</div>

				</div>
			</div>
		</section>

		<section id="r_clm">

			<?php include $hs_view_include_path.'menu.inc';?>
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
			</ol>
		</section>
		<br clear="all">

	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>