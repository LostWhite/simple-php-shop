
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>免费注册</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
					<div id="join_signup">
					    <br>
						<h1>免费注册</h1>
                        <br>
						<form name="entryForm" action="{{ site_url }}session/signup" method="post" >
							 <div class="center-scaffold">
								<table class="pro_apply">
									<tbody>
										<tr>
											<th><div>电子邮箱：</div></th>
											<td class="must">必填</td>
											<td>{{ form.render('email') }}
											    <!--input type="text" name="email" value="" size="40" onfocus="o_focus('email')" onblur="o_blur('email')"><em></em--></td>
											<td>
											<label id="email_succeed" class="hide" style="display:none">数字字母下划线组成</label>
                            				<label id="email_err" class="hide" style="color: red;display:block">
                                                {% if email_err is defined %}
                                                    {{ email_err }}
                                                {% endif %}
                            				</label>
                            				</td>
										</tr>

										<tr>
											<th><div>用户ID：</div></th>
											<td class="must">必填</td>
											<td>{{ form.render('username') }}
												<!--input type="text" name="username" value="" size="40" onfocus="o_focus('name')" onblur="o_blur('name')"-->
											<td>
											<label id="name_succeed" class="hide" style="display:none">4-20位字符，支持数字字母下划线</label>
											<label id="name_err" class="hide" style="color: red;display:block">
											    {% if username_err is defined %}
                                                    {{ username_err }}
                                                {% endif %}
                            				</label>
											</td>
										</tr>
										<tr>
											<th><div>密码：</div></th>
											<td class="must">必填</td>
											<td>{{ form.render('password') }}
												<!--input type="password" name="password" value="" size="40" maxlength="15" onfocus="o_focus('password1')" onblur="o_blur('password1')"><br-->
											</td>
											<td>
											<label id="password1_succeed" class="hide" style="display:none">6-20位字符，支持数字字母下划线，不建议使用纯数字或纯字母</label>
											<label id="password1_err" class="hide" style="color: red;display:block">
											    {% if password_err is defined %}
                                                    {{ password_err }}
                                                {% endif %}
                            				</label>
											</td>
										</tr>
										<tr>
											<th><div>密码（确认）：</div></th>
											<td class="must">必填</td>
											<td>{{ form.render('confirmPassword') }}
												<!--input type="password" name="password2" value="" size="40" maxlength="15" onfocus="o_focus('password2')" onblur="o_blur('password2')"><br>
											    <em></em-->
											</td>
											<td>
											<label id="password2_succeed" class="hide" style="display:none">请确认密码</label>
											<label id="password2_err" class="hide" style="color: red;display:block">
											    {% if confirmPassword_err is defined %}
                                                    {{ confirmPassword_err }}
                                                {% endif %}
                            				</label>
											</td>
										</tr>
                                        <tr>
											<th><div>验证码：</div></th>
											<td class="must">必填</td>
											<td>
												<input type="text" name="code" value="" style="width:80px;" size="10" maxlength="15">
												<img style="height:35px;width:80px;" title="点击刷新" src="{{ site_url }}code" align="absbottom" onclick="this.src='{{ site_url }}code?'+Math.random();"></img>
											</td>
											<td>
											<label id="code_err" class="hide" style="color: red;display:block">
											    {% if code_err is defined %}
                                                    {{ code_err }}
                                                {% endif %}
                            				</label>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

                                <input type="hidden" name="site_id" id="site_id" value="1">
                                <input type="hidden" name="reg_route" id="reg_route" value="101"><!-- 注册方法 -->

							<dl id="join_member_check">
								<p class="btn_login" style="text-align:center;">
                                 {{ submit_button("注册", "class": "btn btn-primary", "id":"btn_sub") }}
                                </p>
							</dl>
							<br clear="all">
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