{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="http://127.0.0.1:8080/bbs_new/public/css/new.css">
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
                        		<li class="tab_on">黑名单列表<span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="a-totle1">
                            <table width="100%" class="table-striped">
                                {% if count == 0 %}
                                    <tr><td style="border-bottom:none; background:#fff">目前没有黑名单</td></tr>
                                {% else %}
                                    <tr>
                                        <th style="width:20%"><strong>用户名</strong></th>
                                        <th style="width:20%"><strong>添加时间</strong></th>
                                        <th style="width:20%"><strong>操作</strong></th>
                                    </tr>
                                    {% for user in users %}
                                        <tr>
                                        <td>{{ user['user_name'] }}</td>
                                        <td>{{ user['start_time'] }}</td>
                                        <td><a href="">删除</a></td>
                                        </tr>
                                    {% endfor %}
                                {% endif %}
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