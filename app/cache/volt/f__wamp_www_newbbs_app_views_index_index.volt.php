<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>
<body>
	<div id="wrapper">
		<noscript>这个网站javascript必须设置为ON</noscript>

		<section id="main">
			<div id="main_inner">
				<div id="top_detail">
				    <div style="">
				        <a href="<?= $site_url ?>"><img src="<?= $site_url ?>siteimg/toplogo.jpg"  />
				    </div>
					<div id="item_info">
						
						
<style>
    <!--
    * {margin: 0;padding:0;}
    body {background: #222;}
    ol {list-style: none;}
    img {border: 0 none;}
    #slider {
        width: 100%;
        height: 180px;
        overflow: hidden;
        position: relative;
        margin: 0em auto;
    }
    #slider .player {
        position: absolute;
        top: 0px;
        left: 0px;
    }
    #slider .player li {
        width: 975px;
        height: 180px;
    }
    #slider .btns {
        position: absolute;
        right: 10px;
        bottom: 5px;
        height: 30px;
    }
    #slider .btns li {
        font: 13px Tahoma, Arial, 宋体, sans-serif;
        float: left;
        margin: 0 3px;
        border: 1px solid #F60;
        background-color: #FFF;
        color: #CC937A;
        opacity: .8;
        cursor: pointer;
        width: 20px;
        height: 20px;
        line-height: 19px;
        text-align: center;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }
    #slider .btns li.active {
        background: #F60;
        color: #FFF;
        font-weight: bold;
        opacity: 1;
    }
    -->
</style>

