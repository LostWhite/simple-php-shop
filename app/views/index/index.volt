{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<body>
	<div id="wrapper">
		<noscript>这个网站javascript必须设置为ON</noscript>

		<section id="main">
			<div id="main_inner">
				<div id="top_detail">
				    <div style="">
				        <a href="{{ site_url }}"><img src="{{ site_url }}siteimg/toplogo.jpg"  />
				    </div>
					<div id="item_info">
						
						{% include "include/bannertop.inc" %}
					</div>
					<!--?php include $hs_view_include_path.'listeval.inc';?-->
					{% include "include/listeval.inc" %}
					<div class="service_title">
					    预测师一览
					</div>
					<div id="detail_inner">
						<ul>

							{% for service in uservices %}
                                <li>
                                    <div>
                                        <a href="{{ site_url }}online/tab1/{{ service['ps_user_id'] }}">
                                        <div class="services_part1" style="background: url({{ site_url }}img/per/<?php 
                                        	$service['img']=BASE_DIR . "/public/img/per/".$service['ps_user_id']."/m.jpg";
   														 if( file_exists( $service['img']) ) 
														{ 
    													$service['img']=$service['ps_user_id']."/m.jpg";
															} 
														else 
														{
  														  $service['img']="default_user.jpg";
														}
                                        	 ?>{{ service['img'] }}) no-repeat;">
                                            <i class='p-icon' style="background: url({{ site_url }}public/css/images/p_icon.gif) no-repeat;"></i>
                                        </div>
                                        </a>
                                        <div class="services_part2">
                                            <span style="display: inline-block;">{{ service['user_name'] }}</span><span style="display: inline-block;height: 16px;line-height: 16px;width: 33px;background: url({{ site_url }}public/css/images/{{ service['onlineimg'] }}) no-repeat;">&nbsp;</span><br>
                                            <br>
                                            <span>总好评率：{{ service['eval_percent'] }}</span><br>
                                            <span>月好评率：{{ service['eval_percent_mon'] }}</span><br>
                                            <span>月成交指数：{{ service['sale_point_mon'] }}</span>
                                        </div>
                                    </div>
                                    <div class="services_part3">
                                    <p><a href="{{ site_url }}online/tab1/{{ service['ps_user_id'] }}">{{ service['user_content'] }}……</a></p>
                                    <a href="{{ site_url }}chat/index?sid={{ service['ps_user_id'] }}"><span class="index_chat">试测交谈</span></a>
                                    <a href="{{ site_url }}online/tab3/{{ service['ps_user_id'] }}"><span>用户评价</span></a>
                                    <a href="{{ site_url }}message/information?status=2&ps_user_name={{ service['user_name'] }}"><span>直接留言</span></a>
                                    </div>
                                </li>
                                <!--
                                <li>
                                    <a href="{{ site_url }}online/tab1" title="月刊デンタルダイヤモンド 2013年8月号">
                                   <table><tr><td> <div class="book_img"><img src="{{ site_url }}img/default_m.jpg" style="height:130px;" /></div>
                                   </td><td>aaa
                                   </td></tr></table>
                                    <br>
                                    <em>{{ service.user_content }}</em>
                                    </a>
                                    <br>
                                    &nbsp;<input type="button" value="试测交谈" class="btn btn-primary" />
                                    &nbsp;<input type="button" value="用户评价" class="btn btn-primary" />
                                    &nbsp;<input type="button" value="直接留言" class="btn btn-primary" />
                                    &nbsp;<span style="display: inline-block;height: 16px;line-height: 16px;width: 33px;background: url({{ site_url }}public/css/images/online.jpg) no-repeat;">&nbsp;</span>
                                </li>
                                -->
                            {% endfor %}
						</ul>
					</div>
					<div class="page_index">
					<br>
					<hr>
                        <!--?php include $hs_view_include_path.'page.inc';?-->
                        {% if end != 1 %}
                            {% include "include/page.inc" %}
                        {% endif %}
					</div>
				</div>
			</div>
		</section>
		<section id="r_clm">
			
			{% include "include/menu.volt" %}
		</section>
		<br clear="all">
	</div>

	<!--?php include $hs_view_include_path.'footer.inc';?-->
	{% include "include/footer.volt" %}

    <!-- 下载测试用form-->
    <form id="downloadform" method="post"></form>
</body>
        <script>
/*
        $(document).ready(function(){
            $.ajax({
                type: "post",
                url: "{{site_url}}chat/rooms",
                dataType: "text",
                success: function (data) {
                    var rooms_list=jQuery.parseJSON(data);
                    var selObj = $("#chat_contents");
                    console.info(rooms_list.length);
                    for(i=0;i<rooms_list.length;i++){
                        if(rooms_list[i].indexOf("room_")>=0){

                            var value=rooms_list[i];
                            var text=rooms_list[i];
                            selObj.append("<option value='"+value+"'>"+text+"</option>");
                        }
                    }
                    //console.info(ccc);
                    //$("input#showTime").val(data[0].demoData);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
            $("#chat_contents").change(function(){

                $("#downloadform").attr("action","{{site_url}}chat/backup?room_id="+$("#chat_contents").val());
                console.info($("#downloadform"));
                $("#downloadform").submit();
            });
        });
*/
        </script>
