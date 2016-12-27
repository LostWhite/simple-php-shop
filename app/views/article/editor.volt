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
        editor = K.create('textarea[name="sub_title"]', {
		        resizeType : 1,
			    allowPreviewEmoticons : false,
			    allowImageUpload : false,
			    items : [
				    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				    'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	    });
        editor = K.create('textarea[name="page_text"]', {
		        resizeType : 1,
			    allowPreviewEmoticons : false,
			    allowImageUpload : false,
			    items : [
				    'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				    'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				    'insertunorderedlist', '|', 'emoticons', 'image', 'link']
	    });
    });

    $(function(){
        var flg =  document.getElementById('flg').value;
        if(flg != 0){
            $.MsgBox.Alert("系统消息", flg);
        }
    })

</script>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>预测师随笔</li>
			</ol>
			<div id="main_inner">
				<div id="top_detail">
<h2 id="title_co_kyouhan">预测师随笔</h2>
<div id="co_kyouhan_table">
        {% if flg is defined %}
            <input type="hidden" name="flg" id="flg" value="{{ flg }}">
        {% else %}
            <input type="hidden" name="flg" id="flg" value="0">
        {% endif %}

        {{ form(site_url~'article/particle',  'method': 'post', 'enctype': 'multipart/form-data') }}

            文章标题：{{ form.render('title',['value':note.title,'style':'width:600px;height:30px;']) }}
            <label class="hide" style="color: red;display:block">
                {% if title_err is defined %}
                    {{ title_err }}
                {% endif %}
            </label>
            <br>

            副标题：{{ form.render('sub_title',['value':note.sub_title,'style':'width:700px;height:30px;visibility:hidden;']) }}

            文章内容：{{ form.render('page_text',['value':note.page_text,'style':'width:800px;height:400px;visibility:hidden;']) }}
			<label class="hide" style="color: red;display:block">
                {% if page_text_err is defined %}
                    {{ page_text_err }}
                {% endif %}
            </label>

            <p class="btn_login" style="text-align:center;">
            {{ submit_button("提交", "class": "btn btn-primary") }}
            </p>
		</form>

</div>

</div>
			</div>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}

		</section>
		<br clear="all">

	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>