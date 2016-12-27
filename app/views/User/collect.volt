{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">

			<div id="top_detail">

					<div id="top_detail_inner">
						<p>被收藏的预测师</p>
						{% for service in services %}
                            <div id="collect_pro">
                                <div class="yuce_img"><img src="{{ site_url }}/img/pro/{{ service['ps_user_id'] }}/s_{{ service['ps_user_id'] }}.jpg" style="height:130px;" /></div>
                                <div id="yuce_mes">
                                    <span class = "pro_0">{{ service['user_name'] }}</span>
                                    <span class = "yuceshi"><a href="{{ site_url }}online/tab1/{{ service['ps_user_id'] }}">点此进入预测师页面</a></span><br>
                                    <span class = "pro_1">总成交量：</span><span class = "pro_2">{{ service['sale_total'] }}</span>
                                    <span class = "pro_1">总好评率：</span><span class = "pro_2">{{ service['eval_percent'] }}</span>
                                    <span class = "pro_1">成交指数：</span><span class = "pro_2">{{ service['sale_point'] }}</span>
                                    <br /><br />
                                    <div id="pro_2">
                                        简介：{{ service['user_content'] }}<a href="{{ site_url }}online/tab1/{{ service['ps_user_id'] }}">更多……</a>
                                    </div>
                                </div>
                            </div>
						{% endfor %}
						{% if end != 1 %}
                            <?php include $hs_view_include_path.'page.inc';?>
                        {% endif %}
					</div>

				</div>


              <?php include $hs_view_include_path.'listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>