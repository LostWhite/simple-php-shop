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

            						<h3>追加新服务项：</h3>
            						<br>
            						<div id="upload_ser">
            							{{ form(site_url~'prophet/supload', 'method': 'post', 'enctype': 'multipart/form-data') }}
            							<div class="center-scaffold">
            								<table class="pro_apply">
            								<tr>
            								<th><div>服务名：</div></th>
            								<td>{{ form.render('t_ps_name')}}</td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if t_ps_name_err is defined %}
                                                        {{ t_ps_name_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr>

                                            <tr>
            								<th><div>服务类型：</div></th>
            								<td>{{ form.render('t_ps_type')}}</td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if t_ps_type_err is defined %}
                                                        {{ t_ps_type_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr>

                                            <!--tr>
            								<th><div>中项目分类：</div></th>
            								<td>{{ form.render('category_sub_id	')}}</td>
            								</tr-->

            								<!--tr>
            								<th><div>上传图片：</div></th>
            								<td><input type="file" name="..." size="40" input enctype="multipart/form-data" maxlength="100"></td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if file_err is defined %}
                                                        {{ file_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr-->

            								<tr>
            								<th><div>服务描述：</div></th>
            								<td>{{ form.render('t_ps_content')}}</td>
            								</tr>

            								<tr>
            								<th><div>单价：</div></th>
            								<td>{{ form.render('ps_price')}}</td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if ps_price_err is defined %}
                                                        {{ ps_price_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr>
            								</table>

                                            <p class="btn_login" style="text-align:center;">
                                                {{ submit_button("确定", "class": "btn btn-primary", "id":"btn_sub") }}
                                            </p>
                                        </div>
            							</form>

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