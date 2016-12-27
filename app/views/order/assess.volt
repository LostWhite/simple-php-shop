{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

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
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on">我的评价<span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="a-totle1">
                            <table class="centeryu_con">
                                {% for eva in evas %}
                                    <tr>
                                    <th><strong>■{{ eva['tdate'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;服务项目：{{ eva['ps_name'] }}[订单号：{{ eva['order_id'] }}]&nbsp;预测师：{{ eva['user_name'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ eva['eval_score'] }}星</strong></th>
                                    </tr>
                                    <tr>
                                    <td>{{ eva['eval_memo'] }}</td>
                                    </tr>
                                {% endfor %}
                            </table>
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