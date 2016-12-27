<?php
include(APP_DIR."/config/link.php");
?>
<link href="<?php echo $site_url; ?>public/css/add/chat.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
    function chat_send(){
        var div1 = document.createElement("div");
        div1.className = "chatContent";
        div1.innerHTML ="<div style='float:right'><div class='cloudText'><div class='cloudContent'><p style='white-space:pre-wrap'>11111</p></div><img class='arrowRight' src='{{ site_url }}public/img/bubble_green_guid1dbc1c.png'><div class='cloudArrow'></div></div><img class='avatar' src='' onerror='reLoadImg(this)' title='zuo'></div>";
        var testdiv = document.getElementById("chatContent");
        testdiv.appendChild(div1);
    }

 </script>

<div class="chatContainer" style="min-height: 720px;">

	<div class="chatTitle">
		<span class="titleLeft">
			客户名：111
		</span>
		<span class="titleRight">
			预测师：222
		</span>
	</div>
	<div class="timeFlg">
		<span class="timeCenter">
			9:32
		</span>
	</div>
	<!-- 聊天 -->
	<div id="chatContent" style="height: 600px;">
		<div class="chatContent">
			<div class="contentPlace">
				<div class="cloudText" un="cloud_1426766778" msgid="1426766778">
					<div class="cloudContent">
						<p style="white-space:pre-wrap">zai mezai me zai me zai me zai me zai me zai me zai me zai me zai me zai me v zai me zai me zai me zai me</p>
					</div>
					<img class="arrowRight" src="{{ site_url }}public/img/bubble_green_guid1dbc1c.png">
					<div class="cloudArrow ">
					</div>
				</div>
				<img class="avatar" src="" onerror="reLoadImg(this)" un="" title="zuo" click="showProfile" username="">
			</div>
		</div>

		<div class="chatContent">
			<div class="contentPlace">
				<div class="cloudText" un="cloud_1426766778" msgid="1426766778">
					<div class="cloudContent">
						<p style="white-space:pre-wrap">zai mezai me zai me zai me zai me zai me zai me zai me zai me zai me zai me v zai me zai me zai me zai me</p>
					</div>
					<img class="arrowRight" src="{{ site_url }}public/img/bubble_green_guid1dbc1c.png">
					<div class="cloudArrow ">
					</div>
				</div>
				<img class="avatar" src="" onerror="reLoadImg(this)" un="" title="zuo" click="showProfile" username="">
			</div>
		</div>

		<div class="chatContent-k">
			<div class="contentPlace-k">
				<img class="avatar" src="" onerror="reLoadImg(this)" un="" title="zuo" click="showProfile" username="">
				<div class="cloudText-k" un="cloud_1426766778" msgid="1426766778">
					<img class="arrowLeft" src="{{ site_url }}public/img/bubble_white_guid1dbc1c.png">
					<div class="cloudContent">
						<p style="white-space:pre-wrap">zai me</p>
					</div>
				</div>
			</div>
		</div>

		<div class="timeFlg">
			<span class="timeCenter">
				9:32
			</span>
		</div>

		<div class="chatContent-k">
			<div class="contentPlace-k">
				<img class="avatar" src="" onerror="reLoadImg(this)" un="" title="zuo" click="showProfile" username="">
				<div class="cloudText-k" un="cloud_1426766778" msgid="1426766778">
					<img class="arrowLeft" src="{{ site_url }}public/img/bubble_white_guid1dbc1c.png">
					<div class="cloudContent">
						<p style="white-space:pre-wrap">zai me</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- 发送内容 -->
	<div class="sendContent">
		<div class="sendLeft">
		     <a href="javascript:;" class="input" id="input">
              上传
              <input type="file" id="file">
             </a>
		</div>
		<div class="chatSend">
			<!--textarea type="text" id="textInput" class="chatInput">
			</textarea-->
			<textarea id="txtContent" class="chatInput"></Textarea>
			<a href="javascript:chat_send()" id="aaa"><div class="send">发送</div></a>
		</div>
	</div>
</div>
