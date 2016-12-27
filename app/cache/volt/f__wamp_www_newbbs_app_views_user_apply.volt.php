
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<script type="text/javascript">
$(function(){
    var site_url = document.getElementById('site_url').value;
    $("#addr_id2").change(function(){
        var s = this.value;
        $.getJSON(site_url+"user/addr_id2?t_r_id="+s,function(data){
            $('#addr_id3').children().remove();
            var data = eval(data);
            $('#addr_id3').append($('<option value="0">请选择</option>'));
            for(var key in data)
            {
                $('#addr_id3').append($('<option value="'+key+'">'+data[key]+'</option>'));
            }
        });
    });

    $("#addr_id3").change(function(){
        //var objSelect = document.getElementById('addr_id3');
        //var s = objSelect.options[objSelect.selectedIndex].value;
        var s = this.value;
        $.getJSON(site_url+"user/addr_id3?t_s_id="+s,function(data){
            //var selectValue = document.getElementById("addr_id4");
            //selectValue.options.length = 0;
            $('#addr_id4').children().remove();
            var data = eval(data);
            $('#addr_id4').append($('<option value="0">请选择</option>'));
            for(var key in data)
            {
                $('#addr_id4').append($('<option value="'+key+'">'+data[key]+'</option>'));
            }
        });
    });
});
</script>
<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>



		<section id="main">
			<ol id="pan">
				<li><a href="<?= $site_url ?>">返回首页</a></li>
				<li>申请预测师</li>
			</ol>
            <input type="hidden" name="site_url" id="site_url" value="<?= $site_url ?>">
                <!--form method="post"  autocomplete="off"-->
                <?= $this->tag->form([$site_url . 'user/apply', 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
                <?php if (!$successFlg) { ?>
                    <div class="center-scaffold">
                        <div>
                            <br>
                            <div class="apply_title">请认真填写实名认证的相关信息，在申请提交的 24 小时内，预约管理员会与您联系，进行视频考核认证。</div>
                            <br>
                            <table class="pro_apply">
                                <tr>
                                     <th><div>姓:</div></th>
                                     <?php if ($showFlg) { ?>
                                         <td><?= $form->render('user_name1', ['value' => $user_mes->user_name1, 'style' => 'width:100px']) ?></td>
                                     <?php } else { ?>
                                        <td><?= $form->render('user_name1', ['value' => $user_mes->user_name1, 'disabled' => true, 'style' => 'width:100px']) ?></td>
                                     <?php } ?>

                                     <th><div>名:</div></th>
                                     <?php if ($showFlg) { ?>
                                         <td><?= $form->render('user_name2', ['value' => $user_mes->user_name2, 'style' => 'width:100px']) ?></td>
                                     <?php } else { ?>
                                        <td><?= $form->render('user_name2', ['value' => $user_mes->user_name2, 'disabled' => true, 'style' => 'width:100px']) ?></td>
                                     <?php } ?>
                                     <td><label>必需填写真实姓名</label></td>
                                </tr>

                                <tr>
                                     <th><div>身份证号码：</div></th>
                                     <?php if ($showFlg) { ?>
                                         <td><?= $form->render('identif_id') ?></td>
                                      <?php } else { ?>
                                         <td><?= $form->render('identif_id', ['value' => $teacherInfo->identif_id, 'disabled' => true]) ?></td>
                                      <?php } ?>
                                     <td><label for="id">身份证号码和影本将用于身份认证 </label></td>
                                </tr>

                                <tr>
                                     <th><div>身份证正面：</div></th>
                                      <?php if ($showFlg) { ?>
                                          <td><?= $form->render('identif_img_front') ?></td>
                                       <?php } else { ?>
                                          <td><?= $form->render('identif_img_front', ['disabled' => true]) ?></td>
                                       <?php } ?>
                                     <td><label for="id">支持文件格式：JPG，GIF，PNG </label></td>
                                </tr>

                                <tr>
                                     <th><div for="id">身份证反面：</div></th>
                                       <?php if ($showFlg) { ?>
                                           <td><?= $form->render('identif_img_back') ?></td>
                                        <?php } else { ?>
                                           <td><?= $form->render('identif_img_back', ['disabled' => true]) ?></td>
                                        <?php } ?>
                                     <td><label for="id">支持文件格式：JPG，GIF，PNG </label></td>
                                </tr>

                                <tr>
                                     <th><div for="id">手机：</div></th>
                                     <?php if ($showFlg) { ?>
                                         <td><?= $form->render('mobile_num', ['value' => $user_mes->mobile_number]) ?></td>
                                      <?php } else { ?>
                                        <td><?= $form->render('mobile_num', ['value' => $user_mes->mobile_number, 'disabled' => true]) ?></td>
                                      <?php } ?>
                                     <td><label for="id">手机方便我们联系</label></td>
                                </tr>

                                <tr>
                                     <th><div for="id">预测师简介：</div></th>
                                     <?php if ($showFlg) { ?>
                                        <td> <?= $form->render('expert_content') ?></td>
                                      <?php } else { ?>
                                        <td> <?= $form->render('expert_content', ['value' => $teacherInfo->expert_content, 'disabled' => true]) ?></td>
                                      <?php } ?>
                                     <td><label for="id">字数不得超过 500 字，不支持HTML标签 </label></td>
                                </tr>

                                <tr>
                                    <th><div>省自治区：</div></th>
                                    <td>
                                    <select name="addr_id2" id="addr_id2">
                                        <option value="0">请选择</option>
                                        <?php foreach ($addr2 as $addr) { ?>
                                            <option value=<?= $addr['t_r_id'] ?>><?= $addr['t_r_name'] ?></option>
                                        <?php } ?>
                                    </select></td>
                                </tr>
                                <tr>
                                    <th><div>城市：</div></th>
                                    <td>
                                    <select name="addr_id3" id="addr_id3">
                                        <option value="0">请选择</option>
                                        <?php foreach ($addr3 as $addr) { ?>
                                            <option value=<?= $addr['t_r_id'] . $addr['t_s_id'] ?>><?= $addr['t_s_name'] ?></option>
                                        <?php } ?>
                                    </select></td>
                                </tr>
                                <tr>
                                    <th><div>区县：</div></th>
                                    <td>
                                    <select name="addr_id4" id="addr_id4">
                                        <option value="0">请选择</option>
                                        <?php foreach ($addr4 as $addr) { ?>
                                            <option value=<?= $addr['t_id'] . $addr['t_q_id'] ?>><?= $addr['t_q_name'] ?></option>
                                        <?php } ?>
                                    </select></td>
                                </tr>

                                <tr>
                                     <th><div for="id">联系地址：</div></th>
                                     <?php if ($showFlg) { ?>
                                         <td><?= $form->render('address', ['value' => $user_mes->address5, 'style' => 'width:500px']) ?></td>
                                      <?php } else { ?>
                                        <td><?= $form->render('address', ['value' => $user_mes->address5, 'disabled' => true, 'style' => 'width:500px']) ?></td>
                                      <?php } ?>
                                     <td><label for="id">必需填写真实地址</label></td>
                                </tr>

                                <tr>
                                <td colspan="3" height="24px"> </td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <?php if ($showFlg) { ?>
                                        <td> <?= $this->tag->submitButton(['提交管理员审核', 'class' => 'btn btn-primary']) ?></td>
                                    <?php } else { ?>
                                        <td> <?= $this->tag->submitButton(['提交管理员审核', 'class' => 'btn btn-primary', 'disabled' => true]) ?></td>
                                    <?php } ?>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php } else { ?>
                    <div>
                    <br/>
                    <br/>
                    <h1 style="font-size:60px">恭喜您已经注册成为专家！</h1>
                    </div>
                <?php } ?>
                </form>
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
