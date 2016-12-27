
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<script>

                var debug = 0;
                var lastmod = {{lastmod}};
                var login = 1;
                var loading = false;
                var room = "{{room}}";
                var first = 1;
                var dis = "{{least}}";
                var lastword;
                var color='';
                var touchs = {{touchs}};
                var dotouch = true;
                var maxdisplay ={{maxdisplay}};
                var nowdisplay = 1;
                var sending = 0;
                var loaded_lines = [];
                var editing = 0;

                var site_url = "<?php echo $site_url;?>";
                function encode(s)
                {
                	return  (encodeURIComponent)? encodeURIComponent(s):s;
                }

               // _$('chat_user').onfocus = setOnFocus;
                _$('input_size').onfocus = setOnFocus;
                function setOnFocus()
                {
                	window.editing = 1;
                }
                function setOnBlur()
                {
                	window.editing = 0;
                }

                var keep_ajax;
                setInterval("keeponline()",{{touchs}}*2000);

                document.body.onbeforeunload =  quitroom;

                setInterval("load_word()",(debug)?8000:2000);
                //setInterval(" load_word()",(debug)?60000:10000);

                var load_word_ajax;

                //下载完成后的处理函数
                function load_word_change()
                {
                	if (load_word_ajax.readyState == 4)
                	{
                		if (load_word_ajax.status != 200)
                		{
                			load_word_error();
                			return;
                		}
                		window.loading = false;
                		var body = _$('div_contents');

                		try {
                          //  console.info(load_word_ajax.responseText);
                			//if (debug) alert(load_word_ajax.responseText);
                			eval("var arr = "+load_word_ajax.responseText);
                		} catch(e)
                		{
                			//alert('Error 101\nJSON syntax error!\n\n'+load_word_ajax.responseText);
                			return;
                		}
                		if (!arr || !arr.lastmod || typeof(arr.lastmod) == "undefined" )
                		{
                			return;
                		}

                		var html = "";
                		var line = arr.lines;
                		var i = 0;
                		var v1 = 0;
                		var div_online = _$('div_online');
                		if (window.first)
                		{
                           // console.info(2342);
                			//body.innerHTML = "";
                			window.first = false;
                		}

                		if (arr.onlines)
                		{
                        //    console.info(arr);
                			_$('div_online').innerHTML = "";
                			for(var i=0;i<arr.onlines.length;i++) addonline(arr.onlines[i]);
                		}
                		var hasText = 0;
                		for(var i=0;i<line.length;i++)
                		{

                			var linekey = line[i].word.substring(line[i].word.length-20,line[i].word.length)+line[i].time;
                			if (window.loaded_lines[linekey] === true)
                			{
                				if (debug) alert("jump:"+linekey);
                				continue;
                			}
                			hasText = 1
                			var div1 = document.createElement("div");
                			window.nowdisplay ++;
                			if (window.nowdisplay > window.maxdisplay) window.nowdisplay = 1;
                			if (_$("contentitem"+window.nowdisplay)) body.removeChild(_$("contentitem"+window.nowdisplay));
                			div1.className = "content";
                			div1.id = "contentitem"+window.nowdisplay;
                            //设置显示内容 disflg
                            if(line[i].word.indexOf("加入对谈")==-1){

                                    if(line[i].userid=='{{curUser_name}}'){

                                        div1.innerHTML ="
                                            <div class='chatContent'>
                                                <div class='contentPlace'>
                                                    <div class='cloudText'>
                                                        <div class='cloudContent'>
                                                            <p style='white-space:pre-wrap'>"+ line[i].word +"</p>
                                                        </div>
                                                        <img class='arrowRight' src='{{ site_url }}public/img/bubble_green_guid1dbc1c.png'>
                                                        <div class='cloudArrow'>
                                                        </div>
                                                    </div>
                                                    <img class='avatar' src={{teacher_head_pic}} onerror='reLoadImg(this)' title='zuo'>
                                                </div>
                                            </div>";
                                        /*
                                        <div style='float:right;width:40px'><img src={{teacher_head_pic}} /></div><div class='demo clearfix fr'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
                                        */
                                    }else if(line[i].userid=="system"){
                                        div1.innerHTML ="<div style='float:left;width:40px'></div><div class='demo clearfix' style='text-align:center;color:orange;font-size:14px'>"+line[i].word+" <span class='time'>("+line[i].time+")</div>";
                                    }else{
                                        div1.innerHTML ="<div style='float:left;width:40px'><img src={{user_head_pic}} /></div><div class='demo clearfix'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
                                    }
                            }
                            else{
                                div1.innerHTML ="<div style='float:left;width:40px'></div><div class='demo clearfix'>"+line[i].word+" <span class='time'>("+line[i].time+")</div>";
                            }
                            $('#chatContent').appendChild(div1);
                			//body.appendChild(div1);

                			window.loaded_lines[linekey] = true;
                			//body.scrollTop = 655350;
                			v1 = 1;
                		}

                		if (v1)
                		{
                			window.focus();
                			document.body.focus();
                            //更新时间重新设置（过期时间）
                			window.lastmod = arr.lastmod;
                			if(debug) alert("lastmod = "+arr.lastmod + " \nwindow.lastmod="+window.lastmod);
                			if (_$('chat_word').disabled == false && window.editing != 1)
                			{
                				_$('chat_word').focus();
                			}
                		}
                		if (hasText ==1){
                        	body.scrollTop = 655350;
                        }
                	}
                }


                function touchme()
                {
                	window.dotouch = true;
                	setTimeout("touchme()",{{touchs}}*1000);
                }


                touchme();


                var send_ajax;



                function eval_ajax(){
                	evaluate_ajax = createAJAX();
                    evaluate_ajax.open('POST','/chat/eval',1);
                    evaluate_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    evaluate_ajax.onreadystatechange = function ()
                	{
                		if (evaluate_ajax.readyState == 4 && evaluate_ajax.status == 200)
                		{
                    		if(evaluate_ajax.responseText=="ok"){
                	            alert("评价成功");
                                _$('apDiv1').style.display = "none";
                		    }
                		}
                	}

                	// 获取评价分数
                    var chkObjs = document.getElementsByName("rad");
                    var radioValue;
                    for(var i=0;i<chkObjs.length;i++){
                        if(chkObjs[i].checked){
                            radioValue = chkObjs[i].value;
                            break;
                        }
                    }
                    evaluate_ajax.send("action=keep&sorce="+radioValue +"&content="+_$('eval_content').value+"&task_id="+{{task_id}});
                 }
                 function pay_ajax(){
                  	payment_ajax = createAJAX();
                     payment_ajax.open('POST','/chat/pay',1);
                     payment_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                     payment_ajax.onreadystatechange = function ()
                  	{
                  		if (payment_ajax.readyState == 4 && payment_ajax.status == 200)
                  		{
                      		if(payment_ajax.responseText=="ok"){
                  	            alert("支付成功");
                                _$('apDiv2').style.display = "none";
                  		    }
                            else{
                                alert(payment_ajax.responseText);
                                _$('apDiv2').style.display = "none";
                            }
                  		}
                  	}
                     payment_ajax.send("action=keep&task_id={{task_id}}&pay_to_user_id={{pay_to_user_id}}&pay_reward="+_$('pay_reward').value);
                   }
