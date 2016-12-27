
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
						<h3 class="p_per">个人资料:</h3>
						<div id="main_image">
							<div class="per_img">
							    <a href="{{ site_url }}user/icon"><div><img src="{{ site_url }}/img/per/{{ user_id }}/m.jpg" onerror="javascript:this.src='{{ site_url }}/img/per/default_user.jpg';" style="height:130px;" /></div></a>
							    <div class = "per_img_mes">
							        <a href="{{ site_url }}user/increase">修改资料</a>
							        <!--input type="button" value="修改资料" class="btn btn-primary" id="btn_sub"-->
							    </div>
							</div>
							<div id="per_mes"  >
								
								<table>

								<tr>
								<th class=""><div>用户名:</div></th>
								<td class="">{{ user_message.login_id }}</td>
								<th class=""><div>邮箱:</div></th>
								<td class="">{{ user_message.email }}</td>
								</tr>
								
						
								
								
								<tr>
								<th class=""><div>账户余额:</div></th>
								<td class="">11111</td>
								<th class=""><div>姓名:</div></th>
								<td class="">{{ user_message.user_name }}</td>
								</tr>
								<tr>
								<th class="thdisp">性别:</th>
								<td class="">{{ user_message.sex }}</td>
								<th class="thdisp">出生年月:</th>
								<td class="">{{ user_message.birth }}</td>
								</tr>
								<tr>
								<th class="thdisp">手机:</th>
								<td class="">{{ user_message.mobile_number }}</td>
								<th class="thdisp">电话:</th>
								<td class="">{{ user_message.tel_number }}</td>
								</tr>
								
								<tr>
								<th class="thdisp">交易次数:</th>
								<td class="">11111</td>
								<th class="thdisp">联系地址:</th>
								<td class="">{{ user_message.address5 }}</td>
								</tr>
							
							

								</table>
						
							</div>
						</div>
						<h3>预测师记录：</h3>
						<div id="per_pro">
						    {% for service in services %}
                                <div class="per_img">
                                    <div class="per_img_true">
                                        <img src="{{ site_url }}/img/per/{{ service['pay_to_user_id'] }}/m.jpg" style="height:100px;width:100px;"  onerror="javascript:this.src='{{ site_url }}img/per/default_user.jpg'" />
                                        <h2>{{ service['user_name'] }}</h2>
                                        <em><a style="color: red" href="{{ site_url }}online/tab1/{{ service['pay_to_user_id'] }}">查看详细</a></em>
                                    </div>
                                </div>
							{% endfor %}
						</div>
						<h3>预测师推荐：</h3>
						<ul id="newRelease">
                            {% for prophet in prophets %}
                                <div class="per_img">
                                    <div class="per_img_true">
                                        <img src="{{ site_url }}/img/per/{{ prophet['ps_user_id'] }}/m.jpg" style="height:100px;width:100px;"  onerror="javascript:this.src='{{ site_url }}img/per/default_user.jpg'"/>
                                        <h2>{{ prophet['user_name'] }}</h2>
                                        <em><a style="color: red" href="{{ site_url }}online/tab1/{{ prophet['ps_user_id'] }}">查看详细</a></em>
                                    </div>
                                </div>
							{% endfor %}
					</div>
</div>


              <?php include $hs_view_include_path.'listleft.inc';?>

			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}
		</section>

		<br clear="all">
	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>