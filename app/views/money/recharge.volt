{{ content() }}
{% include "../config/link.php" %}

<script type="text/javascript">
$(function(){
    var status = document.getElementById('status').value;
    status--;
    $("#menu_li li").removeClass("tab_on");
    $("#menu_li li:eq("+status+")").addClass("tab_on");
});
function doRefill(name){
$("#"+name).submit();
}

</script>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner">

			<div id="top_detail">
					<div id="top_detail_inner">
						<h3 class="p_per">购买算卦币：</h3>

                        <div class="recharge_title">
                            <span>购买/提现算卦币</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>50 算卦币 = 50 元人民币 = 10 美元</span>
                        </div>

                        <!--tab开始-->
                        <input type="hidden" name="status" id="status" value="{{ status }}">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="{{ site_url }}money/recharge/1">快捷支付</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/recharge/2">海外支付</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/recharge/3">其他支付</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/recharge/4">付费指南</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/recharge/5">提现算卦币</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="p-totle1">

                            {% if status == 1 %}
                                {% include "money/recharges/quick.volt" %}
                            {% elseif status == 2 %}
                                {% include "money/recharges/foreign.volt" %}
                            {% elseif status == 3 %}
                            {% elseif status == 4 %}
                            {% elseif status == 5 %}
                                {% include "money/recharges/cash.volt" %}
                            {% endif %}

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
			{% include "include/menu.volt" %}
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>