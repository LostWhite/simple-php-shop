{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="{{ site_url }}public/css/usbbb.css">

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>预测师随笔</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
<h2 id="title_co_kyouhan">预测师随笔</h2>

{% include "include/article.volt" %}

</div>
			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}

		</section>
		<br clear="all">

	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>