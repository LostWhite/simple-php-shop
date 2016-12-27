
			<h4>Menu1</h4>
			<ul id="info">
				<li><a href="{{ site_url }}user">个 人 中 心<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
                    <li><a href="{{ site_url }}prophet/index">预 测 师 管 理<span></span></a></li>
                     <li><a href="{{ site_url }}chat/index">交 谈 管 理 <span></span></a></li>
                <?php }else{?>
                    <li><a href="{{ site_url }}user/apply">申 请 预 测 师<span></span></a></li>
                <?php }?>
                <li><a href="{{ site_url }}reward/search">赏 金 求 测 大 厅<span></span></a></li>
				<li><a href="{{ site_url }}money/recharge/1">购 买 算 卦 币<span></span></a></li>
                <li><a href="{{ site_url }}reward/public">发 布 赏 金 求 测<span></span></a></li>
                <li><a href="">百 家 争 鸣<span></span></a></li>
                <li><a href="{{ site_url }}order/orders">我 的 订 单<span></span></a></li>
                <!--li><a href="{{ site_url }}chat/teacher">试 测 验 证<span></span></a></li-->
				<li><a href="{{ site_url }}prophet/browse">预 测 师 随 笔<span></span></a></li>
                <?php if(isset($_SESSION['prophet_flg'])&&$_SESSION['prophet_flg']==1){?>
				    <li><a href="{{ site_url }}article/particle">写 随 笔<span></span></a></li>
                <?php }?>
                <li><a href="{{ site_url }}message/information?status=1">意 见 反 馈<span></span></a></li>
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