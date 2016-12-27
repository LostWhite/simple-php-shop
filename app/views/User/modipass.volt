
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
                {%- if (logged_in is empty) %}
                     <script>window.location.href="{{site_url}}session/login"</script>
                {% endif %}
			<div id="main_inner">
			<div id="top_detail">
			    <div id="top_detail_inner">
                    {% if flg is defined %}
                        <p class="p_per">修改成功</p>
                    {% else %}
				    <p class="p_per">修改密码:</p>
					{{ form(site_url~'user/modipass',  'method': 'post', 'enctype': 'multipart/form-data') }}
					<div class="center-scaffold">
						<table class="pro_apply">
							<tbody>
								<tr>
									<th><div>电子邮箱：</div></th>
									<td><label id="email" class="hide" style="display:block">{{ user.email }}</label><em></em></td>
								</tr>
								<tr>
									<th><div>用户名：</div></th>
									<td><label id="name" class="hide" style="display:block">{{ user.login_id }}</label><em></em></td>
								</tr>
								<tr>
									<th><div>旧密码：</div></th>
								    <td>{{ form.render('password1') }}</td>
									<td>
                                        <label id="username_succeed" class="hide" style="display:none">4-20位字符，支持数字字母下划线</label>
                                        <label class="hide" style="color: red;display:block">
                                            {% if password1_err is defined %}
                                                {{ password1_err }}
                                            {% endif %}
                                        </label>
                                    </td>
								</tr>
								<tr>
									<th><div>新密码：</div></th>
									<td>{{ form.render('password2') }}</td>
									<td>
										<label class="hide" style="color: red;display:block">
                                            {% if password2_err is defined %}
                                                {{ password2_err }}
                                            {% endif %}
                                        </label>
									</td>
								</tr>
								<tr>
								    <th><div>新密码(确认)：</div></th>
								    <td>{{ form.render('password3') }}</td>
								    <td>
                                        <label class="hide" style="color: red;display:block">
                                            {% if password3_err is defined %}
                                                {{ password3_err }}
                                            {% endif %}
                                        </label>
								    </td>
								</tr>
							</tbody>
						</table>
								<p class="btn_login" style="text-align:center;">
                                     {{ submit_button("提交", "class": "btn btn-primary","id":"btn_sub") }}
                                </p>
                    </div>
					</form>
					{% endif %}
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