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
                                {% for o in order %}
                                    <tr>
                                        <th>订单号：</th>
                                        <td>{{ o['t_order_id'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>订单日期：</th>
                                        <td>{{ o['trade_date'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>预测师：</th>
                                        <td>{{ o['user_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>服务项目：</th>
                                        <td>{{ o['ps_name'] }}</td>
                                    </tr>
                                    {% if m == 'add' %}
                                        <tr>
                                            <th>评价：</th>
                                            <td>{{ ass.eval_score }}星
                                                <ul class="rating fivestar">
                                                    <li class="one"><a href="#" title="1 Star">1</a></li>
                                                    <li class="two"><a href="#" title="2 Stars">2</a></li>
                                                    <li class="three"><a href="#" title="3 Stars">3</a></li>
                                                    <li class="four"><a href="#" title="4 Stars">4</a></li>
                                                    <li class="five"><a href="#" title="5 Stars">5</a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>现有：</th>
                                            <td>{{ ass.eval_memo }}</td>
                                        </tr>
                                        <tr>
                                            <th>追加：</th>
                                            <td><textarea id="ass_content" class="ass_content" name="eval_memo"></Textarea></td>
                                        </tr>
                                    {% elseif m == 'first' %}
                                        <tr>
                                            <th>评价：</th>
                                            <td><input type="text" name="eval_score"/>星</td>
                                        </tr>
                                        <tr>
                                            <th>内容：</th>
                                            <td><textarea id="ass_content" class="ass_content" name="eval_memo"></Textarea></td>
                                        </tr>
                                    {% endif %}
                                {% endfor %}
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