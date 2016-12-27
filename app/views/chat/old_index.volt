
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

                {%- if (logged_in is empty) %}
                       <script>
                           var site_url='<?php echo $site_url?>'
                           window.location.href=site_url+"session/login"
                       </script>
            {% endif %}

            <link href="<?php echo $site_url; ?>public/css/chat.css" rel="stylesheet" type="text/css" />
            <script src="<?php echo $site_url; ?>public/js/ajaxfileupload.js"></script>
            <script src="<?php echo $site_url; ?>public/js/chatRoom.js"></script>
                <script>
                </script>
                </head>
                <body >
                <center>
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
                <OBJECT id=dlgHelper CLASSID="clsid:3050f819-98b5-11cf-bb82-00aa00bdce0b" WIDTH="0px" HEIGHT="0px"></OBJECT>
                <input class="inputtext" style='display:none;width:50px;cursor:hand;10px;background-color:#000000;color:#ffffff;' id='div_color' onClick="pickColor()" value="#000000" onBlur="this.style.backgroundColor=this.value;window.color=this.value.replace('#','');" />
                <input class="inputtext bg" type=text style='width:20px;display:none' maxlength=3 id='input_size' value='16' />
                文件选择:<input type="file" id="upload_file" name="id="upload_file" maxlength=30 />&nbsp;<input type="button" onclick="ajaxFileUpload()" value="上传"></input>
                </div>
                <div class="mydiv login" id='div_word'>
                <textarea type=text class="inputtext bg" rows=1 scrolling=no style='height:20px;overflow:hidden;width:500px;' id='chat_word' onFocus="if (this.value == '{{lang.hereyourwords}}') this.value=''; window.editing=0; "
                 onkeydown="return check_send(event);" >{{lang["hereyourwords"]}}</textarea>
                <input type=button class=submit value='发送......' onClick="chat_send();_$('chat_word').style.height=20;" onFocus="this.blur();"/>
    <input type="hidden" value="{{curUser_name}}" id="hid_user_id"/>
    {% if taskTrue  %}
                <input type="button" id="btn_submit" onclick="zhifu()"  value="确认支付"/>
                <input type="button" id="btn_eval" onclick="pingjia()" value="交易评价" />

    {% endif %}
                </div>

<input type="input" value="" id="zuo_text"/>
                <div class='mydiv'  id='div_online'>Loading online...</div>

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
                
                                        div1.innerHTML ="<div style='float:right;width:40px'><img src={{teacher_head_pic}} /></div><div class='demo clearfix fr'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
                                        
                                    }else if(line[i].userid=="system"){
                                        div1.innerHTML ="<div style='float:left;width:40px'></div><div class='demo clearfix' style='text-align:center;color:orange;font-size:14px'>"+line[i].word+" <span class='time'>("+line[i].time+")</div>";
                                    }else{
                                        div1.innerHTML ="<div style='float:left;width:40px'><img src={{user_head_pic}} /></div><div class='demo clearfix'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
                                    }
                            }
                            else{
                                div1.innerHTML ="<div style='float:left;width:40px'></div><div class='demo clearfix'>"+line[i].word+" <span class='time'>("+line[i].time+")</div>";
                            }
                			body.appendChild(div1);

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
