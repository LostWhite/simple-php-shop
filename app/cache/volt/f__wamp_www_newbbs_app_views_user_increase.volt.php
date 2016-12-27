
<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<script type="text/javascript">
$(function(){
    var site_url = document.getElementById('site_url').value;
    $("#addr_id1").change(function(){
        var s = this.value;
        $.getJSON(site_url+"user/addr_id1?t_c_id="+s,function(data){
            $('#addr_id2').children().remove();
            var data = eval(data);
            $('#addr_id2').append($('<option value="0">请选择</option>'));
            for(var key in data)
            {
                //selectValue.options.add(new Option(data[key],key));
                $('#addr_id2').append($('<option value="'+key+'">'+data[key]+'</option>'));
            }
        });

        /*
        $.ajax({
            type: "GET",
            url: "<?= $site_url ?>user/addr_id1",
            dataType: "json",
            data: { "t_c_id":s },
            success: function(data){
                alert(data);
                objSelect.options.length = 0;
            },
            error: function (){
                alert('fail');
            }
        });
        */
    });

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
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main"><?php if ((empty($logged_in))) { ?>
                       <script>window.location.href="{$site_url}session/login"</script>
                 <?php } ?>
<div id="main_inner">

			<div id="top_detail">
					<div id="top_detail_inner">
						<p class="p_per">完善个人信息:</p>
						<input type="hidden" name="site_url" id="site_url" value="<?= $site_url ?>">
					<?= $this->tag->form([$site_url . 'user/increase', 'method' => 'post', 'enctype' => 'multipart/form-data', 'style' => 'width:100%']) ?>
					<div class="center-scaffold">
						<table class="pro_apply">
							<tbody>
                                <tr>
									<th><div>用户名：</div></th>
									<td><?= $user->login_id ?></td>
                                    <td>
										<!--label class="hide" style="color: red;display:block">
                                            <?php if (isset($login_id_err)) { ?>
                                                <?= $login_id_err ?>
                                            <?php } ?>
                                        </label-->
									</td>
								</tr>
                                <tr>
								    <th><div>性別：</div></th>
                                    <td>
                                        <?php if ($user->sex == '女') { ?>
                                        <input type="radio" name="sex" value="1" class="radio" checked />&nbsp;女性 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="sex" value="2" class="radio" />&nbsp;男性
                                        <?php } else { ?>
                                        <input type="radio" name="sex" value="1" class="radio" />&nbsp;女性 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="sex" value="2" class="radio" checked />&nbsp;男性
                                        <?php } ?>
								    </td>
							    </tr>
								<tr>
									<th><div>电子邮箱 <img style="height:10px;width:25px;" src="<?= $site_url ?>img/must.jpg">：</div></th>
									<td><?= $form->render('email', ['value' => $user->email]) ?></td>
                                    <td>
										<label class="hide" style="color: red;display:block">
                                            <?php if (isset($email_err)) { ?>
                                                <?= $email_err ?>
                                            <?php } ?>
                                        </label>
									</td>
								</tr>

								<tr>
								    <th><div>姓：</div></th>
                                    <td><?= $form->render('name1', ['value' => $user->user_name1, 'style' => 'width:100px']) ?></td>
                                    <th><div>名：</div></th>
                                    <td><?= $form->render('name2', ['value' => $user->user_name2, 'style' => 'width:100px']) ?></td>
								</tr>
                                <tr>
								    <th><div>电话号码：</div></th>
                                    <td><?= $form->render('tel_number', ['value' => $user->tel_number]) ?></td>
							    </tr>
								<tr>
									<th><div>手机号码：</div></th>
									<td><?= $form->render('mobile_number', ['value' => $user->mobile_number]) ?></td>
                                    <td>
										<label class="hide" style="color: red;display:block">
                                            <?php if (isset($mobile_number_err)) { ?>
                                                <?= $mobile_number_err ?>
                                            <?php } ?>
                                        </label>
									</td>
								</tr>
								<tr>
									<th><div>QQ号码：</div></th>
									<td><?= $form->render('qqno', ['value' => $user->qqno]) ?></td>
                                    <td>
                                        <label class="hide" style="color: red;display:block">
                                            <?php if (isset($qqno_err)) { ?>
                                            <?= $qqno_err ?>
                                            <?php } ?>
                                        </label>
                                    </td>
								</tr>
								<tr>
									<th><div>出生年月：</div></th>
									<td><?= $form->render('birth', ['value' => $user->birth]) ?></td>
								</tr>
								<tr>
									<th><div>邮编号码：</div></th>
									<td><?= $form->render('zipcode', ['value' => $user->zipcode]) ?></td>
								</tr>
								<tr>
								    <th><div>国家：</div></th>
								    <td><select name="addr_id1" selectedIndex=37 id="addr_id1">
								        <option value="0">请选择</option>
								        <?php foreach ($countries as $country) { ?>
                                            <option value=<?= $country->t_id ?>><?= $country->t_c_name ?></option>
                                        <?php } ?>
                                    </select></td>
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
								    <th><div>详细地址：</div></th>
                                    <td><?= $form->render('address5', ['value' => $user->address5, 'style' => 'width:500px']) ?></td>
								</tr>


							</tbody>
						</table>
								<p class="btn_login" style="text-align:center;">
                                    <?= $this->tag->submitButton(['确定', 'class' => 'btn btn-primary', 'id' => 'btn_sub']) ?>
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