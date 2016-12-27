
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
				<li>忘记密码</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
					<div id="join_signup">
					    <br>
						<h1>忘记密码</h1>
                        <br>
						<form name="entryForm" action="{{ site_url }}session/forgetPassword" method="post" >
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
                                 {{ submit_button("确认", "class": "btn btn-primary", "id":"btn_sub") }}
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