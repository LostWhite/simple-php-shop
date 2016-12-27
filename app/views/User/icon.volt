
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
						<p class="p_per">设置头像:</p>
					{{ form(site_url~'user/icon',  'method': 'post', 'enctype': 'multipart/form-data') }}
					<div class="center-scaffold">
						<table class="pro_apply">
							<tbody>
								<tr>
									<th><div>当前头像：</div></th>
									<td class="td_img"><div>

									<img src="{{ site_url }}/img/per/{{auth.getIdentity()['id']}}/m.jpg" onerror="javascript:this.src='{{ site_url }}/img/per/default_user.jpg';"  height="140"/>
									<!--img src="{{ image_url }}" height="140"/--></div></td>
								</tr>

								<tr>
									<th><div>上传新头像：</div></th>
									<td>
										<input type="file" name="icon" size="40" input enctype="multipart/form-data" maxlength="100">
									</td>
								</tr>
							</tbody>
						</table>
						<div class="p_img">
                                        <label class="hide" style="color: red;display:block">
                                            {% if file_err is defined %}
                                                {{ file_err }}
                                            {% endif %}
                                        </label>
						<p>上传图片尺寸150x150，支持gif，jpg，png；大小不能大于100k</p></div>

                                <p class="btn_login" style="text-align:center;">
                                     {{ submit_button("提交", "class": "btn btn-primary","id":"btn_sub") }}
                                </p>
                    </div>
					</form>
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