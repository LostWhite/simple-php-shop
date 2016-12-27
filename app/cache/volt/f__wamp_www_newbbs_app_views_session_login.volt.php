
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<?php
$domain="";
$url = BASE_DIR."/public/";
$site_url = "http://localhost/newbbs/";

//$site_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/";
$hs_view_include_path =APP_DIR. "/views/include/";
?>
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
				<li><a href="<?= $site_url ?>">返回首页</a></li>
				<li>登录</li>
			</ol>
            <div id="main_inner">
            				<div id="top_detail">
            					<div id="mypage_login">
            						<h1>登录页</h1>
  <?php if (isset($frommsg)) { ?>
<div  style="color: yellow;width:800px;height:25px;margin:0px auto 0px auto;	padding:1px 0  0 0;background: #0000ff;">&nbsp;&nbsp;<?= $frommsg ?></div>
<?php } ?>
            						<div id="login_form">
            						    <input type="hidden" name="site_url" id="site_url" value="<?= $site_url ?>">
            							<!--form name="form1" action="<?= $site_url ?>session/login"  method="post"  enctype="multipart/form-data"-->
            							<?= $this->tag->form([$site_url . 'session/login', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
            								<table>
            									<tbody>
            										<tr>
            											<th class="th1">
            												<em>用户ID</em><br>
            											</th>
            											<td><?= $form->render('name', ['class' => 'username']) ?><br />
                                        				<label id="username_err" class="hide" style="color: red;display:block">
                                                            <?php if (isset($name_err)) { ?>
                                                                <?= $name_err ?>
                                                            <?php } ?>
                                        				</label>
                                        				</td>
            										</tr>
            										<tr>
            											<th class="th1">
            												<em>密码</em><br>
            											</th>
            											<td><?= $form->render('password') ?><br />
                                        				<label id="password_err" class="hide" style="color: red;display:block">
                                                            <?php if (isset($password_err)) { ?>
                                                                <?= $password_err ?>
                                                            <?php } ?>
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
                                                    <?= $this->tag->submitButton(['登录', 'class' => 'btn btn-primary', 'id' => 'btn_sub']) ?>
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
