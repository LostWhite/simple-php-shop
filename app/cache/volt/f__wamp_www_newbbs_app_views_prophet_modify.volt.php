<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<script charset="utf-8" src="<?= $site_url ?>public/js/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="<?= $site_url ?>public/js/kindeditor/zh_CN.js"></script>
<link rel="stylesheet" href="<?= $site_url ?>public/css/default/default.css" />
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="expert_content"]', {
		        resizeType : 1,
			    allowPreviewEmoticons : false,
			    allowImageUpload : false,
			    items : [
				    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				    'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	    });
    });
</script>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">


			<div id="top_detail">

            	<div id="top_detail_inner">
            		<p class="p_per">完善个人信息:</p>
                        <?php if (isset($flg)) { ?>
                            <?php if ($flg == 1) { ?>
            				    修改成功
            				<?php } elseif ($flg == 2) { ?>
            				    修改失败
            				<?php } ?>
            			<?php } else { ?>
            			<?= $this->tag->form([$site_url . 'prophet/modify', 'method' => 'post', 'class' => 'form_pro_add', 'enctype' => 'multipart/form-data']) ?>
            			<div class="center-scaffold">
            			<table class="pro_apply">
            				<tbody>
								<tr>
									<th><div>用户名</div></th>
									<td><?= $form->render('login_id', ['value' => $service->user_name]) ?>
                                        <label class="hide" style="color: red;display:block">
                                            <?php if (isset($login_id_err)) { ?>
                                                <?= $login_id_err ?>
                                            <?php } ?>
                                        </label>
									</td>
								</tr>

								<tr>
									<th><div>用户简介</div></th>
									<td><?= $form->render('user_content', ['value' => $service->user_content, 'style' => 'height:100px;width:250px']) ?></td>
								</tr>

                                <tr>
									<th><div>服务类型</div></th>
									<td><?= $form->render('user_type', ['value' => $service->user_type]) ?></td>
								</tr>

                                <tr>
									<th><div>大项目分类</div></th>
									<td><?= $form->render('category_id', ['value' => $service->category_id]) ?></td>
								</tr>

                                <tr>
									<th><div>擅长预测方式</div></th>
									
								</tr>
								<tr>
									
									<td><?= $form->render('expert_content', ['value' => $service->expert_content, 'style' => 'width:300px;height:400px;visibility:hidden;']) ?></td>
								</tr>

            				</tbody>
            			</table>
                            <div class="sub_btn" style="text-align:center;">
                                <?= $this->tag->submitButton(['提交', 'class' => 'btn btn-primary', 'id' => 'btn_sub']) ?>
                            </div>
                     </div>
            		</form>
            		<?php } ?>
            	</div>

            </div>


              <?php include $hs_view_include_path.'/prophet/listleft.inc';?>

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