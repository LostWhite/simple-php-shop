
{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<body>
	<div id="wrapper">
		<noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>
		<section id="main">
			<ol id="pan">
				<li><a href="{{ site_url }}">返回首页</a></li>
				<li>预测师聊天室</li>
			</ol>
            <link href="<?php echo $site_url; ?>public/css/chat.css" rel="stylesheet" type="text/css" />
            <link href="{{ site_url }}public/css/add/chat.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo $site_url; ?>public/js/ajaxfileupload.js"></script>
            <script src="<?php echo $site_url; ?>public/js/chatRoom.js"></script>
                </head>
                <body >
                <center>

<div id ="chatmain" class="chatContainer" style="min-height: 720px;">

	<div class="chatTitle">
		<span class="titleLeft">
			客户名：{{name_user}}
		</span>
		<span class="titleRight">
			预测师：{{name_teacher}}
		</span>
		&nbsp;<input  type=button  onclick="overtalk()"  value = "结束预测">
		<input  type=button  onclick="load_word()"  value = "debug">

	</div>
	<div class="timeFlg">
		<span class="timeCenter">
			9:32
		</span>
	</div>
	<!-- 聊天 -->
	<div id="chatContent" style="height: 600px;">

    </div>
    	<div  style="height: 600px;">
aaa
    </div>
	<!-- 发送内容 -->
	<div class="sendContent">

		<div class="chatSend">
<div class="mydiv login" id='div_name' style='display:block;'>
                                <OBJECT id=dlgHelper CLASSID="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" WIDTH="0px" HEIGHT="0px"></OBJECT>
                                <input class="inputtext" style='display:none;width:50px;cursor:hand;10px;background-color:#000000;color:#ffffff;' id='div_color' onClick="pickColor()" value="#000000" onBlur="this.style.backgroundColor=this.value;window.color=this.value.replace('#','');" />
                                <input class="inputtext bg" type=text style='width:20px;display:none' maxlength=3 id='input_size' value='16' />
                                文件选择:<input type="file" id="upload_file" name="id="upload_file" maxlength=30 />&nbsp;<input type="button" onclick="ajaxFileUpload()" value="上传"></input>
                                </div>
			     <textarea type=text class="chatInput" rows=1 scrolling=no style='height:20px;overflow:hidden;width:400px;' id='chat_word' onFocus="if (this.value == '{{lang.hereyourwords}}') this.value=''; window.editing=0; "
                                 onkeydown="return check_send(event);" >{{lang["hereyourwords"]}}</textarea>
			<a href="javascript:chat_send()" id="aaa"><div class="send">发送</div></a>
		</div>
	</div>
</div>


                <div class=mydiv style='text-align:center; border:0px; background-color:transparent; font-size:25px; color:#ff8c05;'>预测师聊天室</div>
                <div class="mydiv login" id='div_description'>
                当前预测师:<input type=text class="bg" disabled size=8 id='chat_user' value="{{logged_teacher}}"  maxlength=30 />&nbsp;<input type=button value = "结束预测">



                </div>
                <div class="mydiv rooms" id='div_msg'>

                    <div class='contents bubble' style='height:350px;' id='div_contents'>
                            <div style="color:blue">欢迎您来到 人生预测平台，请稍待预测师回应…</div>
                            <div style="color:red">
                            ------------------------------------------------------------------<br/>
                            {% if taskTrue  %}
                            订单号&nbsp;&nbsp;&nbsp;&nbsp;：{{order_id}}<br/>
                            订单日期：{{order_date}}<br/>
                            服务项目：{{task_name}}<br/>
                            订单金额：{{order_price}}元<br/>
                            ------------------------------------------------------------------<br/>
                            {% else %}
                            ☯ {{logged_teacher}} 试测验证 ☯<br/>
                            试算日期：<?php echo date("Y-m-d h:i:s") ?><br/>
                            IP 地址：{{ip}}<br/>

                            ------------------------------------------------------------------<br/>
                            </div>
                            <div style="color:blue">
                            温馨提示：预测师回应时间最多5分钟。如果超时无回应，请返回首页，选择其他预测师。<br/>
                            试测验证仅限于验证过去已发生的事情。预测未来需要付费，请参考右侧的服务项目。<br/>
                            </div>
                            {% endif %}
                    </div>
                </div>
                <div class="mydiv login" id='div_name' style='display:block;'>
                 <!--
                                <OBJECT id=dlgHelper CLASSID="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" WIDTH="0px" HEIGHT="0px"></OBJECT>
                                <input class="inputtext" style='display:none;width:50px;cursor:hand;10px;background-color:#000000;color:#ffffff;' id='div_color' onClick="pickColor()" value="#000000" onBlur="this.style.backgroundColor=this.value;window.color=this.value.replace('#','');" />
                                <input class="inputtext bg" type=text style='width:20px;display:none' maxlength=3 id='input_size' value='16' />
                                文件选择:<input type="file" id="upload_file" name="id="upload_file" maxlength=30 />&nbsp;<input type="button" onclick="ajaxFileUpload()" value="上传"></input>
                                </div>
                                <div class="mydiv login" id='div_word'>
                               
                                <textarea type=text class="inputtext bg" rows=1 scrolling=no style='height:20px;overflow:hidden;width:500px;' id='chat_word' onFocus="if (this.value == '{{lang.hereyourwords}}') this.value=''; window.editing=0; "
                                 onkeydown="return check_send(event);" >{{lang["hereyourwords"]}}</textarea>
                             
                                <input type=button class=submit value='发送......' onClick="chat_send();_$('chat_word').style.height=20;" onFocus="this.blur();"/>
                                  -->
                    <input type="hidden" value="{{curUser_name}}" id="hid_user_id"/>
                    {% if taskTrue  %}
                                <input type="button" id="btn_submit" onclick="zhifu()"  value="确认支付"/>
                                <input type="button" id="btn_eval" onclick="pingjia()" value="交易评价" />
 {% endif %}



                </div>

<input type="input" value="" id="zuo_text"/>
                <div class='mydiv'  id='div_online'>Loading online...</div>

                <script>

                var debug = false;
               // var lastmod = {{lastmod}};
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

                _$('chat_user').onClick = setOnFocus;
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
               // setInterval("keeponline()",{{touchs}}*2000);

                 // setInterval("load_word()",(debug)?8000:2000);


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
                			//alert(load_word_ajax.responseText);
                			//return;
                			eval("var arr = "+load_word_ajax.responseText);

                		if (arr.roomstatus *1>0){
                        //setChatHtml(arr.roomstatus *1);
                         location.href =site_url +"chat/nochat?roomstatus=" +arr.roomstatus;
                          }
                		} catch(e)
                		{
                			//alert('Error 101\nJSON syntax error!\n\n'+load_word_ajax.responseText);
                			return;
                		}
