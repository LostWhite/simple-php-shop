/**
 * Created by Administrator on 15/02/11.
 */
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


function keeponline()
{
    var name = _$('chat_user').value;
    if (!name) return;
    keep_ajax = createAJAX();
    keep_ajax.open('POST',site_url+'/chat/keep',1);
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


function quitroom()
{
    if(confirm("你真的要离开聊天室吗?"))
    {
        var ajax = createAJAX();
        ajax.open('POST',site_url+'/chat/quit',0);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("action=quit&name="+encode(_$('chat_user').value));
        //alert("sending close  action=quit&name="+encode(_$('chat_user').value));
        //alert("response:"+ajax.responseText);
    }
    else return '';
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
    /*
    if (!window.lastmod)
    {
        alert("window.lastmod="+window.lastmod);
        return;
    }
*/
    load_word_ajax.open('POST',site_url+'/chat/read',true);
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

//发送
function chat_send()
{
	
    send_ajax = createAJAX();
    send_ajax.open('POST',site_url+'/chat/write',true);
    
    send_ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    send_ajax.onreadystatechange = send_ajax_change;
    var urlstring = '';

    var name = _$('hid_user_id').value.replace("\n","");
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
   // urlstring+= "&bold="+bold;
    //urlstring+= "&color="+window.color;
    //urlstring+= "&size="+size;
    //urlstring+= "&font="+font;
    urlstring+= "&room="+room;
  //  _$('zuo_text').value = site_url+'/chat/write' + urlstring;
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


function check_click(){

    var chkObjs = document.getElementById("chkok");
    var btnpay = document.getElementById("btnpay");

    if(chkObjs.checked){
        btnpay.disabled=false;

    }else{
        btnpay.disabled=true;
    }
}

//文件下载
function downloadfile($path){
    docPath = $path.split('=');

    var form=$("<form>");//定义一个form表单
    form.attr("style","display:none");
    form.attr("target","");
    form.attr("method","post");
    form.attr("action",$path);
    var input1=$("<input>");
    input1.attr("type","hidden");
    input1.attr("name","path");
    input1.attr("value",docPath[1]);
    form.append(input1);
    $("body").append(form);//将表单放置在web中
    form.submit();//表单提交
}
function ajaxFileUpload() {
    $.ajaxFileUpload
    (
        {
            url: site_url+'/chat/upload', //用于文件上传的服务器端请求地址
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
