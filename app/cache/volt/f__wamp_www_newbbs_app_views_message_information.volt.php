
<?= $this->getContent() ?>
<?php
    include(APP_DIR."/config/link.php");
?>

<script type="text/javascript">
$(function(){
    var status = <?= $status ?>;
    var user_name = '<?= $ps_user_name ?>';
    if(status == 1){
        sendMessage('系统','');
        document.getElementById("mail").style.display = "none";
        document.getElementById("Content-Left").style.display = "none";
        document.getElementById("Content-Main").style.width = "100%";
    }else if(status == 2){
        sendMessage(user_name,'');
        document.getElementById("mail").style.display = "none";
        document.getElementById("Content-Left").style.display = "none";
        document.getElementById("Content-Main").style.width = "100%";
    }

});
</script>

<body id="toppage">

<div id="wrapper">

    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>
    <script src="<?php echo $site_url;?>public/js/jquery.treeview.js"></script>
    <script type="text/javascript" src="<?php echo $site_url;?>public/js/nicEdit.js"></script>
    <link href="<?php echo $site_url;?>public/css/chat.css" rel="stylesheet" type="text/css" />
    <section id="main"><?php if ((empty($logged_in))) { ?>
        <script>
            var site_url='<?php echo $site_url?>'
            window.location.href=site_url+"session/login"
        </script>
        <?php } ?>
        <div id="main_inner">
            <div id="top_detail">
                <div id="top_detail_inner">
                    <div ><a href="#" onclick="changemsgbox()"> 信箱</a>，<a href="#" onclick="changerecord()">最近通信</a></div>
                    <div id="Content" class="c1" style="display: none" >
                        <div id="Content-Left" style="overflow-y:scroll auto">
                            <ul id="navigation">
                                <li ><a href="#">收件箱</a>
                                    <ul>
                                        <?php foreach ($sendmsg as $item) { ?> <?php if ($item) { ?>
                                        <li><a href="#" onclick="getSendMsg(<?= $item['user_id'] ?>)"><?= $item['user_name'] ?></a></li> <?php } ?> <?php } ?>
                                    </ul> </li>
                                <li><a href="#">发件箱</a>
                                    <ul>
                                        <?php foreach ($receivemsg as $item) { ?> <?php if ($item) { ?>
                                        <li><a href="#" onclick="getReceiveMsg(<?= $item['user_id'] ?>)">to:<?= $item['user_name'] ?></a></li> <?php } ?> <?php } ?>
                                    </ul> </li>
                            </ul>
                        </div>
                        <div id="Content-Main" name="Content-Main">
                            <div class="tab">
                                <div class="tab_menu">
                                    <ul style="margin-left:3px;margin-top:-8px">
                                        <li class="selected" id="mail">邮件列表</li>
                                        <li id="messagetab">写私信</li>
                                    </ul>
                                </div>
                                <div class="tab_box">
                                    <div id="maildiv" >
                                        <div  style="height: 200px; overflow-y: auto">
                                            <table  id="tname" name="tname" style="width: 450px;">
                                                <tr  style='background-color:rgb(255, 179, 179)'><td  width=30%>日期</td> <td width=40%>标题</td> <td>发件人</td></tr>
                                            </table>
                                        </div>
                                        <h2 style="margin-top:20px">站内信息</h2>
                                        <div id="msgdiv" style="height:180px;border:solid rgb(163, 163, 163) 1px;overflow: auto;">
                                        </div>
                                    </div>
                                    <div id="messagediv" class="hide">
                                        <table style="border-bottom: none">
                                            <tr>
                                                <td width="20%">收件人：</td>
                                                <td><input type="text" id="name" /></td>
                                            </tr>
                                            <tr>
                                                <td>标题：</td>
                                                <td><input type="text" id="message_title" /></td>
                                            </tr>
                                            <tr>
                                                <td>内容：</td>
                                                <!--td><textarea style="width: 400px;height: 180px" id="msg_content" name="msg_content"></textarea></td-->
                                                <td><textarea style="width: 400px;height: 180px" id="msg_content" name="msg_content"></textarea></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"><input type="button" id="submit" value="发送......" onclick="send()" /></td>
                                            </tr>
                                        </table>
                                        <input type="label" id="senduser_id" class="hide" />
                                        <br />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            <div id="Content" style="display: block"  class="c2" >
                <div id="Content-Left" style="overflow-y:scroll auto">
                    <li ><a href="#" onclick="sendMessage()">写私信</a>&nbsp;&nbsp;<a href="#">检索</a><br /><input id="item" style="width: 100px;height: 10px" type="text"></input><a href="#" onclick="searchmsg()">开始</a></li>
                    <li>
                        <?php foreach ($namelist as $name) { ?> <?php if ($name) { ?>
                        <table id="listtb" name="listtb" style="width: 100%;border: 0;cellpadding:0; cellspacing:0">
                            <tr style="line-height:10px">
                                <td style="width: 60%;height: 10px;border-bottom: none;cellpadding:0; cellspacing:0">
                                    <b><a href="#" onclick="getMsgList(<?= $name['user_id'] ?>)"> <?= $name['user_name'] ?></a></b>
                                </td>
                                <td style="border-bottom: none;cellpadding:0; cellspacing:0">
                                    <font color="#deda30"> <?= $name['ins_time'] ?></font>
                                </td>
                            </tr>
                            <tr style="cellpadding:0; cellspacing:0">
                                <td colspan="2" style=";cellpadding:0; cellspacing:0">
                                    <div style="font-size: 11px; width:150px; height: 20px; overflow:hidden"><?= $name['message_content'] ?></div>
                                </td>
                            </tr>
                        </table>
                        <?php } ?> <?php } ?>
                    </li>
                </div>
                <div id="Content-Main"  style="overflow-y:scroll">
                    <div id="msglistdiv">

                    </div>
                </div>
            </div>
