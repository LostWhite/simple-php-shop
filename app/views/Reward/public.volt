
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper" style="background-color:#ffffff;">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>
        <script type="text/javascript" src="<?php echo $site_url; ?>/public/js/nicEdit.js"></script>


		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>赏金求测</li>
			</ol>
                <!--form method="post"  autocomplete="off"-->
                {{ form(site_url~'reward/public',  'method': 'post', 'enctype': 'multipart/form-data') }}
                    

                        <div><font size=3><b>预测任务</b></font></div>
                        <div >
                            <!-- <span for="id">ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>-->
                             <!--   <span> {{auth.getIdentity()['id'] }}<span>-->
                      <!--  {{ form.render("user_id",["value":auth.getIdentity()['id'],"disabled":"true"]) }}-->
                        </div>
                        <input type="hidden" id="user_id" name="user_id" value={{auth.getIdentity()['id']}}>
                   <div class="center-scaffold">
				   <table class="pro_apply">
				   <tbody>
						<tr>
                            <th><div>任务名</div></th>
							<td>{{ form.render("task_name") }}</td>
                        </tr>
						
						
						<tr>
                            <th><div>大分类</div></th>
							<td> {{ form.render("big_catagory") }}</td>
                        </tr>
						
						<tr>
                            <th><div>小分类</div></th>
							<td>  {{ form.render("small_catagory") }}</td>
                        </tr>
						
						<tr>
                            <th><div>赏金类型</div></th>
							<td>  {{ form.render("pay_type") }}</td>
                        </tr>
						
						<tr>
                            <th><div>赏金</div></th>
							<td> {{ form.render("pay_reward") }}</td>
                        </tr>
						
						<tr>
                            <th><div>期限</div></th>
							<td>  {{ form.render("time_limit") }}</td>
                        </tr>
						<tr>
                            <th><div>备注</div></th>
							<td>  {{ form.render("other_remark") }}</td>
                        </tr>
						<tr>
                            <th><div>任务介绍</div></th>
							<td>  {{ form.render("task_remark") }}</td>
                        </tr>
						<tr>
                            <th><div>提供材料</div></th>
							<td> {{ form.render("fileName") }}</td><td> {{ form.render("fileName2") }}</td><td> {{ form.render("fileName3") }}</td>
                        </tr>
						
					
                        <tr>
						<td>
						<span style="padding-left: 400px;">{{ submit_button("保存", "class": "btn btn-primary") }}</span>
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
			{% include "include/menu.volt" %}

		</section>
		<br clear="all">
	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>
</html>