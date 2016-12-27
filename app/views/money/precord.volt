{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="{{ site_url }}/public/css/new.css">
<script type="text/javascript">
$(function(){
    var status = document.getElementById('status').value;
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


                        <!--tab开始-->
						<input type="hidden" name="status" id="status" value="{{ status }}">
						<input type="hidden" name="site_url" id="site_url" value="{{ site_url }}">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="{{ site_url }}money/precord/1">我的预测项一览</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}money/precord/2">我的订单</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="p-totle1">
                        <table class="table-striped">
                            {% if count == 0 %}
                                <tr><td style="border-bottom:none; background:#fff">目前没有订单记录</td></tr>
                            {% else %}
                                <th><strong>订单号</strong></th>
                                <th><strong>订单日期</strong></th>
                                <th><strong>服务项目</strong></th>
                                <th><strong>单价</strong></th>
                                {% if status == 0 %}
                                    <th><strong>客户名</strong></th>
                                {% else %}
                                    <th><strong>预测师</strong></th>
                                {% endif %}
                                <th><strong>状态</strong></th>
                                <th><strong>操作</strong></th>
                                </tr>
                                {% for order in orders %}
                                    <tr>
                                    <td>{{ order['t_order_id'] }}</td>
                                    <td>{{ order['trade_date'] }}</td>
                                    <td>{{ order['ps_name'] }}</td>
                                    <td>{{ order['ps_price']*order['ps_nums'] }}</td>
                                    {% if status == 0 %}
                                        <td>{{ order['login_id'] }}</td>
                                    {% else %}
                                        <td>{{ order['user_name'] }}</td>
                                    {% endif %}
                                    {% if order['status'] == 1 %}
                                        <td>进行中</td>
                                    {% endif %}
                                    {% if order['status'] == 2 %}
                                        <td>已完成</td>
                                    {% endif %}
                                    <td><a href="javascript:order_delete('{{ site_url }}money/precord/{{ status+1 }}',{{ order['t_order_id'] }},{{ order['status'] }})">删除记录</a><br>下载记录<br>发私信</td>
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