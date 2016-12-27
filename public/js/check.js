function o_focus(varnm){
    document.getElementById(varnm + "_succeed").style.display = "block";
    document.getElementById(varnm + "_err").style.display = "none";
}

function o_blur(varnm){
    document.getElementById(varnm + "_succeed").style.display = "none";
    document.getElementById(varnm + "_err").style.display = "block";
}

function service_delete(site_url,ps_id,ps_site_id){
    $.MsgBox.Confirm("系统消息", "您确定要删除吗？", function () {
        window.location.href=site_url+"prophet/sdetail?ps_id="+ps_id+"&ps_site_id="+ps_site_id;
    });
}

function collection(ps_user_id,user_id){
    var site_url = document.getElementById('site_url').value;
    if(user_id == '000'){
        $.MsgBox.Confirm("系统消息", "请先登录。", function () {
            window.location.href=site_url+"session/login?act=online_collect";
        });
    }else if(user_id == ps_user_id){
        $.MsgBox.Alert("系统消息",  "您不能收藏自己。");
    }else{
        $.get(site_url+"online/collect/"+ps_user_id+"/"+user_id,function(data){
            if(data != 1){
                $.MsgBox.Alert("系统消息", data);
            }else{
                $.MsgBox.Alert("系统消息", "收藏成功！");
            }
        });
    }
}

function online_chat(ps_user_id,user_id){
    var site_url = document.getElementById('site_url').value;
    if(user_id == '000'){
        $.MsgBox.Confirm("系统消息", "要使用聊天室功能，请先登录。", function () {
            window.location.href=site_url+"session/login?act=online_chat";
        });
    }else if(user_id == ps_user_id){
        $.MsgBox.Alert("系统消息",  "您不能与自己聊天。");
    }else{
        window.location.href=site_url+"chat/index?room_id="+ps_user_id+"_"+user_id;
    }
}

function order_delete(url,t_order_id,status){
    if(status == 1){
        $.MsgBox.Alert("系统消息", "该订单未完成，无法删除！");
    }else{
        $.MsgBox.Confirm("系统消息", "您确定要删除吗？", function () {
            window.location.href=url+"?t_order_id="+t_order_id+"&flg=0";
        });
    }
}

function login_check(site_url,act){
    $.MsgBox.Confirm("系统消息", "要使用此功能，请先登录。", function () {
        window.location.href=site_url+"session/login?act="+act;
    });
}
