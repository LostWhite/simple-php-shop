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

                        <!--tab开始-->
						<input type="hidden" name="status" id="status" value="{{ status }}">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on">我的随笔<span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="a-totle1">
                            <table style="width : 100%; font-size:15px; color:#7c7c7c;">
                                {% set date = 0 %}
                                <tr style="background-color:#eee; padding:5px; text-align:left;">
                                    <td style="width:10%">文件类型</td>
                                    <td style="width:50%">标题</td>
                                    <td style="width:25%">日期</td>
                                    <td style="width:15%">操作</td>
                                </tr>
                                {% for note in notes %}
                                    <tr>
                                        <td style="width:10%">[文件类型]</td>
                                        <td style="width:50%"><a href="{{ site_url }}article/tarticle/{{ note['id'] }}">{{ note['title'] }}</a></td>
                                        <td style="width:25%">{{ note['f_date'] }}</td>
                                        <td style="width:15%"><a href="{{ site_url }}article/editor/{{ note['id'] }}">编辑</a></td>
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