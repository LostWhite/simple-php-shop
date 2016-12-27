{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner">
				<div id="top_detail">
<div class="p_title"><h1 class="left" style="font-size:26px;font-weight:normal;font-family:arial, simsun;color:red;background-color:#FFFFFF;">
                     	{{ note.title }}
                     </h1>
<span>{% if editor is defined %}<a href="{{ site_url }}article/editor/{{ note.id }}">编辑</a>{% endif %}</span>
</div>

<div class="author"><span>作者：</span></div>

<div id="co_kyouhan_table">

{{ note.page_text }}

</div>

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