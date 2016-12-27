
<?= $this->getContent() ?>
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
					<?= $this->tag->form([$site_url . 'user/icon', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
					<div class="center-scaffold">
						<table class="pro_apply">
							<tbody>
								<tr>
									<th><div>当前头像：</div></th>
									<td class="td_img"><div>

									<img src="<?= $site_url ?>/img/per/<?= $this->auth->getIdentity()['id'] ?>/m.jpg" onerror="javascript:this.src='<?= $site_url ?>/img/per/default_user.jpg';"  height="140"/>
									<!--img src="<?= $image_url ?>" height="140"/--></div></td>
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
                                            <?php if (isset($file_err)) { ?>
                                                <?= $file_err ?>
                                            <?php } ?>
                                        </label>
						<p>上传图片尺寸150x150，支持gif，jpg，png；大小不能大于100k</p></div>

                                <p class="btn_login" style="text-align:center;">
                                     <?= $this->tag->submitButton(['提交', 'class' => 'btn btn-primary', 'id' => 'btn_sub']) ?>
                                </p>
                    </div>
					</form>
					</div>

				</div>


              <?php include $hs_view_include_path.'listleft.inc';?>

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