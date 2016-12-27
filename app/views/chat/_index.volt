
<?php
include("E:\cui\www\app\config\link.php");
?>

{%- if (logged_in is empty) %}
       <script>window.location.href="/session/login"</script>
 {% endif %}

<style type='text/css'>

a	{ text-decoration:none; color:#a2b700; }
.mydiv	{ text-align:left; margin:5px; padding:5px; border:1px solid #7C7C7C; background-color:#E7E7E7; width:600px; }
.inputtext	{ border:0px; border-bottom:1px solid #333333; background-color:transparent;}
.submit	{ border:1px solid #bd3d11; background-color:transparent; }
.contents	{ border:1px solid #ABABAB;margin:5px; margin-top:10px;background-color:#ffffff; overflow:auto;word-break:break-all;word-wrap :break-word;}
.bg	{ background-color:#ffffff; }
.content	{ border:0px;background-color:transparent;width:auto; font-size:16px; font-family:Fixedsys; margin:2px; padding:1px; }
.time	{ color:#aaaaaa; font-size:10px; font-family:Arial;}
.online	{ margin:5px; padding:0px; display:inline; }
.mybut	{ width:20px; height:20px; background-color:#bd3d11; text-align:center; font-size:18px; color: #333333;}
#apDiv1 {
    position:absolute;
    width:400px;
    height:205px;
    z-index:99999;
    left:360px;
    top: 260px;
    border:solid 1px darkgoldenrod;
    display:none;
    background-color: white;
}
#apDiv2 {
    position:absolute;
    width:400px;
    height:205px;
    z-index:99999;
    left:360px;
    top: 260px;
    border:solid 1px darkgoldenrod;
    display:none;
    background-color: white;
}
.bubble { margin:0px auto; width:autox; }
.demo {
margin-bottom:20px;
padding-left:50px;
position:relative;
}

.triangle {
position:absolute;
top:50%;
margin-top:-8px;
left:42px;
display:block;
width:0;
height:0;
overflow:hidden;
line-height:0;
font-size:0;
border-bottom:8px solid #FFF;
border-top:8px solid #FFF;
border-left:none;
border-right:8px solid #3079ED;
}

.demo .article {
float:left;
color:#FFF;
display:inline-block;
*display:inline; zoom:1;
padding:5px 10px;
border:1px solid #3079ED;
background:#eee;
border-radius:5px;
background-color: #4D90FE;
background-image:-webkit-gradient(linear,left top,left bottom,from(#4D90FE),to(#4787ED));
background-image:-webkit-linear-gradient(top,#4D90FE,#4787ED);
background-image:-moz-linear-gradient(center top , #4D90FE, #4787ED);
background-image:linear-gradient(top,#4D90FE,#4787ED);
}

.fr { padding-left:0px; padding-right:50px; }

.fr .triangle {
left:auto;
right:42px;
border-bottom:8px solid #FFF;
border-top:8px solid #FFF;
border-right:none;
border-left:8px solid #3079ED;
}

.fr .article {
float:right;
}
</style>
<script src="/public/js/ajaxfileupload.js"></script>
<script>
function _$(obj)
{
	return document.getElementById(obj);
}

function setCookie(name,value,t)
{
	var cookieexp = 5*30*24*60*60*1000; //5 months
	var cookiestr=name+"="+escape(value)+";";
	var expires = "";
	var d = new Date();
	var t2=(!t)?cookieexp:t*60*1000;
	d.setTime( d.getTime() + cookieexp);
	expires = "expires=" + d.toGMTString()+";";
	document.cookie = cookiestr+ expires;
}

function getCookie(name)
{
	var start = document.cookie.indexOf( name + "=" );
	var len = start + name.length + 1;
	if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) ) return "";
	if ( start == -1 ) return "";
	var end = document.cookie.indexOf( ";", len );
	if ( end == -1 ) end = document.cookie.length;
	return unescape( document.cookie.substring( len, end ) );
}

function createAJAX()
{
	if (window.XMLHttpRequest) 
	{
		var oHttp = new XMLHttpRequest();
		return oHttp;
	} 
	else if (window.ActiveXObject) 
	{
		var versions = [
			"MSXML2.XmlHttp.6.0",
			"MSXML2.XmlHttp.3.0"
		];

		for (var i = 0; i < versions.length; i++) 
		{
			try {
				var oHttp = new ActiveXObject(versions[i]);
				return oHttp;
			} catch (error) {}
		}
    	}
	throw new Error("Your browser doesn't support XMLHttpRequest");
}

function pickColor()
{
	if (!window.isIE) return;
	var sColor = _$('dlgHelper').ChooseColorDlg();
	var color = sColor.toString(16);
	while (color.length<6) color="0"+color;
	window.color = color;
	color = "#"+color;
	_$('div_color').style.backgroundColor = color;
	_$('div_color').value = color;
}

var isIE = (document.all && window.ActiveXObject) ? true : false;
</script>
</head>
<body >
<center>
<div class=mydiv style='text-align:center; border:0px; background-color:transparent; font-size:25px; color:#ff8c05;'>预测师聊天室</div>
<div class="mydiv login" id='div_description'>
当前预测师:<input type=text class="bg" disabled size=8 id='chat_user' value='' maxlength=30 />&nbsp;
</div>
<div class="mydiv rooms" id='div_msg'>

<div class='contents bubble' style='height:350px;' id='div_contents'>

<div style="color:blue">欢迎您来到 人生预测平台，请稍待预测师回应…</div>
<div style="color:red">
-----------------------------------------------<br/>
☯ 易学宗师 试测验证 ☯<br/>
试算日期：<?php echo date("Y-m-d h:i:s") ?><br/>
IP 地址：{{ip}}<br/>
-----------------------------------------------<br/>
</div>
<div style="color:blue">
温馨提示：预测师回应时间最多5分钟。如果超时无回应，请返回首页，选择其他预测师。<br/>
试测验证仅限于验证过去已发生的事情。预测未来需要付费，请参考右侧的服务项目。<br/>
</div>
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
<input type="button" id="btn_submit" onclick="zhifu()"  value="确认支付"/>
<input type="button" id="btn_eval" onclick="pingjia()" value="交易评价" />
</div>


<div class='mydiv'  id='div_online'>Loading online...</div>

<script>
var debug = 0;
var lastmod = {{lastmod}};
var login = 1;
var loading = false;
//var olduser = getCookie('chatusername');
var olduser = "{{logged_in}}";//('chatusername');
if (olduser != ""){
//console.info(_$('#chat_user'));
    _$('chat_user').value=olduser;
}
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
function encode(s)
{
	return  (encodeURIComponent)? encodeURIComponent(s):s;
}

_$('chat_user').onfocus = setOnFocus;
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
function keeponline()
{
	var name = _$('chat_user').value;
	if (!name) return;
	keep_ajax = createAJAX();
	keep_ajax.open('POST','/chat/keep',1);
	keep_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	keep_ajax.onreadystatechange = function ()
	{
		if (keep_ajax.readyState == 4 && keep_ajax.status == 200)
		{
			//alert(keep_ajax.responseText);
		}
	}
	keep_ajax.send("action=keep&name="+encode(name)+"&room="+room);
}
setInterval("keeponline()",{{touchs}}*1000);

function quitroom()
{
	if(confirm("你真的要离开聊天室吗?"))
	{
		var ajax = createAJAX();
		ajax.open('POST','/chat/quit',0);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("action=quit&name="+encode(_$('chat_user').value));
		//alert("sending close  action=quit&name="+encode(_$('chat_user').value));
		//alert("response:"+ajax.responseText);
	}
	else return '';
}
document.body.onbeforeunload =  quitroom;

setInterval(" load_word()",(debug)?8000:1000);
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
		for(var i=0;i<line.length;i++)
		{
			var linekey = line[i].word.substring(line[i].word.length-20,line[i].word.length)+line[i].time;
			if (window.loaded_lines[linekey] === true)
			{
				if (debug) alert("jump:"+linekey);
				continue;
			}
			var div1 = document.createElement("div");
			window.nowdisplay ++;
			if (window.nowdisplay > window.maxdisplay) window.nowdisplay = 1;
			if (_$("contentitem"+window.nowdisplay)) body.removeChild(_$("contentitem"+window.nowdisplay));
			div1.className = "content";
			div1.id = "contentitem"+window.nowdisplay;
            //设置显示内容

          //  console.info(line[i].word);

            if(line[i].userid=='{{logged_in}}'){
                div1.innerHTML ="<div style='float:left;width:40px'><img src='/public/img/a.jpg'/></div><div class='demo clearfix'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
            }else{
			    div1.innerHTML ="<div style='float:right;width:40px'><img src='/public/img/b.jpg'/></div><div class='demo clearfix fr'><span class='triangle'></span><div class='article'>"+line[i].word+" <span class='time'>("+line[i].time+")</span></div></div>";
			}
			body.appendChild(div1);
			
			window.loaded_lines[linekey] = true;
			body.scrollTop = 655350;
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
	}
}

function load_word_error()
{
	window.loading = false;
	window.status = 'Error 102:while loading words';
	setTimeout("window.status = '';",5000);
}

function load_word()
{
	load_word_ajax = createAJAX();
	if (window.loading)
	{
		try
		{
			load_word_ajax.abort();
			window.loading = false;
		}catch(e)	{}
	}
	if (!window.lastmod)
	{
		alert("window.lastmod="+window.lastmod);
		return;
	}
	
	load_word_ajax.open('POST','/chat/read',true);
	load_word_ajax.onreadystatechange = load_word_change;
	
	var urlstring = '';
	urlstring += "lastmod="+window.lastmod;
	urlstring+= "&room="+room;
	urlstring+= "&action=read";
	urlstring+= "&name="+encode(_$('chat_user').value);
	//console.info(room);
	if (window.first)
	{
		urlstring+= "&first=true";
		urlstring += "&dis="+dis;
	}
	//如果到了取得在线用户的时间
	if (window.dotouch) 
	{
		urlstring+= "&touchme=true";
		window.dotouch = false;
		//垃圾内存回收
		try { CollectGarbage(); } catch(e) {}
	}

	window.loading = true;
	if (debug) alert("sending:"+urlstring);
	load_word_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	//console.info(urlstring);
	load_word_ajax.send(urlstring);
}

function touchme()
{
	window.dotouch = true;
	setTimeout("touchme()",{{touchs}}*1000);
}

function showalert(a,n)
{
	if (!n) n=0;
	if (n>3) return;
	if (!a)
	{
		a = 0;
		b = 1;
	}
	else
	{
		a = 1;
		b = 0;
	}
	document.title = mytitle[a];
	setTimeout("showalert("+b+","+(n+1)+");",500);
}

function addonline(name)
{
	if (_$(name)) return;
	var d1 = document.createElement("div");
	d1.id = name;
	d1.innerHTML = name;
	d1.className = "online";
	_$('div_online').appendChild(d1);
}

touchme();

function check_send(e)
{
	if (!e) e = window.event;
	var obj = _$('chat_word');
	if (isIE) obj.style.height = obj.scrollHeight+3;
	if (e.keyCode == 13)
	{
		if ((!e.shiftKey && !e.altKey && !e.ctrlKey) || !isIE)
		{
			chat_send();
			obj.style.height = 20;
			return false;
		}
		else if (isIE) obj.style.height = obj.scrollHeight+18;
	}
	return true;
}

var send_ajax;


send_ajax_change  = function()
{
	if (send_ajax.readyState == 4)
	{
		if (send_ajax.status != 200)
		{
			send_ajax_error();
			return;
		}
		if (debug) alert("send_ajax response:"+send_ajax.responseText);
		if (send_ajax.responseText.indexOf("NAME")!=-1)
		{
			alert('已经有人使用你的昵称了');
			_$('chat_user').value = "";
			_$('chat_user').focus();
		}
		else if (send_ajax.responseText.indexOf("repeat")!=-1)
		{
			_$('chat_word').value = window.lastcontent;
		}
		
		on_send_ok();
		
		if (!window.loading)
		{
			window.dotouch = true;
			load_word();
		}
		_$('chat_word').disabled = false;
		_$('chat_word').focus();
	}
}

function on_send_begin()
{
	with(_$('chat_word'))
	{
		disabled = true;
		style.backgroundColor = "#eeeeee";
	}
	window.sending = 1;
}

function on_send_ok()
{
	window.sending = 0;
	with(_$('chat_word'))
	{
		value = '';
		disabled = false;
		focus();
		style.backgroundColor = "#ffffff";
	}	
}

function on_send_error()
{
	window.sending = 0;
	with(_$('chat_word'))
	{
		disabled = false;
		focus();
		style.backgroundColor = "#ffffff";
	}
}

function send_ajax_error()
{
	alert('Error 103\nwhen send words\n\nYou can send them again!');
	_$('chat_word').value = window.lastcontent;
	window.sending = 0;
	on_send_error();
}

function chat_send()
{
	send_ajax = createAJAX();
	send_ajax.open('POST','/chat/write',true);
	send_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	send_ajax.onreadystatechange = send_ajax_change;
	var urlstring = '';
	var name = _$('chat_user').value.replace("\n","");
	var content = _$('chat_word').value;
	var bold ="";
	var size = parseInt(_$('input_size').value);
	var font ="";
	
	if (name == "")
	{
		alert('Please enter your nick name first!!');
		_$('chat_user').focus();
		return;
	}
	
	if (content == "" || content == "\n" || content == "\n\n" || content == "\n\n\n")
	{
		alert('Please enter your words!');
		_$('chat_word').focus();
		_$('chat_word').value = "";
		return;
	}
	if (size>100) size = 100;
	else if (size<0) size = 1;
	
	urlstring+= "action=write";
	urlstring+= "&name="+encode(name);
	urlstring+= "&content="+encode(content);
	urlstring+= "&bold="+bold;
	urlstring+= "&color="+window.color;
	urlstring+= "&size="+size;
	urlstring+= "&font="+font;
	urlstring+= "&room="+room;

	window.sending = 1;
	window.lastcontent = content;
	on_send_begin();
	if (debug) alert("sending:"+urlstring);
	
	send_ajax.send(urlstring);
	setTimeout("if (window.sending) send_ajax.abort(); on_send_error();",5000);
	setCookie("chatusername",_$('chat_user').value);
}

function resize(s)
{
	var o = _$('div_contents').style;
	var h = parseInt(o.height);
	h = (s)?h+50:h-50;
	if (h<=50 || h>=3000) return;
	o.height = h;
	_$('div_contents').scrollTop = 655350;
}

function clearAll()
{
	_$('div_contents').innerHTML = "";
}
function pingjia(){

    _$('apDiv1').style.display = "block";
    _$('apDiv2').style.display = "none";
}
function zhifu(){
_$('apDiv1').style.display = "none";
_$('apDiv2').style.display = "block";
}

function eval_ajax(){
	pingjia_ajax = createAJAX();
	pingjia_ajax.open('POST','/chat/eval',1);
	pingjia_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	pingjia_ajax.onreadystatechange = function ()
	{
		if (pingjia_ajax.readyState == 4 && pingjia_ajax.status == 200)
		{
    		if(pingjia_ajax.responseText=="ok"){
	            alert("评价成功");
                $('apDiv1').style.display = "none";
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
	pingjia_ajax.send("action=keep&sorce="+radioValue +"&content="+_$('eval_content').value+"&task_id="+{{task_id}});
 }
 function check_click(){

 var chkObjs = document.getElementById("chkok");
 var btnpay = document.getElementById("btnpay");

     if(chkObjs.checked){
         btnpay.disabled=false;

     }else{
         btnpay.disabled=true;
     }
 }
 function pay_ajax(){
  	zhifu_ajax = createAJAX();
  	zhifu_ajax.open('POST','/chat/pay',1);
  	zhifu_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  	zhifu_ajax.onreadystatechange = function ()
  	{
  		if (zhifu_ajax.readyState == 4 && zhifu_ajax.status == 200)
  		{
      		if(zhifu_ajax.responseText=="ok"){
  	            alert("支付成功");
                $('apDiv2').style.display = "none";
  		    }
  		}
  	}
  	zhifu_ajax.send("action=keep&task_id={{task_id}}&pay_to_user_id={{pay_to_user_id}}&pay_reward="+_$('pay_reward').value);
   }
   function downloadfile($path){
    alert("下载OK");

   }
   function ajaxFileUpload() {
               $.ajaxFileUpload
               (
                   {
                       url: '/chat/upload', //用于文件上传的服务器端请求地址
                       secureuri: false, //是否需要安全协议，一般设置为false
                       fileElementId: 'upload_file', //文件上传域的ID
                       dataType: 'json', //返回值类型 一般设置为json
                       success: function (data, status)  //服务器成功响应处理函数
                       {
                       console.info(data);
                        if(data.type=='img'){
                            _$('chat_word').value=data.path;

                       }else{
                            _$('chat_word').value="[a href="+(data.path)+"]"+(data.filename)+"[/a]";
                            console.info(_$('chat_word').value);
                       }
                         chat_send();
                                //console.info(data);
                       },
                       error: function (data, status, e)//服务器响应失败处理函数
                       {
                           alert(e);
                       }
                   }
               )
               return false;
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
