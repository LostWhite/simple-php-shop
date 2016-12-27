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

            						<h3>服务信息修改：</h3>
            						<div id="upload_ser">
            						    {% if flg is defined %}
            						    修改成功
            						    {% else %}
            							{{ form(site_url~'prophet/supdate', 'method': 'post', 'enctype': 'multipart/form-data') }}
                                        <div class="center-scaffold">
            								<table class="pro_apply">
                                            <!--tr>
            								<th>初始服务名</th>
            								<td>{{ form.render('t_ps_name',['value':service.t_ps_name])}}</td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if t_ps_name_err is defined %}
                                                        {{ t_ps_name_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr-->

                                            <tr>
            								<th><div>本站服务名</div></th>
            								<td>{{ form.render('ps_name',['value':site_service.ps_name])}}</td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if ps_name_err is defined %}
                                                        {{ ps_name_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr>

                                            <tr>
            								<th><div>服务类型</div></th>
            								<td>{{ form.render('t_ps_type',['value':service.t_ps_type])}}</td>
            								</tr>

            								<!--tr>
            								<th>当前图片</th>
            								<td><div><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_0.jpg" height="140" /></div></td>
            								</tr>

            								<tr>
            								<th>上传新图片</th>
            								<td><input type="file" name="..." size="40" input enctype="multipart/form-data" maxlength="100"></td>
            								</tr-->

                                            <tr>
            								<th><div>服务描述</div></th>
            								<td>{{ form.render('t_ps_content',['value':service.t_ps_content,'style':'height:80px;width:250px'])}}</td>
            								</tr>

                                            <tr>
            								<th><div>价格</div></th>
            								<td>{{ form.render('ps_price',['value':site_service.ps_price])}}</td>
                                            <td>
                                                <label class="hide" style="color: red;display:block">
                                                    {% if ps_price_err is defined %}
                                                        {{ ps_price_err }}
                                                    {% endif %}
                                                </label>
                                            </td>
            								</tr>
            								</table>

                                            <input type="hidden" name="ps_id" id="ps_id" value="{{ ps_id }}">
                                            <input type="hidden" name="ps_site_id" id="ps_site_id" value="{{ ps_site_id }}">

                                            <p class="btn_login" style="text-align:center;">
                                                {{ submit_button("确定", "class": "btn btn-primary") }}
                                            </p>
                                        </div>
            							</form>
                                        {% endif %}
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