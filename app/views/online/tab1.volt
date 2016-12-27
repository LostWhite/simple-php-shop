
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<script type="text/javascript">
$(function(){
    $("#buy_ser").click(function(){
        $.getJSON(site_url+"transaction/buy?ps_price=11",function(data){
            alert(1);
        });
    });
})

function buy(price, ps_site_id, ps_id, ps_user_id){
    $.MsgBox.Confirm("系统消息", "您确定要购买该服务吗？", function () {
        var site_url = document.getElementById('site_url').value;
        $.get(site_url+"transaction/buy?ps_price="+price+"&ps_site_id="+ps_site_id+"&ps_id="+ps_id+"&ps_user_id="+ps_user_id,function(data){
         
          //  var data = eval(data);
            if(data == "nomoney"){
                $.MsgBox.Confirm("系统消息",  "余额不足，是否进入充值页面？", function () {
                    window.location.href=site_url+"money/recharge/1";
                });
            }else if(data ==  "isself"){
                $.MsgBox.Alert("系统消息",  "您不能购买自己的服务。");
            }else if(data ==  "haveorder"){
                $.MsgBox.Alert("系统消息",  "您已购买了一项服务，无法继续购买，完成这项服务。");
            }else if(data =="error"){
                $.MsgBox.Alert("系统消息",  "系统错误。");
            }else{
                //$.MsgBox.Confirm("系统消息",  "购买成功！是否进入聊天室？", function () {
                    window.location.href=site_url+"chat/index?room_id="+ps_user_id+"_"+{{ user_id }}+"&order=" +data;
                //});
            }
        });
    });
}
</script>
<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
		<ol id="pan">
			<li><a href="{{ site_url }}">返回首页</a></li>
						<li>预测师简介</li>
		</ol>
			<div id="main_inner">
				<div id="top_detail">
					<div id="item_info">
                        <input type="hidden" name="site_url" id="site_url" value="{{ site_url }}">
						<div id="title">
							<h1>预测师简介和服务页面</h1>
							<h2></h2>
						</div>

						<div id="item_image">
							<p><a href="" target="_blank" rel="lightbox"><img src="{{ site_url }}/img/per/{{ service.ps_user_id }}/b.jpg" onerror="javascript:this.src='{{ site_url }}img/per/default_user.jpg'"></a></p>
							<!-- <a href="" target="_blank" rel="lightbox">画像を拡大</a> -->
						</div>


						<div id="prophesy_detail">
							<span class = "pro_name">{{ service.user_name }}</span><br>
							<span class = "pro_1">总成交量：<em class = "pro_2">{{ service.sale_total }}</em></span>
							<span class = "pro_1">总好评率：<em class = "pro_2">{{ service.eval_percent }}</em></span>
							<span class = "pro_1">成交指数：<em class = "pro_2">{{ service.sale_point }}</em></span>
							<br />
							<br />
							<div id="pro_2">
								简介：{{ service.user_content }}
							</div>
							<br />
							<br />
							<span class ="pro_a1">
							    {% if orderid >0 %}
							        <a href="{{ site_url }}chat/index?room_id={{ service.ps_user_id }}_{{ user_id }}&orderid={{orderid}}">订单聊天</a>
							    {% else %}
							        <a href="javascript:online_chat({{ service.ps_user_id }},{% if user_id is defined %}{{ user_id }}{% else %}000{% endif %})">试测聊天</a>
							    {% endif %}
							</span>
							<span class ="pro_a2" ><a href="javascript:collection({{ service.ps_user_id }},{% if user_id is defined %}{{ user_id }}{% else %}000{% endif %})">收藏预测师</a></span>
						</div>
					</div>

					<!--div class="shop_menu">
							<span id="s_menu"><a href="{{ site_url }}online/tab1/{{ service.ps_user_id }}">服务项目</a></span>
							<span id="s_menu"><a href="{{ site_url }}online/tab2/{{ service.ps_user_id }}">详细介绍</a></span>
							<span id="s_menu"><a class="a_3" href="{{ site_url }}online/tab3/{{ service.ps_user_id }}">评价记录</a></span>
							<span><a class="a_4" href="{{ site_url }}online/tab4/{{ service.ps_user_id }}">预测师随笔</a></span>
					</div-->

                        <!--tab开始-->
						<input type="hidden" name="status" id="status" value="{{ status }}">
                        <div class="tab3">
                        <div class="tab3Tag" id="menu0">
                            <ul id="menu_li">
                        		<li class="tab_on"><a href="{{ site_url }}online/tab1/{{ service.ps_user_id }}">服务项目</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}online/tab2/{{ service.ps_user_id }}">详细介绍</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}online/tab3/{{ service.ps_user_id }}">评价记录</a><span class="tab-bn"></span></li>
                        		<li class=""><a href="{{ site_url }}online/tab4/{{ service.ps_user_id }}">预测师随笔</a><span class="tab-bn"></span></li>
                            </ul>
                        </div>
                        <div class="tab3Body" id="main0" style="width:100%;min-height:800px">
                        <ol id="recordList">
                        <div class="a-totle1">
                        {% for service in services %}
                            <div class="per_ser">
                                <div class="ser_name">{{ service['ps_name'] }}</div>
                                <div class="ser_content">
                                    {{ service['t_ps_content'] }}
                                </div>
                                <div class="ser_price">
                                    <em>定价：{{ service['ps_price'] }}</em>
                                    <div class="ser_buy">
                                        {% if user_id is defined %}
                                            <a href="javascript:buy({{ service['ps_price'] }},{{ service['ps_site_id'] }},{{ service['ps_id'] }},{{ service['ps_user_id'] }})">购买服务</a>
                                        {% else %}
                                            <a href="javascript:login_check('{{ site_url }}','transaction_buy')">购买服务</a>
                                        {% endif %}
                                    </div>
                                </div>
                            </div>
					    {% endfor %}

                        </div>
                        </ol>
                        </div>
                        </div>



					{% if end != 1 %}
					    <?php include $hs_view_include_path.'page.inc';?>
                    {% endif %}
				</div>
			</div>
		</section>

		<section id="r_clm">

			{% include "include/menu.volt" %}
			<!--
<ul id="ranking">
<li class="rank_no1">
<p id="rank_1">第1位</p>
<a href="" title=""><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_1.png" /></a>
<h5><a href="/item/618">Air Care Diffuser （エアケア ディフューザー）</a></h5>
<em>定価：15,750円（税込）</em>
</li>

<li>
<p id="rank_2">第2位</p>
<a href="" title=""><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_1.png" /></a>
<h5><a href="/item/617">Steam Humidifier</a></h5>
<em>定価：13,230円（税込）</em>
</li>

<li>
<p id="rank_3">第3位</p>
<a href="" title=""><img src="<?php echo $site_url; ?>/imgr/shop_img/test01_1.png" /></a>
<h5><a href="/item/614">ロボット掃除機 kobold ( コーボルト ) VR100</a></h5>
<em>定価：82,688円（税込）</em>
</li>

<li>
   第4位
<h5><a href="/item/611">SBSes7353</a></h5>
</li>


</ul>  

			<ol id="lclm_banners">
				<li><a href="javascript:;" title="banner"><img src="../pc/assets/images/banners/1.gif" alt=""/></a></li>
			</ol>  -->
		</section>
		<br clear="all">

	</div>

	<?php include $hs_view_include_path.'footer.inc';?>
</body>