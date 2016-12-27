
{{ content() }}
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
            url: "{{ site_url }}user/addr_id1",
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

		<section id="main">
                {%- if (logged_in is empty) %}
                       <script>window.location.href="{$site_url}session/login"</script>
                 {% endif %}
<div id="main_inner">

			<div id="top_detail">
					<div id="top_detail_inner">
						<p class="p_per">完善个人信息:</p>
						<input type="hidden" name="site_url" id="site_url" value="{{ site_url }}">
					{{ form(site_url~'user/increase', 'method': 'post', 'enctype': 'multipart/form-data', 'style':'width:100%') }}
					<div class="center-scaffold">
						<table class="pro_apply">
							<tbody>
                                <tr>
									<th><div>用户名：</div></th>
									<td>{{ user.login_id }}</td>
                                    <td>
										<!--label class="hide" style="color: red;display:block">
                                            {% if login_id_err is defined %}
                                                {{ login_id_err }}
                                            {% endif %}
                                        </label-->
									</td>
								</tr>
                                <tr>
								    <th><div>性別：</div></th>
                                    <td>
                                        {% if user.sex == '女' %}
                                        <input type="radio" name="sex" value="1" class="radio" checked />&nbsp;女性 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="sex" value="2" class="radio" />&nbsp;男性
                                        {% else %}
                                        <input type="radio" name="sex" value="1" class="radio" />&nbsp;女性 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="sex" value="2" class="radio" checked />&nbsp;男性
                                        {% endif %}
								    </td>
							    </tr>
								<tr>
									<th><div>电子邮箱 <img style="height:10px;width:25px;" src="{{ site_url }}img/must.jpg">：</div></th>
									<td>{{ form.render('email',['value':user.email]) }}</td>
                                    <td>
										<label class="hide" style="color: red;display:block">
                                            {% if email_err is defined %}
                                                {{ email_err }}
                                            {% endif %}
                                        </label>
									</td>
								</tr>

								<tr>
								    <th><div>姓：</div></th>
                                    <td>{{ form.render('name1',['value':user.user_name1,"style":"width:100px"]) }}</td>
                                    <th><div>名：</div></th>
                                    <td>{{ form.render('name2',['value':user.user_name2,"style":"width:100px"]) }}</td>
								</tr>
                                <tr>
								    <th><div>电话号码：</div></th>
                                    <td>{{ form.render('tel_number',['value':user.tel_number]) }}</td>
							    </tr>
								<tr>
									<th><div>手机号码：</div></th>
									<td>{{ form.render('mobile_number',['value':user.mobile_number]) }}</td>
                                    <td>
										<label class="hide" style="color: red;display:block">
                                            {% if mobile_number_err is defined %}
                                                {{ mobile_number_err }}
                                            {% endif %}
                                        </label>
									</td>
								</tr>
								<tr>
									<th><div>QQ号码：</div></th>
									<td>{{ form.render('qqno',['value':user.qqno]) }}</td>
                                    <td>
                                        <label class="hide" style="color: red;display:block">
                                            {% if qqno_err is defined %}
                                            {{ qqno_err }}
                                            {% endif %}
                                        </label>
                                    </td>
								</tr>
								<tr>
									<th><div>出生年月：</div></th>
									<td>{{ form.render('birth',['value':user.birth]) }}</td>
								</tr>
								<tr>
									<th><div>邮编号码：</div></th>
									<td>{{ form.render('zipcode',['value':user.zipcode]) }}</td>
								</tr>
								<tr>
								    <th><div>国家：</div></th>
								    <td><select name="addr_id1" selectedIndex=37 id="addr_id1">
								        <option value="0">请选择</option>
								        {% for country in countries %}
                                            <option value={{ country.t_id }}>{{ country.t_c_name }}</option>
                                        {% endfor %}
                                    </select></td>
								</tr>
								<tr>
                                    <th><div>省自治区：</div></th>
                                    <td>
                                    <select name="addr_id2" id="addr_id2">
                                        <option value="0">请选择</option>
                                        {% for addr in addr2 %}
                                            <option value={{ addr['t_r_id'] }}>{{ addr['t_r_name'] }}</option>
                                        {% endfor %}
                                    </select></td>
                                </tr>
                                <tr>
                                    <th><div>城市：</div></th>
                                    <td>
                                    <select name="addr_id3" id="addr_id3">
                                        <option value="0">请选择</option>
                                        {% for addr in addr3 %}
                                            <option value={{ addr['t_r_id']~addr['t_s_id'] }}>{{ addr['t_s_name'] }}</option>
                                        {% endfor %}
                                    </select></td>
                                </tr>
                                <tr>
                                    <th><div>区县：</div></th>
                                    <td>
                                    <select name="addr_id4" id="addr_id4">
                                        <option value="0">请选择</option>
                                        {% for addr in addr4 %}
                                            <option value={{ addr['t_id']~addr['t_q_id'] }}>{{ addr['t_q_name'] }}</option>
                                        {% endfor %}
                                    </select></td>
                                </tr>
								<tr>
								    <th><div>详细地址：</div></th>
                                    <td>{{ form.render('address5',['value':user.address5,"style":"width:500px"]) }}</td>
								</tr>


							</tbody>
						</table>
								<p class="btn_login" style="text-align:center;">
                                    {{ submit_button("确定", "class": "btn btn-primary", "id":"btn_sub") }}
                                </p>
                    </div>
					</form>
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