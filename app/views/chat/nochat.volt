
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">

		<section id="main">
			<ol id="pan">
				<li>预测师聊天室</li>
			</ol>
            <link href="{{ site_url }}public/css/chat.css" rel="stylesheet" type="text/css" />
            <link href="{{ site_url }}public/css/add/chat.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo $site_url; ?>public/js/ajaxfileupload.js"></script>

                </head>
                <body >
                <center>
<div class="chatContainer" style="min-height: 720px;">
 <!-- 预测师状态，忙碌时显示，或预测师与自己对话时信息-->
     {% if roomstatus ==1  %}
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02" style="color:red">
                    预测师不能跟自己对话。
              </div>
              <div class="chat_not_03">
                    您可以试试<a href="{{ site_url }}">其他预测师</a>。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
    {% endif %}
     {% if roomstatus ==2  %}
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02">
                    预测师&nbsp;&nbsp;预测师名&nbsp;&nbsp;目前不在线，请稍后再来预测。
              </div>
              <div class="chat_not_03">
                    您可以<a href="">直接下单</a>后，等候预测师上线。试试<a href="{{ site_url }}">其他预测师</a>，或稍后再试。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
    {% endif %}
         {% if roomstatus ==3  %}
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02">
                    预测师&nbsp;&nbsp;预测师名&nbsp;&nbsp;目前忙碌中，请稍后再来预测。
              </div>
              <div class="chat_not_03">
                    您可以<a href="">直接下单</a>后，进入预测师排队等候。试试<a href="{{ site_url }}">其他预测师</a>，或稍后再试。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
        {% endif %}
     {% if roomstatus ==4 %}
              <div class="chat_not_01">
              </div>
              <div class="chat_not_02" style="color:red">
                    预测师拒绝跟你交谈。
              </div>
              <div class="chat_not_03">
                    您可以试试<a href="{{ site_url }}">其他预测师</a>。
              </div>
                <div class="chat_not_02" style="margin:50px 0;">
                    返回&nbsp;&nbsp;<a href="">预测师名的主页</a>。
              </div>
        {% endif %}

                </center>
		</section>

		<section id="r_clm">
			{% include "include/menu.volt" %}

		</section>
		<br clear="all">

	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>
