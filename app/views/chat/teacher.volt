<?php
        include(APP_DIR."/config/link.php");
?>
{%- if (logged_in is empty) %}
<script>
    var site_url='<?php echo $site_url?>'
    window.location.href=site_url+"session/login"
</script>
{% endif %}
{{ content() }}


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
							<h1>预测师一览</h1>
							<h2></h2>
						</div>

					</div>

					<hr>
					<div id="down_detail">

                        {% for teacherOne in teacherInfo %}
                        <div class="shop_img">
                            <a href="<?php echo $site_url;?>chat/index?room_id={{teacherOne.ps_user_id}}_{{userId}}" title=''>
                                <img src="<?php echo $site_url; ?>img/noavatar_big.gif" style="height:130px;" />
                                <h2><em style="color: #0000ff"></em>{{teacherOne.user_name}}</h2>
                            </a>
                        </div>

                        {% endfor %}


						<!--<div class="shop_img">-->
                        	<!--<a href="<?php echo $site_url;?>mall/goods" title='月刊デンタルダイヤモンド 2013年8月号'>-->
                        	<!--<img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" />-->
                        	<!--<h2>点击进入商品介绍</h2>-->
                        	<!--<em>定価：13,230円（税込）</em>-->
                        	<!--</a>-->
                        <!--</div>-->
                        <!--<div class="shop_img">-->
                            <!--<a href="<?php echo $site_url;?>mall/goods" title='月刊デンタルダイヤモンド 2013年8月号'>-->
                            <!--<img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" />-->
                            <!--<h2>点击进入商品介绍</h2>-->
                            <!--<em>定価：13,230円（税込）</em>-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="shop_img">-->
                            <!--<a href="<?php echo $site_url;?>mall/goods" title='月刊デンタルダイヤモンド 2013年8月号'>-->
                            <!--<img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" />-->
                            <!--<h2>点击进入商品介绍</h2>-->
                            <!--<em>定価：13,230円（税込）</em>-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="shop_img">-->
                            <!--<a href="<?php echo $site_url;?>mall/goods" title='月刊デンタルダイヤモンド 2013年8月号'>-->
                            <!--<img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" />-->
                            <!--<h2>点击进入商品介绍</h2>-->
                            <!--<em>定価：13,230円（税込）</em>-->
                            <!--</a>-->
                        <!--</div>-->
                        <!--<div class="shop_img">-->
                            <!--<a href="<?php echo $site_url;?>mall/goods" title='月刊デンタルダイヤモンド 2013年8月号'>-->
                            <!--<img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" />-->
                            <!--<h2>点击进入商品介绍</h2>-->
                            <!--<em>定価：13,230円（税込）</em>-->
                            <!--</a>-->
                        <!--</div>-->

					</div>

				</div>
			</div>
		</section>

		<section id="r_clm">

			{% include "include/menu.volt" %}
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