/*
                		if (!arr || !arr.lastmod || typeof(arr.lastmod) == "undefined" )
                		{
                			return;
                		}
*/
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
						
					/*
					alert(arr.onlines);
                		if (arr.onlines)
                		{
                        //    console.info(arr);
                			_$('div_online').innerHTML = "";
                			for(var i=0;i<arr.onlines.length;i++)
                			    addonline(arr.onlines[i]);
                		}
                		*/
                		var hasText = 0;
                	
                		for(var i=0;i<line.length;i++)
                		{
                			var linekey = line[i].key;
                		//	alert(window.loaded_lines[linekey]);
                			
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
                			var div2 = document.createElement("div");
                            //设置显示内容 disflg
                                    if(line[i].userid=='{{curUser_name}}'){
                                    
                                        div2.className = "chatContent";
                                        div1.innerHTML ="<div style='float:right;width:40px'><img src={{teacher_head_pic}} /></div><div class='demo clearfix fr'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
                                        div2.innerHTML ="<div style='float:right'><div class='cloudText'><div class='cloudContent'><p style='white-space:pre-wrap'>"+ line[i].word +"</p></div><img class='arrowRight' src='{{ site_url }}public/img/bubble_green_guid1dbc1c.png'><div class='cloudArrow'></div></div><img class='avatar' src={{teacher_head_pic}} onerror='reLoadImg(this)' title='zuo'></div>";
                                    }else if(line[i].userid=="system"){
                                        div2.innerHTML = "<div style='float:left;width:40px'><img src=" + site_url +"siteimg/systemicon.jpg /></div><span style='float:left;width: 90%;height: 45px;text-align: left;line-height:45px;color:#888888;'>&nbsp"+line[i].word+"</span>";
                                    }else if(line[i].userid=="warning"){
                                            div2.innerHTML = "<div style='float:left;width:40px'><img src=" + site_url +"siteimg/systemicon.jpg /></div><span style='float:left;width: 90%;height: 45px;text-align: left;line-height:45px;color:#ff0000;'>&nbsp"+line[i].word+"</span>";

                                    }else if(line[i].userid=="info"){
                                             div2.innerHTML = "<div style='float:left;width:40px'><img src=" + site_url +"siteimg/systemicon.jpg /></div><span style='float:left;width: 90%;height: 45px;text-align: left;line-height:45px;color:#ff0000;'>&nbsp"+line[i].word+"</span>";
                                    }else if(line[i].userid=="html"){
                                             div2.innerHTML = "<div style='float:left;width:40px'><img src=" + site_url +"siteimg/systemicon.jpg /></div>&nbsp<span>"+line[i].word+"</span>";

                                    }else{
                                        div2.className = "chatContent-k";
                                        div1.innerHTML ="<div style='float:left;width:40px'><img src={{user_head_pic}} /></div><div class='demo clearfix'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
                                        div2.innerHTML ="<div style='float:left'><img class='avatar' src={{teacher_head_pic}} onerror='reLoadImg(this)' title='zuo'><div class='cloudText-k'><img class='arrowLeft' src='{{ site_url }}public/img/bubble_white_guid1dbc1c.png'><div class='cloudContent'><p style='white-space:pre-wrap'>"+ line[i].word +"</p></div></div></div>";
                                    }

                            var chatContent = document.getElementById("chatContent");
                            chatContent.appendChild(div2);
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

                			//window.lastmod = arr.lastmod;
                			//if(debug) alert("lastmod = "+arr.lastmod + " \nwindow.lastmod="+window.lastmod);
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

function overtalk(){
		location.href  =  site_url +"chat/adetail?room={{room}}&order_id={{task_id}}" ;
}

function pingjia(){

    _$('apDiv1').style.display = "block";
    _$('apDiv2').style.display = "none";
}
function zhifu(){
_$('apDiv1').style.display = "none";
_$('apDiv2').style.display = "block";
}

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
                 alert(12);
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

                  function setChatHtml(roomstatus){
                  var sHtml = ' <div style="color:red">';
                       if (roomstatus == 1) {
                         sHtml = sHtml+ " １ 不能跟自己会话";
                      }  else if (roomstatus==2) {
                       sHtml = sHtml+ " ２预测师不在线";
                      }  else if (roomstatus==3) {
                       sHtml = sHtml+ " 3 预测师忙碌";
                      }  else if (roomstatus==4) {
                       sHtml = sHtml+ " 3 预测师不愿意交谈";

                       }else{
                              sHtml = sHtml + "?number" +roomstatus;
                       }
                     sHtml = sHtml + " </div>";
                     _$('chatmain').innerHTML =sHtml;

                  }

                </script>

                <div id="apDiv1" style="left:460px">
                    <table align="center">
                        <tr>
                            <td height=40px><label>评价分数：</label></td>
                            <td><input type="radio" id="rad" name="rad" value="5" checked="checked" />非常满意</td>
                            <td><input type="radio" id="rad" name="rad" value="4"/>满意</td>
                            <td><input type="radio" id="rad" name="rad" value="3" />一般</td>
                            <td><input type="radio" id="rad" name="rad" value="0"/>不满意</td>
                        </tr>
                        <tr>
                            <td ><label style="align-text:top">评价内容：</label></td>
                            <td colspan=4><textarea cols=180 rows=5 id="eval_content" style="height:50px," maxlength=255></textarea></td>
                        </tr>
                    </table>
                    <input type="button" value="评价" onclick="eval_ajax()"></input>
                </div>

                <div id="apDiv2" style="left:460px">
                    <br /><br />
                    支付金额：<input type="text" value={{pay_reward}} disabled ="disabled" id="pay_reward">   <br />
                    <input type="checkbox" onclick="check_click()" id="chkok"/>同意条款
                    <br />
                    <input type="button" onclick="pay_ajax()" value="支付" id="btnpay" disabled ="disabled"></input>
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
