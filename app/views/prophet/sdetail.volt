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
            						<div id="per_yc">
            							{% for service in services %}
                                            <div class="per_ser">
                                                <div class="ser_name">{{ service['ps_name'] }}</div>
                                                <div class="ser_content">
                                                    <p>
                                                    {{ service['t_ps_content'] }}
                                                    </p>
                                                </div>
                                                <div class="ser_price">
                                                    <em>定価：{{ service['ps_price'] }}</em>
                                                    <div class="ser_buy">
                                                        <a href="{{ site_url }}prophet/supdate?ps_id={{ service['ps_id'] }}&ps_site_id={{ service['ps_site_id'] }}">修改</a>&nbsp;|
                                                        <a href="javascript:service_delete('{{ site_url }}',{{ service['ps_id'] }},{{ service['ps_site_id'] }})">删除</a>
                                                    </div>
                                                </div>
                                            </div>
            							{% endfor %}
            						</div>
            						{% if end != 1 %}
            						    <?php include $hs_view_include_path.'page.inc';?>
            						{% endif %}
            </div>
            </div>


              <?php include $hs_view_include_path.'/prophet/listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>