</div>

                </div>
            <?php include $hs_view_include_path.'listleft.inc';?>

        </div>
    </section>

    <section id="r_clm">
        
			<h4>Menu1</h4>
			<ul id="info">
				<li><a href="<?= $site_url ?>user">个 人 中 心<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
                    <li><a href="<?= $site_url ?>prophet/index">预 测 师 管 理<span></span></a></li>
                     <li><a href="<?= $site_url ?>chat/index">交 谈 管 理 <span></span></a></li>
                <?php }else{?>
                    <li><a href="<?= $site_url ?>user/apply">申 请 预 测 师<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>reward/search">赏 金 求 测 大 厅<span></span></a></li>
				<li><a href="<?= $site_url ?>money/recharge/1">购 买 算 卦 币<span></span></a></li>
                <li><a href="<?= $site_url ?>reward/public">发 布 赏 金 求 测<span></span></a></li>
                <li><a href="">百 家 争 鸣<span></span></a></li>
                <li><a href="<?= $site_url ?>order/orders">我 的 订 单<span></span></a></li>
                <!--li><a href="<?= $site_url ?>chat/teacher">试 测 验 证<span></span></a></li-->
				<li><a href="<?= $site_url ?>prophet/browse">预 测 师 随 笔<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
				    <li><a href="<?= $site_url ?>article/particle">写 随 笔<span></span></a></li>
                <?php }?>
                <li><a href="<?= $site_url ?>message/information?status=1">意 见 反 馈<span></span></a></li>
			</ul>

	<!-- JiaThis Button BEGIN -->
<div class="jiathis_style_24x24">
	
	<a class="jiathis_button_tsina"></a>
	<a class="jiathis_button_tqq"></a>
	<a class="jiathis_button_weixin"></a>
	
	<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
	<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->
    </section>

    <br clear="all">
</div>

<?php include $hs_view_include_path.'footer.inc';?>
</body>

<script type="text/javascript" >
//<![CDATA[
$(document).ready(function () {
            var $div_li = $("div.tab_menu ul li");
            $div_li.click(function() {
                $(this).addClass("selected") //当前<li>元素高亮
                        .siblings().removeClass("selected"); //去掉其它同?<li>元素的高亮
                var index = $div_li.index(this); // ?取当前点?的<li>元素 在 全部li元素中的索引。
                $("div.tab_box > div") //?取子?点。不?取子?点的?，会引起??。如果里面?有div
                        .eq(index).show() //?示 <li>元素??的<div>元素
                        .siblings().hide(); //?藏其它几个同?的<div>元素
            }).hover(function() {
                        $(this).addClass("hover");
                    },
                    function() {
                        $(this).removeClass("hover");
                    })
            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });

        }
);
//]]>
</script>
