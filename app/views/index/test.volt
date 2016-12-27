<?php
        include(APP_DIR."/config/link.php");
 ?>
<script src="<?php echo $site_url;?>public/js/dialog.js"></script>
<body>
<button id="callConfirm">Confirm!</button>
<div id="dialog" title="提示框">
要使用此功能，请先登录?
</div>​
</body>

<script>
$(function(){
	$("#dialog").dialog({
		autoOpen: false,
		modal: true,
		buttons : {
            "确定" : function() {
                alert("You have confirmed!");
            },
            "取消" : function() {
                $(this).dialog("close");
            }
		}
	});
	$("#callConfirm").on("click", function(e) {
		//e.preventDefault();
		//$("#dialog").dialog("open");
		//$.MsgBox.Alert("消息", "哈哈，添加成功！");
		$.MsgBox.Confirm("温馨提示", "执行删除后将无法恢复，确定继续吗？温馨提示", function () { alert("删除成功..."); });
	});
})

</script>