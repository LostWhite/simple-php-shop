{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>
<script charset="utf-8" src="{{ site_url }}public/js/kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="{{ site_url }}public/js/kindeditor/zh_CN.js"></script>
<link rel="stylesheet" href="{{ site_url }}public/css/default/default.css" />
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="expert_content"]', {
		        resizeType : 1,
			    allowPreviewEmoticons : false,
			    allowImageUpload : false,
			    items : [
				    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				    'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	    });
    });
</script>
<body id="toppage">

	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<div id="main_inner">


			<div id="top_detail">

            	<div id="top_detail_inner">
            		<p class="p_per">完善个人信息:</p>
                        {% if flg is defined %}
                            {% if flg == 1 %}
            				    修改成功
            				{% elseif flg == 2 %}
            				    修改失败
            				{% endif %}
            			{% else %}
            			{{ form(site_url~'prophet/modify', 'method': 'post', 'class':'form_pro_add', 'enctype': 'multipart/form-data') }}
            			<div class="center-scaffold">
            			<table class="pro_apply">
            				<tbody>
								<tr>
									<th><div>用户名</div></th>
									<td>{{ form.render('login_id',['value':service.user_name]) }}
                                        <label class="hide" style="color: red;display:block">
                                            {% if login_id_err is defined %}
                                                {{ login_id_err }}
                                            {% endif %}
                                        </label>
									</td>
								</tr>

								<tr>
									<th><div>用户简介</div></th>
									<td>{{ form.render('user_content',['value':service.user_content,'style':'height:100px;width:250px']) }}</td>
								</tr>

                                <tr>
									<th><div>服务类型</div></th>
									<td>{{ form.render('user_type',['value':service.user_type]) }}</td>
								</tr>

                                <tr>
									<th><div>大项目分类</div></th>
									<td>{{ form.render('category_id',['value':service.category_id]) }}</td>
								</tr>

                                <tr>
									<th><div>擅长预测方式</div></th>
									
								</tr>
								<tr>
									
									<td>{{ form.render('expert_content',['value':service.expert_content,'style':'width:300px;height:400px;visibility:hidden;']) }}</td>
								</tr>

            				</tbody>
            			</table>
                            <div class="sub_btn" style="text-align:center;">
                                {{ submit_button("提交", "class": "btn btn-primary", "id":"btn_sub") }}
                            </div>
                     </div>
            		</form>
            		{% endif %}
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