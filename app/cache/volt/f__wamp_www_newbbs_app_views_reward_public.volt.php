
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper" style="background-color:#ffffff;">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>
        <script type="text/javascript" src="<?php echo $site_url; ?>/public/js/nicEdit.js"></script>


		<section id="main">
			<ol id="pan">
				<li><a href="<?= $site_url ?>">返回首页</a></li>
				<li>赏金求测</li>
			</ol>
                <!--form method="post"  autocomplete="off"-->
                <?= $this->tag->form([$site_url . 'reward/public', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
                    

                        <div><font size=3><b>预测任务</b></font></div>
                        <div >
                            <!-- <span for="id">ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>-->
                             <!--   <span> <?= $this->auth->getIdentity()['id'] ?><span>-->
                      <!--  <?= $form->render('user_id', ['value' => $this->auth->getIdentity()['id'], 'disabled' => 'true']) ?>-->
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value=<?= $this->auth->getIdentity()['id'] ?>>
                   <div class="center-scaffold">
				   <table class="pro_apply">
				   <tbody>
						<tr>
                            <th><div>任务名</div></th>
							<td><?= $form->render('task_name') ?></td>
                        </tr>
						
						
						<tr>
                            <th><div>大分类</div></th>
							<td> <?= $form->render('big_catagory') ?></td>
                        </tr>
						
						<tr>
                            <th><div>小分类</div></th>
							<td>  <?= $form->render('small_catagory') ?></td>
                        </tr>
						
						<tr>
                            <th><div>赏金类型</div></th>
							<td>  <?= $form->render('pay_type') ?></td>
                        </tr>
						
						<tr>
                            <th><div>赏金</div></th>
							<td> <?= $form->render('pay_reward') ?></td>
                        </tr>
						
						<tr>
                            <th><div>期限</div></th>
							<td>  <?= $form->render('time_limit') ?></td>
                        </tr>
						<tr>
                            <th><div>备注</div></th>
							<td>  <?= $form->render('other_remark') ?></td>
                        </tr>
						<tr>
                            <th><div>任务介绍</div></th>
							<td>  <?= $form->render('task_remark') ?></td>
                        </tr>
						<tr>
                            <th><div>提供材料</div></th>
							<td> <?= $form->render('fileName') ?></td><td> <?= $form->render('fileName2') ?></td><td> <?= $form->render('fileName3') ?></td>
                        </tr>
						
					
                        <tr>
						<td>
						<span style="padding-left: 400px;"><?= $this->tag->submitButton(['保存', 'class' => 'btn btn-primary']) ?></span>
						</td>
                       </tr>
				    <tbody>
					</table>
                    </div>
                    

                </form>

                <script>
                $(document).ready(function(){

                    $('#big_catagory').bind('change',function(){

                        var pid = $('#big_catagory').val();
                         if(pid>0)
                         {
                             $.ajax( {
                                url:'<?php echo $site_url; ?>/reward/smallClass/'+pid,// 跳转到 action

                                type:'post',
                                cache:false,
                                dataType:'text',
                                success:function(data) {
                                   // alert(data);
                                   $('#small_catagory').empty();
                                   $('#small_catagory').html(data);
                                 },
                                 error : function() {
                                      alert("异常！");
                                 }
                            });
                        }
                    });

                    $(".btn1").click(function(){
                    $("p").slideToggle();
                    });
                });
                </script>
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
</html>