<script>
    //<![CDATA[
    function rcd(id) {
        return document.getElementById(id);
    };
    function getByClass(className, context) {
        /*
         * 功能说明：
         * 传入类名、节点名（默认document），获取context下类名为classNa的节点
         */
        context = context || document;
        if(context.getElementsByClassName) {
            return context.getElementsByClassName(className);
        } else {
            var nodes = [];
            var tags = context.getElementsByTagName('*');
            for(var i=0, len=tags.length; i<len; i++) {
                if(hasClass(tags[i], className)) {
                    nodes.push(tags[i]);
                }
            }
            return nodes;
        }
    }
    function hasClass(node, className) {
        /*
         * 功能说明：
         * 传入节点及一个类名，检查该节点是否含有传入的类名
         */
        var names = node.className.split(/\s+/);
        for(var i=0, len=names.length; i<len; i++) {
            if(names[i] == className) {
                return true;
            }
        }
        return false;
    }
    function animate(o,start,alter,dur,fx) {
        /*
         * 功能说明：
         * 设置动画
         * o:要设置动画的对象
         * start:开始的对象
         * alter:总的对象
         * dur:动画持续多长时间
         * fx:动画类型
         */
        var curTime=0;
        var t=setInterval(function () {
            if (curTime>=dur) clearInterval(t);
            for (var i in start) {
                o.style[i]=fx(start[i],alter[i],curTime,dur)+"px";
            }
            curTime+=40;
        },40);
        return function () {
            clearInterval(t);
        };
    }
    var Tween = {
        /*
         * 功能说明：
         * 加速运动
         * curTime:当前时间,即动画已经进行了多长时间,开始时间为0
         * start:开始值
         * alter:总的变化量
         * dur:动画持续多长时间
         */
        Linear:function (start,alter,curTime,dur) {return start+curTime/dur*alter;},//最简单的线性变化,即匀速运动
        Quad:{//二次方缓动
            easeIn:function (start,alter,curTime,dur) {
                return start+Math.pow(curTime/dur,2)*alter;
            },
            easeOut:function (start,alter,curTime,dur) {
                var progress =curTime/dur;
                return start-(Math.pow(progress,2)-2*progress)*alter;
            },
            easeInOut:function (start,alter,curTime,dur) {
                var progress =curTime/dur*2;
                return (progress<1?Math.pow(progress,2):-((--progress)*(progress-2) - 1))*alter/2+start;
            }
        },
    };
    function Player(btns, scrollContent, imgHeight, timeout, hoverClass) {
        /*
         * btns:按钮，类型是数组
         * scrollContent:摇滚动的块，一个DOM对象，这里是ol
         * imgHeight:每一张图片的高度，当然，如果想改成左右滚动，这里传入每一张图片的宽，唯一需要注意的是每一张图片宽高必须相同，图片数量可调整
         * timeout:切换速度快慢，默认为1.5ms
         * hoverClass:每一个按钮激活时的类名
         */
        hoverClass = hoverClass || 'active';
        timeout = timeout || 1500;
        this.btns = btns;
        this.scrollContent = scrollContent;
        this.hoverClass = hoverClass;
        this.timeout = timeout;
        this.imgHeight = imgHeight;
        var _this = this;
        for(var i=0; i<btns.length; i++) {
            this.btns[i].index = i;
            btns[i].onmouseover = function() {
                _this.stop();
                _this.invoke(this.index);
            }
            btns[i].onmouseout = function() {
                _this.start();
            }
        }
        this.invoke(0);
    }
    Player.prototype = {
        constructor : Player,
        start : function() {
            var _this = this;
            this.stop();
            this.intervalId = setInterval(function() {
                _this.next();
            }, this.timeout);
        },
        stop: function() {
            clearInterval(this.intervalId);
        },
        invoke: function(n) {
            this.pointer = n;
            if(this.pointer >= this.btns.length) {
                this.pointer = 0;
            }
            this.clearHover();
            this.btns[this.pointer].className = this.hoverClass;
            //this.scrollContent.style.top = parseInt(-this.imgHeight * this.pointer) + 'px';
            var startVal = parseInt(this.scrollContent.style.top) || 0;
            var alterVal = (parseInt(-startVal - this.imgHeight * this.pointer));
            this.animateIterval && this.animateIterval();//修正快速切换时闪动
            this.animateIterval=animate(this.scrollContent, {top : startVal},{top : alterVal}, 2000, Tween.Quad.easeOut);
            //这里默认设置每张图滚动的总时间是1s
        },
        next: function() {
            this.invoke(this.pointer + 1);
        },
        clearHover: function() {
            for(var i=0; i<this.btns.length; i++) {
                this.btns[i].className = '';
            };
        }
    }
    window.onload = function() {
        var btns = getByClass('btns', $('slider'))[0].getElementsByTagName('li');
        var player = getByClass('player', $('slider'))[0];
        var player = new Player(btns, player, 180, 20000, undefined);
        player.start();
        //player.invoke(2);
    }
    //]]>
</script>
<div id="slider" class="main_gif">
    <ol class="player">
        <?php foreach ($img_no as $no) { ?>
            <li><a href=""><img src="<?php echo $site_url; ?>img/file/01_<?= $no ?>.jpg" title="" width="975px" height="180px"></a></li>
        <?php } ?>
        <!--li><a href="http://127.0.0.1:8080/item/519"><img src="<?php echo $site_url; ?>img/file/01_3.jpg" title="" width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/515"><img src="<?php echo $site_url; ?>img/file/01_1.jpg" title=""  width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/516"><img src="<?php echo $site_url; ?>img/file/01_0.jpg" title=""  width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/511"><img src="<?php echo $site_url; ?>img/file/01_4.jpg" title=""  width="975px" height="180px"></a></li>
        <li><a href="http://127.0.0.1:8080/item/500"><img src="<?php echo $site_url; ?>img/file/01_2.jpg" title="Denture World" id="img"  width="975px" height="180px"></a></li-->
    </ol>
    <ol class="btns">
        <li>1</li>
        <li>2</li>
        <li>3</li>
        <li>4</li>
        <li>5</li>
    </ol>
</div>
						
					</div>
					<!--?php include $hs_view_include_path.'listeval.inc';?-->
					<style type="text/css"> 
