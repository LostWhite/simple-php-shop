{{ content() }}
{% include "../config/link.php" %}
<link rel="stylesheet" type="text/css" href="{{ site_url }}public/css/new.css">
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">

			<div id="top_detail">
					<div id="top_detail_inner">


                        <!--tab开始-->
                        <input type="hidden" name="site_url" id="site_url" value="{{ site_url }}">
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
                            {% if count == 0 %}
                                <tr><td style="border-bottom:none; background:#fff">目前没有订单记录</td></tr>
                            {% else %}
                                <th><strong>订单号</strong></th>
                                <th><strong>订单日期</strong></th>
                                <th><strong>服务项目</strong></th>
                                <th><strong>单价</strong></th>
                                <th><strong>预测师</strong></th>
                                <th><strong>状态</strong></th>
                                <th><strong>操作</strong></th>
                                </tr>
                                {% for order in orders %}
                                    <tr>
                                    <td>{{ order['t_order_id'] }}</td>
                                    <td>{{ order['trade_date'] }}</td>
                                    <td>{{ order['ps_name'] }}</td>
                                    <td>{{ order['ps_price']*order['ps_nums'] }}</td>
                                    <td>{{ order['user_name'] }}</td>
                                    {% if order['status'] == 1 %}
                                        <td>进行中</td>
                                    {% endif %}
                                    {% if order['status'] == 2 %}
                                        <td>已完成</td>
                                    {% endif %}
                                    <td><a href="javascript:order_delete('{{ site_url }}order/orders',{{ order['t_order_id'] }},{{ order['status'] }})">删除记录</a><br>下载记录</td>
                                    </tr>
                                {% endfor %}
                            {% endif %}
                            </tbody></table>

                            <!--?php include $hs_view_include_path.'page.inc';?-->
                            {% if end != 1 %}
                                {% include "include/page.inc" %}
                            {% endif %}
                        </div>
                        </ol>
                        </div>

                        </div>

					</div>
</div>


              <!--?php include $hs_view_include_path.'listleft.inc';?-->
              {% include "include/listleft.inc" %}

			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}
		</section>

		<br clear="all">
	</div>

	<!--?php include $hs_view_include_path.'footer.inc';?-->
	{% include "include/footer.volt" %}
</body>