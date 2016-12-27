{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<script>

</script>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner">
				<div id="top_detail">
                    <h2 id="title_co_kyouhan" style="font-size:18px">服务评价</h2>
                    <div id="ass_detail">
                        {{ form(site_url~'order/adetail',  'method': 'post', 'enctype': 'multipart/form-data') }}
                            <table class="ass_detail">
                                    <tr>
                                        <th>测试号：</th>
                                        <td>测试号</td>
                                    </tr>
                                    <tr>
                                        <th>测试日期：</th>
                                        <td>测试日期</td>
                                    </tr>
                                    <tr>
                                        <th>预测师：</th>
                                        <td>预测师名</td>
                                    </tr>
                                    <tr>
                                        <th>客户名：</th>
                                        <td>客户名</td>
                                    </tr>
                                    <tr>
                                        <th>评价：</th>
                                        <td><input type="text" name="eval_score"/>星</td>
                                    </tr>
                                    <tr>
                                        <th>内容：</th>
                                        <td><textarea id="ass_content" class="ass_content" name="eval_memo"></Textarea></td>
                                    </tr>
                            </table>
                            <div class="sub_btn">
                                {{ submit_button("提交", "class": "btn_sub") }}
                            </div>
                        </form>
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