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

            						<h3>上传新商品：</h3>
            						<div id="upload_ser">
            							<form action="">
            								<table class="upload_ser">
            								<tr>
            								<th>商品名</th>
            								<td><input type="text" name="qq_number" value="" size="40"></td>
            								</tr>


            								<tr>
            								<th>上传图片</th>
            								<td><input type="file" name="..." size="40" input enctype="multipart/form-data" maxlength="100"></td>
            								</tr>

            								<tr>
            								<th>详细描述</th>
            								<td><textarea type="text" name="method_number" value="" style="width:225px;height:80px;"></textarea></td>
            								</tr>

            								<tr>
            								<th>单价</th>
            								<td><input type="text" name="qq_number" value="" size="40"></td>
            								</tr>
            								</table>

            								<input class="ser_sub" name="button" type="submit" value="提交"/>

            							</form>

            						</div>

            					</div>
            </div>

              <?php include $hs_view_include_path.'/prophet/listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			<?php include $hs_view_include_path.'menu.inc';?>
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>