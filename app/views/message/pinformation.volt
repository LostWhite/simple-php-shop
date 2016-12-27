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

            						<h3>我的消息：</h3>
            						<div id="property_mes">
            							<table class="property_mes">
            							<tr>
            							<th><strong>发信用户</strong></th>
            							<th><strong>发信时间</strong></th>
            							<th><strong>操作</strong></th>
            							</tr>


            							<tr>
            							<td>aaaaaaaaaaa</td>
            							<td>aaaaaaaaaaa</td>
            							<td><a href="">查看</a> &nbsp; <a href="">删除</a></td>

            							</tr>

            							<tr>
            							<td>aaaaaaaaaaa</td>
            							<td>aaaaaaaaaaa</td>
            							<td><a href="">查看</a> &nbsp; <a href="">删除</a></td>

            							</tr>

            							<tr>
            							<td>aaaaaaaaaaa</td>
            							<td>aaaaaaaaaaa</td>
            							<td><a href="">查看</a> &nbsp; <a href="">删除</a></td>

            							</tr>
            							</table>
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