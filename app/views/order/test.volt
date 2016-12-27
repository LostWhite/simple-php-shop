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
						<table class="centeryu_test">
							<tr>
							<th><strong>预测师</strong></th>
							<th><strong>预测时间</strong></th>
							<th><strong>操作</strong></th>
							</tr>


							<tr>
							<td>aaaaaaaaaaa</td>
							<td>aaaaaaaaaaa</td>
							<td><a href ="">删除</a> &nbsp;<a href ="">下载</a> &nbsp;<a href ="">发私信</a></td>

							</tr>

							<tr>
							<td>aaaaaaaaaaa</td>
							<td>aaaaaaaaaaa</td>
							<td><a href ="">删除</a> &nbsp;<a href ="">下载</a> &nbsp;<a href ="">发私信</a></td>

							</tr>

							<tr>
							<td>aaaaaaaaaaa</td>
							<td>aaaaaaaaaaa</td>
							<td><a href ="">删除</a> &nbsp;<a href ="">下载</a> &nbsp;<a href ="">发私信</a></td>

							</tr>
						</table>

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