
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
{% include "../config/link.php" %}
<script type="text/javascript">
    $(function(){
        var site_url = document.getElementById('site_url').value;
        $(".login_forget #btn_sub").click(function(){
            window.location.href = site_url+"session/forgetPassword";
        });
    });
</script>
<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>登录</li>
			</ol>
            <div id="main_inner">
            				<div id="top_detail">
            					<div id="mypage_login">
            						<h1>登录页</h1>
  {% if frommsg is defined %}
<div  style="color: yellow;width:800px;height:25px;margin:0px auto 0px auto;	padding:1px 0  0 0;background: #0000ff;">&nbsp;&nbsp;{{ frommsg }}</div>
{% endif %}
            						<div id="login_form">
            						    <input type="hidden" name="site_url" id="site_url" value="{{ site_url }}">
            							<!--form name="form1" action="{{ site_url }}session/login"  method="post"  enctype="multipart/form-data"-->
            							{{ form(site_url~'session/login',  'method': 'post', 'enctype': 'multipart/form-data') }}
            								<table>
            									<tbody>
            										<tr>
            											<th class="th1">
            												<em>用户ID</em><br>
            											</th>
            											<td>{{ form.render('name',["class":"username"]) }}<br />
                                        				<label id="username_err" class="hide" style="color: red;display:block">
                                                            {% if name_err is defined %}
                                                                {{ name_err }}
                                                            {% endif %}
                                        				</label>
                                        				</td>
            										</tr>
            										<tr>
            											<th class="th1">
            												<em>密码</em><br>
            											</th>
            											<td>{{ form.render('password') }}<br />
                                        				<label id="password_err" class="hide" style="color: red;display:block">
                                                            {% if password_err is defined %}
                                                                {{ password_err }}
                                                            {% endif %}
                                        				</label>
            											</td>
            										</tr>
            									</tbody>
            								</table>
                                            <input type="hidden" name="site_id" id="site_id" value="1">

                                            <div class="login_tail">
                                                <div class="login_pd">
                                                    <span>
                                                    <input type="checkbox" name="cookie" id="cookie" value="1">
                                                    <label for="cookie" id="for-cookie"> 记住密码</label>
                                                    </span>
                                                </div>
                                                <div class="login_btn">
                                                    {{ submit_button("登录", "class": "btn btn-primary","id":"btn_sub") }}
                                                </div>
                                                <div class="login_forget">
                                                    <input type="button" value="忘记密码" class="btn btn-primary" id="btn_sub">
                                                </div>
            								</div>
            							</form>

            						</div>

            						<div class="mypage_detail">

            						</div>
            						<div class="mypage_detail_privacy">

            						</div>
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
