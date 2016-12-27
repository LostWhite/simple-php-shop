{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<link rel="stylesheet" type="text/css" href="{{ site_url }}public/css/usbbb.css">

<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">
			<div id="top_detail">
            					<div id="top_detail_inner">
            						<h3 class="p_per">预测师资料:</h3>
            						<div id="porphet_menu">
                                        <div class="per_img">
                                            <div><img src="<?php echo $site_url; ?>/img/test01_0.jpg" style="height:130px;" /></div>
                                            <div class = "per_img_mes">{{ service.user_name }}</div>
                                        </div>
                                        <div id="per_mes">
                                            <span class="span_th">用户名:</span><span class="span_td">{{ logged_in }}</span>
                                            <span class="span_th">预测师名:</span><span class="span_td">{{ service.user_name }}</span><br><br>
                                            <span class="span_th">邮箱:</span><span class="span_td">{{ user.email }}</span>
                                            <span class="span_th">账户号:</span><span class="span_td">{{ service.ps_user_id }}</span><br><br>
                                            <span class="span_th">真实姓名:</span><span class="span_td">{{ service.real_name }}</span>
                                            <span class="span_th">性别:</span><span class="span_td">{{ user.sex }}</span><br><br>
                                            <span class="span_th">手机:</span><span class="span_td">{{ user.mobile_number }}</span>
                                            <span class="span_th">qq:</span><span class="span_td">{{ user.qqno }}</span><br><br>
                                            <span class="span_th">联系地址:</span><span class="span_td">{{ user.address5 }}</span>
                                            <span class="span_th">申请时间:</span><span class="span_td">user_name</span>
                                        </div>
            						</div>
            						<h3>预测师简介：</h3>
            						<div id="prophet_cont">
            							<br/>
            							{{ service.user_content }}
            						</div>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <h3>详细介绍：</h3>
            						<div id="prophet_cont">
            							<br/>
            							{{ service.expert_content }}
            						</div>

            					</div>
            </div>


              <?php include $hs_view_include_path.'/prophet/listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>