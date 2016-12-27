
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="<?= $site_url ?>">返回首页</a></li>
				<li>免费注册</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
					<div id="join_signup">
					    <br>
						<h1>免费注册</h1>
                        <br>
						<form name="entryForm" action="<?= $site_url ?>session/signup" method="post" >
							 <div class="center-scaffold">
								<table class="pro_apply">
									<tbody>
										<tr>
											<th><div>电子邮箱：</div></th>
											<td class="must">必填</td>
											<td><?= $form->render('email') ?>
											    <!--input type="text" name="email" value="" size="40" onfocus="o_focus('email')" onblur="o_blur('email')"><em></em--></td>
											<td>
											<label id="email_succeed" class="hide" style="display:none">数字字母下划线组成</label>
                            				<label id="email_err" class="hide" style="color: red;display:block">
                                                <?php if (isset($email_err)) { ?>
                                                    <?= $email_err ?>
                                                <?php } ?>
                            				</label>
                            				</td>
										</tr>

										<tr>
											<th><div>用户ID：</div></th>
											<td class="must">必填</td>
											<td><?= $form->render('username') ?>
												<!--input type="text" name="username" value="" size="40" onfocus="o_focus('name')" onblur="o_blur('name')"-->
											<td>
											<label id="name_succeed" class="hide" style="display:none">4-20位字符，支持数字字母下划线</label>
											<label id="name_err" class="hide" style="color: red;display:block">
											    <?php if (isset($username_err)) { ?>
                                                    <?= $username_err ?>
                                                <?php } ?>
                            				</label>
											</td>
										</tr>
										<tr>
											<th><div>密码：</div></th>
											<td class="must">必填</td>
											<td><?= $form->render('password') ?>
												<!--input type="password" name="password" value="" size="40" maxlength="15" onfocus="o_focus('password1')" onblur="o_blur('password1')"><br-->
											</td>
											<td>
											<label id="password1_succeed" class="hide" style="display:none">6-20位字符，支持数字字母下划线，不建议使用纯数字或纯字母</label>
											<label id="password1_err" class="hide" style="color: red;display:block">
											    <?php if (isset($password_err)) { ?>
                                                    <?= $password_err ?>
                                                <?php } ?>
                            				</label>
											</td>
										</tr>
										<tr>
											<th><div>密码（确认）：</div></th>
											<td class="must">必填</td>
											<td><?= $form->render('confirmPassword') ?>
												<!--input type="password" name="password2" value="" size="40" maxlength="15" onfocus="o_focus('password2')" onblur="o_blur('password2')"><br>
											    <em></em-->
											</td>
											<td>
											<label id="password2_succeed" class="hide" style="display:none">请确认密码</label>
											<label id="password2_err" class="hide" style="color: red;display:block">
											    <?php if (isset($confirmPassword_err)) { ?>
                                                    <?= $confirmPassword_err ?>
                                                <?php } ?>
                            				</label>
											</td>
										</tr>
                                        <tr>
											<th><div>验证码：</div></th>
											<td class="must">必填</td>
											<td>
												<input type="text" name="code" value="" style="width:80px;" size="10" maxlength="15">
												<img style="height:35px;width:80px;" title="点击刷新" src="<?= $site_url ?>code" align="absbottom" onclick="this.src='<?= $site_url ?>code?'+Math.random();"></img>
											</td>
											<td>
											<label id="code_err" class="hide" style="color: red;display:block">
											    <?php if (isset($code_err)) { ?>
                                                    <?= $code_err ?>
                                                <?php } ?>
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
                                 <?= $this->tag->submitButton(['注册', 'class' => 'btn btn-primary', 'id' => 'btn_sub']) ?>
                                </p>
							</dl>
							<br clear="all">
						</form>
					</div>
				</div>
			</div>
		</section>

		<section id="r_clm">
			
			<h4>Menu1</h4>
			<ul id="info">
				<li><a href="<?= $site_url ?>user">个 人 中 心<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
                    <li><a href="<?= $site_url ?>prophet/index">预 测 师 管 理<span></span></a></li>
                     <li><a href="<?= $site_url ?>chat/index">交 谈 管 理 <span></span></a></li>
                <?php }else{?>
                    <li><a href="<?= $site_url ?>user/apply">申 请 预 测 师<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>reward/search">赏 金 求 测 大 厅<span></span></a></li>
				<li><a href="<?= $site_url ?>money/recharge/1">购 买 算 卦 币<span></span></a></li>
                <li><a href="<?= $site_url ?>reward/public">发 布 赏 金 求 测<span></span></a></li>
                <li><a href="">百 家 争 鸣<span></span></a></li>
                <li><a href="<?= $site_url ?>order/orders">我 的 订 单<span></span></a></li>
                <!--li><a href="<?= $site_url ?>chat/teacher">试 测 验 证<span></span></a></li-->
				<li><a href="<?= $site_url ?>prophet/browse">预 测 师 随 笔<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
				    <li><a href="<?= $site_url ?>article/particle">写 随 笔<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>message/information?status=1">意 见 反 馈<span></span></a></li>
			</ul>

	<!-- JiaThis Button BEGIN -->
<div class="jiathis_style_24x24">
	
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_weixin"></a>
	
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->
		</section>
		<br clear="all">
	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>