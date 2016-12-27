{{ content() }}
{% include "../config/link.php" %}
<link rel="stylesheet" type="text/css" href="{{ site_url }}public/css/new.css">
<link rel="stylesheet" type="text/css" href="{{ site_url }}public/css/usbb.css">

<script type="text/javascript">
$(function(){
    var status = document.getElementById('status').value;
    status--;
    $("#menu_li li").removeClass("tab_on");
    $("#menu_li li:eq("+status+")").addClass("tab_on");
});
</script>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner">
{%- if (logged_in is empty) %}
                       <script>window.location.href="/bbs_new/session/login"</script>
            {% endif %}
			<div id="top_detail">
					<div id="top_detail_inner">
						<h3 class="p_per">总览：</h3>
						<div id="main_property">
							<div class="per_img"><img src="{{ site_url }}/img/test01_0.jpg" style="height:130px;" /></div>
							<div id="property_mess">
								<table class="property_mes">
								<tr>
								<th>用户名</th>
								<td>{{ logged_in }}</td>
								</tr>

								<tr>
								<th>账户余额</th>
								<td>{{ property.coin }}</td>
								</tr>

                                <tr>
								<th>冻结金额</th>
								<td>{{ property.freeze_coin }}</td>
								<th>可用金额</th>
                                <td>{{ property.remain_coin }}</td>
								</tr>

								<tr>
								<th>最近一次交易时间</th>
								<td>{{ property.t_property_dt }}</td>
								<th>消费金额</th>
								<td>
								    {% if money.ps_price is defined %}
								        {{ money.ps_price }}
								    {% endif %}
								</td>

								</tr>
								</table>
							</div>
						</div>

						<!--tab开始-->
						<input type="hidden" name="status" id="status" value="{{ status }}">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="{{ site_url }}money/detail/1">所有</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/detail/2">充值记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/detail/3">提现记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/detail/4">收入记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/detail/5">支出记录</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="a-totle1">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            {% if count == 0 %}
                                <tr><td style="border-bottom:none; background:#fff">目前没有订单记录</td></tr>
                            {% else %}
                                <tr>
								<th><strong>交易时间</strong></th>
                                <th><strong>交易方式</strong></th>
                                <th><strong>收支</strong></th>
                                <th><strong>余额</strong></th>
                                <th><strong>注记</strong></th>
                                </tr>
                                    {% for order in orders %}
                                        <tr>
                                        <td>{{ order.property_dt }}</td>
                                        <td>{{ order.type_memo }}</td>
                                        <td>{{ order.money }}</td>
                                        <td>{{ order.account }}</td>
                                        <td>
                                            {{ order.order_id }}
                                        </td>
                                        </tr>
                                    {% endfor %}
                            {% endif %}
                            </tbody></table>

                            {% if end != 1 %}
                                <?php include $hs_view_include_path.'page.inc';?>
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