#eval_index{width:100%;height:40px;overflow:hidden;line-height:40px;font-size:13px;font-family:'宋体';background:#DDE5ED;color:#0C77CF;font-weight:bold;} 
#eval_index #scroll_begin, #eval_index #scroll_end{display:inline} 
</style> 
<script type="text/javascript"> 
function ScrollImgLeft(){ 
var speed=50; 
var scroll_begin = document.getElementById("scroll_begin"); 
var scroll_end = document.getElementById("scroll_end"); 
var scroll_div = document.getElementById("scroll_div"); 
scroll_end.innerHTML=scroll_begin.innerHTML; 
function Marquee(){ 
if(scroll_end.offsetWidth-scroll_div.scrollLeft<=0) 
scroll_div.scrollLeft-=scroll_begin.offsetWidth; 
else 
scroll_div.scrollLeft++; 
} 
var MyMar=setInterval(Marquee,speed); 
scroll_div.onmouseover=function() {clearInterval(MyMar);} 
scroll_div.onmouseout=function() {MyMar=setInterval(Marquee,speed);} 
} 
</script> 
<div id="eval_index"> 
<div style="width:950px;height:40px;margin:0 auto;white-space: nowrap;overflow:hidden;" id="scroll_div" class="scroll_div"> 
<div id="scroll_begin"> 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
${affiche.content} ${affiche.content} ${affiche.content} 
</div> 
<div id="scroll_end"></div> 
</div> 
<script type="text/javascript">ScrollImgLeft();</script> 
</div>
					<div class="service_title">
					    预测师一览
					</div>
					<div id="detail_inner">
						<ul>

							<?php foreach ($uservices as $service) { ?>
                                <li>
                                    <div>
                                        <a href="<?= $site_url ?>online/tab1/<?= $service['ps_user_id'] ?>">
                                        <div class="services_part1" style="background: url(<?= $site_url ?>img/per/<?php 
                                        	$service['img']=BASE_DIR . "/public/img/per/".$service['ps_user_id']."/m.jpg";
   														 if( file_exists( $service['img']) ) 
														{ 
    													$service['img']=$service['ps_user_id']."/m.jpg";
															} 
														else 
														{
  														  $service['img']="default_user.jpg";
														}
                                        	 ?><?= $service['img'] ?>) no-repeat;">
                                            <i class='p-icon' style="background: url(<?= $site_url ?>public/css/images/p_icon.gif) no-repeat;"></i>
                                        </div>
                                        </a>
                                        <div class="services_part2">
                                            <span style="display: inline-block;"><?= $service['user_name'] ?></span><span style="display: inline-block;height: 16px;line-height: 16px;width: 33px;background: url(<?= $site_url ?>public/css/images/<?= $service['onlineimg'] ?>) no-repeat;">&nbsp;</span><br>
                                            <br>
                                            <span>总好评率：<?= $service['eval_percent'] ?></span><br>
                                            <span>月好评率：<?= $service['eval_percent_mon'] ?></span><br>
                                            <span>月成交指数：<?= $service['sale_point_mon'] ?></span>
                                        </div>
                                    </div>
                                    <div class="services_part3">
                                    <p><a href="<?= $site_url ?>online/tab1/<?= $service['ps_user_id'] ?>"><?= $service['user_content'] ?>……</a></p>
                                    <a href="<?= $site_url ?>chat/index?sid=<?= $service['ps_user_id'] ?>"><span class="index_chat">试测交谈</span></a>
                                    <a href="<?= $site_url ?>online/tab3/<?= $service['ps_user_id'] ?>"><span>用户评价</span></a>
                                    <a href="<?= $site_url ?>message/information?status=2&ps_user_name=<?= $service['user_name'] ?>"><span>直接留言</span></a>
                                    </div>
                                </li>
                                <!--
                                <li>
                                    <a href="<?= $site_url ?>online/tab1" title="月刊デンタルダイヤモンド 2013年8月号">
                                   <table><tr><td> <div class="book_img"><img src="<?= $site_url ?>img/default_m.jpg" style="height:130px;" /></div>
                                   </td><td>aaa
                                   </td></tr></table>
                                    <br>
                                    <em><?= $service->user_content ?></em>
                                    </a>
                                    <br>
                                    &nbsp;<input type="button" value="试测交谈" class="btn btn-primary" />
                                    &nbsp;<input type="button" value="用户评价" class="btn btn-primary" />
                                    &nbsp;<input type="button" value="直接留言" class="btn btn-primary" />
                                    &nbsp;<span style="display: inline-block;height: 16px;line-height: 16px;width: 33px;background: url(<?= $site_url ?>public/css/images/online.jpg) no-repeat;">&nbsp;</span>
                                </li>
                                -->
                            <?php } ?>
						</ul>
					</div>
					<div class="page_index">
					<br>
					<hr>
                        <!--?php include $hs_view_include_path.'page.inc';?-->
                        <?php if ($end != 1) { ?>
                            	<?php
	if($end > 0){
		if($current == 1){
			echo "<div class='page'><em>上一页&nbsp;</em>";
		}else{
			$pages = $current-1;
			echo "<div class='page'><a href='$url_page?p=$pages' >上一页&nbsp;</a>";
		}
		
		for($p = 1;$p <= $end;$p ++){
			if($p == $current){
				echo "<strong>$p</strong>&nbsp;";
			}else{
				echo "<a href='$url_page?p=$p' >$p&nbsp;</a>";
			}
		}
		if($current == $end){
			echo "<em>下一页&nbsp;</em></div>";
		}else{
			$pages = $current+1;
			echo "<a href='$url_page?p=$pages' >下一页&nbsp;</a></div>";
		}
	}
?>
                        <?php } ?>
					</div>
				</div>
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

	<!--?php include $hs_view_include_path.'footer.inc';?-->
	<footer>
			<p class="btn_gototop"><a href="#pagetop" onFocus="this.blur()" onClick="smoothScroll();return false;" onKeyPress="smoothScroll();return false;" title="このページのトップへ">このページのトップへ</a></p>

			<!-- <ul>
				<li><a href="/pc_topLogin_login.html">ログイン</a></li>
				<li><a href="/pc_cart_index.html">買い物カゴ</a></li>
				<li><a href="/pc_topMypage_index1.html">マイページ</a></li>
				<li><a href="/shop/etc/guide.html">ご利用案内</a></li>
				<li><a href="/shop/etc/privacy.html">プライバシーポリシー</a></li>
				<br clear="all">
			</ul>
			<ul class="line2nd">
				<li><a href="/pc_top_index.html">ホーム</a></li>
				<li><a href="/shop/etc/recruit.html">求人案内</a></li>
				<li><a href="/shop/etc/kyouhan.html">図書取扱店</a></li>
				<li><a href="/shop/etc/topics.html">トピックス</a></li>
				<li><a href="/shop/etc/profile.html">会社概要</a></li>
				<li><a href="/shop/etc/kojin.html">お問い合せ</a></li>
				<li><a href="/shop/etc/sitemap.html">サイトマップ</a></li>
				<br clear="all">
			</ul> -->
			<address>Copyright &copy; 2015 大连华思软件有限公司 / All Rights Reserved.</address>
</footer>

    <!-- 下载测试用form-->
    <form id="downloadform" method="post"></form>
</body>
        <script>
/*
        $(document).ready(function(){
            $.ajax({
                type: "post",
                url: "<?= $site_url ?>chat/rooms",
                dataType: "text",
                success: function (data) {
                    var rooms_list=jQuery.parseJSON(data);
                    var selObj = $("#chat_contents");
                    console.info(rooms_list.length);
                    for(i=0;i<rooms_list.length;i++){
                        if(rooms_list[i].indexOf("room_")>=0){

                            var value=rooms_list[i];
                            var text=rooms_list[i];
                            selObj.append("<option value='"+value+"'>"+text+"</option>");
                        }
                    }
                    //console.info(ccc);
                    //$("input#showTime").val(data[0].demoData);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
            $("#chat_contents").change(function(){

                $("#downloadform").attr("action","<?= $site_url ?>chat/backup?room_id="+$("#chat_contents").val());
                console.info($("#downloadform"));
                $("#downloadform").submit();
            });
        });
*/
        </script>
