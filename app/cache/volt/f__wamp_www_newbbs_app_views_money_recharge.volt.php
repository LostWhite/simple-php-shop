<?= $this->getContent() ?>

<?php
$domain="";
$url = BASE_DIR."/public/";
$site_url = "http://localhost/newbbs/";

//$site_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/";
$hs_view_include_path =APP_DIR. "/views/include/";
?>

<script type="text/javascript">
$(function(){
    var status = document.getElementById('status').value;
    status--;
    $("#menu_li li").removeClass("tab_on");
    $("#menu_li li:eq("+status+")").addClass("tab_on");
});
function doRefill(name){
$("#"+name).submit();
}

</script>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">

			<div id="main_inner">

			<div id="top_detail">
					<div id="top_detail_inner">
						<h3 class="p_per">购买算卦币：</h3>

                        <div class="recharge_title">
                            <span>购买/提现算卦币</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>50 算卦币 = 50 元人民币 = 10 美元</span>
                        </div>

                        <!--tab开始-->
                        <input type="hidden" name="status" id="status" value="<?= $status ?>">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="<?= $site_url ?>money/recharge/1">快捷支付</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/recharge/2">海外支付</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/recharge/3">其他支付</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/recharge/4">付费指南</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="<?= $site_url ?>money/recharge/5">提现算卦币</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0">
                        <ol id="recordList">
                        <div class="p-totle1">

                            <?php if ($status == 1) { ?>
                                
                            <form id="form-refill1"  method="post"<?= $this->url->get('money/recharge') ?> name="form-refill1">
                            <div class="recharge_num">
                                <span><b>您要充值金额：</b></span>&nbsp;
                                <input type="text" name="amount" style="height:32px; line-height:30px; border:1px solid #c8c8c8; width:140px; padding:0px 5px;" maxlength=8 /> &nbsp;
                                <span><b>算卦币</b></span> &nbsp; 注：充值的金额必须是整数,在线客服
                                <img  style="CURSOR: pointer;DISPLAY: inline-block; VERTICAL-ALIGN: middle" onclick="javascript:window.open('http://wpa.qq.com/msgrd?v=3&uin=2532006145&site=qq&menu=yes', '_blank', 'height=502, width=544,toolbar=no,scrollbars=no,menubar=no,status=no');"
                                src=""  border="0" alt="点击这里和客服聊天">。
                            </div>

                            <div class="recharge_quick">
                                <div class="recharge_quick_01"><b>快捷支付：</b>无需网银！快速完成付款！</div>
                                <div style="padding-left:40px;" class="recharge_quick_02">
                                    <table width="100%" border="0">
                                        <tr>
                                            <td><input name="zhifu" type="radio" value="alipay" checked="checked" /></td>
                                            <td><img src="<?= $site_url ?>img/bank/zhifu_icon01.jpg" alt="支付宝" /></td>
                                            <td><input name="zhifu" type="radio" value="tenpay" /></td>
                                            <td><img src="<?= $site_url ?>img/bank/zhifu_icon02.jpg" alt="财付通" /></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="recharge_send">
                                <a href="javascript:doRefill('form-refill1');">立即付款</a>
                            </div>
                            </form>
                            <?php } elseif ($status == 2) { ?>
                                <div class="recharge_num">
    <span><b>您要充值金额：</b></span>&nbsp;
    <input type="text" name="amount" style="height:32px; line-height:30px; border:1px solid #c8c8c8; width:140px; padding:0px 5px;" maxlength=8 /> &nbsp;
    <span><b>算卦币</b></span> &nbsp; 注：充值的金额必须是整数，且不少于 50 算卦币。
</div>

<div class="recharge_banking">
    <div class="recharge_banking_01">
        <p><b>PAYPAL</b></p>
        <p>接受 VISA、MasterCard、American Express、Discover、Bank e-check、Paypal，<br />
        推荐使用，直接充值。</p>
    </div>
    <div class="recharge_banking_02" style="text-align:left;">
        <table width="250" border="0" style="margin-left:25px; height:60px;">
            <tr>
                <td><input name="zhifu" type="radio" value="paypal" checked="checked" /></td>
                <td><a href="javascript:doRefill('form-refill2');"> <img class="foreign" src="/zaixianyuce/images/pay_img01.jpg" style="width:142px;height:24px;" alt=" " /></a></td>
            </tr>
        </table>
    </div>
</div>
                            <?php } elseif ($status == 3) { ?>
                            <?php } elseif ($status == 4) { ?>
                            <?php } elseif ($status == 5) { ?>
                                <form id="form-refund" action="" method="POST">
    <div style="margin-top:40px;" class="user_teacher_content01">
        <table width="100%" border="0">
            <tr>
                <td width="20%" style="color:#787878; text-align:right; font-size:14px; vertical-align:top;"> <span>可提现的算卦币：&nbsp;</span></td>
                <td width="20%"> <span><b>0</b></span></td>
                <td width="60%" style="color:#787878; text-align:left; font-size:14px; vertical-align:top;"> <span>注：若信用卡或充值卡充值需要提现则扣除30%的手续费。</span></td>
            </tr>

            <tr>
                <td width="20%" style="color:#787878; text-align:right; font-size:14px; vertical-align:top;"> <span>您要提现的算卦币：&nbsp;</span></td>
                <td width="20%"><input type="text" name="amount" style="height:32px; line-height:30px; border:1px solid #c8c8c8; width:100px; padding:0px 5px;" /></td>
                <td width="60%" style="color:#787878; text-align:left; font-size:14px; vertical-align:top;"> &nbsp; <span>注：提现的算卦币必须是整数，且不少于 100 算卦币。</span></td>
            </tr>
            <tr>
                <td width="20%" style="color:#787878; text-align:right; font-size:14px; vertical-align:top;"> <span>本人姓名：&nbsp;</span></td>
                <td width="20%"><input type="text" name="realname" style="height:32px; line-height:30px; border:1px solid #c8c8c8; width:100px; padding:0px 5px;" /></td>
                <td width="60%" style="color:#787878; text-align:left; font-size:14px; vertical-align:top;"> &nbsp; <span><font size="12"></font></span></td>
            </tr>
            <tr>
                <td width="20%" style="color:#787878; text-align:right; font-size:14px; vertical-align:top;"> <span>本人支付宝账户：&nbsp;</span></td>
                <td width="20%"><input type="text" name="alipay" style="height:32px; line-height:30px; border:1px solid #c8c8c8; width:100px; padding:0px 5px;" /></td>
                <td width="60%" style="color:#787878; text-align:left; font-size:14px; vertical-align:top;"> &nbsp; <span><font size="12"></font></span></td>
            </tr>

            <tr>
                <td width="20%" style="height:75px; color:#787878; text-align:right;"></td>
                <td width="20%"><div class="zc-bcon clearfix"><div class="btn5 fl mr-5"><a href="">提现算卦币</a></div></div></td>
                <td width="60%" style="color:#787878; text-align:left; font-size:14px; vertical-align:top;"><span>&nbsp;</span></td>
            </tr>
        </table>
    </div>
</form>

                            <?php } ?>

                        </div>
                        </ol>
                        </div>
                        </div>

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