</script>

<body>
	<div id="wrapper">

		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>
		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>预测师聊天室</li>
			</ol>

            <link href="{{ site_url }}public/css/add/chat.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo $site_url; ?>public/js/ajaxfileupload.js"></script>
            <script src="<?php echo $site_url; ?>public/js/chatRoom.js"></script>
                <script>
                </script>
                </head>
                <body >
                <center>
                    <div class="chatContainer" style="min-height: 720px;">
                        <div class="chatTitle">
                            <span class="titleLeft">
                                客户名：{{logged_in}}
                            </span>
                            <span class="titleRight">
                                预测师：{{logged_teacher}}
                            </span>
                        </div>
                        <div class="timeFlg">
                            <span class="timeCenter">
                                订单日期：{{order_date}}
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

                            </div>
                            <div class="chatSend">
                                <!--textarea type="text" id="textInput" class="chatInput">
                                </textarea-->
                                <textarea class="chatInput" id='chat_word' onFocus="if (this.value == '{{lang.hereyourwords}}') this.value=''; window.editing=0; "
                                                                                             onkeydown="return check_send(event);">{{lang["hereyourwords"]}}</Textarea>
                                <a href="" onClick="chat_send();_$('chat_word').style.height=20;" onFocus="this.blur();"><div class="send">发送</div></a>
                            </div>
                        </div>
                    </div>
                </center>
		</section>

		<section id="r_clm">
			<?php include $hs_view_include_path.'menu.inc';?>

		</section>
		<br clear="all">
	</div>

		<?php include $hs_view_include_path.'footer.inc';?>
</body>
