
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main"><?php if ((empty($logged_in))) { ?>
                     <script>window.location.href="<?= $site_url ?>session/login"</script>
                <?php } ?>
			<div id="main_inner">
			<div id="top_detail">
			    <div id="top_detail_inner">
                    <?php if (isset($flg)) { ?>
                        <p class="p_per">修改成功</p>
                    <?php } else { ?>
				    <p class="p_per">修改密码:</p>
					<?= $this->tag->form([$site_url . 'user/modipass', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
					<div class="center-scaffold">
						<table class="pro_apply">
							<tbody>
								<tr>
									<th><div>电子邮箱：</div></th>
									<td><label id="email" class="hide" style="display:block"><?= $user->email ?></label><em></em></td>
								</tr>
								<tr>
									<th><div>用户名：</div></th>
									<td><label id="name" class="hide" style="display:block"><?= $user->login_id ?></label><em></em></td>
								</tr>
								<tr>
									<th><div>旧密码：</div></th>
								    <td><?= $form->render('password1') ?></td>
									<td>
                                        <label id="username_succeed" class="hide" style="display:none">4-20位字符，支持数字字母下划线</label>
                                        <label class="hide" style="color: red;display:block">
                                            <?php if (isset($password1_err)) { ?>
                                                <?= $password1_err ?>
                                            <?php } ?>
                                        </label>
                                    </td>
								</tr>
								<tr>
									<th><div>新密码：</div></th>
									<td><?= $form->render('password2') ?></td>
									<td>
										<label class="hide" style="color: red;display:block">
                                            <?php if (isset($password2_err)) { ?>
                                                <?= $password2_err ?>
                                            <?php } ?>
                                        </label>
									</td>
								</tr>
								<tr>
								    <th><div>新密码(确认)：</div></th>
								    <td><?= $form->render('password3') ?></td>
								    <td>
                                        <label class="hide" style="color: red;display:block">
                                            <?php if (isset($password3_err)) { ?>
                                                <?= $password3_err ?>
                                            <?php } ?>
                                        </label>
								    </td>
								</tr>
							</tbody>
						</table>
								<p class="btn_login" style="text-align:center;">
                                     <?= $this->tag->submitButton(['提交', 'class' => 'btn btn-primary', 'id' => 'btn_sub']) ?>
                                </p>
                    </div>
					</form>
					<?php } ?>
			    </div>
		    </div>


              <?php include $hs_view_include_path.'listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			
			<h4>Menu</h4>
			<ul id="info">
				<li><a href="<?= $site_url ?>user">个 人 中 心<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
                    <li><a href="<?= $site_url ?>prophet/index">预 测 师 管 理<span></span></a></li>
                    <li><a href="<?= $site_url ?>reward/search">赏 金 求 测 一 览<span></span></a></li>
                <?php }else{?>
                    <li><a href="<?= $site_url ?>user/apply">申 请 预 测 师<span></span></a></li>
                <?php }?>
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

			<ol id="lclm_banners">
				<li><a href="javascript:;" title="banner"><img src="<?php echo $site_url; ?>/img/file/1.gif" alt=""/></a></li>
				<li><a href="javascript:;" title="banner"><img src="<?php echo $site_url; ?>/img/file/2.gif" alt=""/></a></li>
				<li><a href="javascript:;" title="banner"><img src="<?php echo $site_url; ?>/img/file/3.gif" alt=""/></a></li>
				<li><a href="javascript:;" title="banner"><img src="<?php echo $site_url; ?>/img/file/4.gif" alt=""/></a></li>
				<li><a href="javascript:;" title="banner"><img src="<?php echo $site_url; ?>/img/file/5.gif" alt=""/></a></li>
			</ol>
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>