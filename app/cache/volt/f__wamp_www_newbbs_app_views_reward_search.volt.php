<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<link rel="stylesheet" type="text/css" href="http://127.0.0.1:8080/bbs_new/public/css/new.css">



<body>
<div id="wrapper">

    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

    <section id="main">
        <ol id="pan">
            <li><a href="<?= $site_url ?>">返回首页</a></li>
            <li>赏金求测大厅</li>
        </ol>
        <div class="reward_body">
            <div class="reward_head">
                <table>
                    <tbody>
                        <tr>
                            <td>热门任务</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php foreach ($reward_head as $head) { ?>
                            <tr>
                                <?php foreach ($head as $line) { ?>
                                    <td><span>￥<?= $line['pay_reward'] ?></span> <a href="<?= $site_url ?>reward/detail/<?= $line['task_id'] ?>"><?= $line['task_name'] ?></a></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        <!--tr>
                            <td><span>￥150</span> <a href="<?= $site_url ?>reward/detail/1">求测工作和婚姻</a></td>
                            <td><span>￥100</span> <a href="<?= $site_url ?>reward/detail/1">人生运势</a></td>
                            <td><span>￥50</span> <a href="<?= $site_url ?>reward/detail/1">8月份试用期是否能过？</a></td>
                        </tr>
                        <tr>
                            <td><span>￥250</span> <a href="<?= $site_url ?>reward/detail/1">请看最近5年事业财运方面</a></td>
                            <td><span>￥150</span> <a href="<?= $site_url ?>reward/detail/1">请帮忙测定结婚吉日</a></td>
                            <td><span>￥150</span> <a href="<?= $site_url ?>reward/detail/1">请大师帮我测:两人能否成婚合婚</a></td>
                        </tr>
                        <tr>
                            <td><span>￥350</span> <a href="<?= $site_url ?>reward/detail/1">明天出行，问下半年运势。</a></td>
                            <td><span>￥100</span> <a href="<?= $site_url ?>reward/detail/1">婚恋感情</a></td>
                            <td><span>￥150</span> <a href="<?= $site_url ?>reward/detail/1">下半年运势</a></td>
                        </tr-->
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table-striped">
                    <tbody>
                        <tr>
                            <th>任务号</th>
                            <th>任务标题</th>
                            <th>金额</th>
                            <th>类别</th>
                            <th>报名数</th>
                            <th>交稿数</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>状态</th>
                        </tr>
                        <?php foreach ($reward_task as $task) { ?>
                            <tr>
                                <td><?= $task['task_id'] ?></td>
                                <td><a href="<?= $site_url ?>reward/detail/<?= $task['task_id'] ?>"><?= $task['task_name'] ?></a></td>
                                <td class="red">￥<?= $task['pay_reward'] ?></td>
                                <td><?= $task['small_catagory_name'] ?></td>
                                <td><?= $task['pro_cou'] ?></td>
                                <td><?= $task['draft_cou'] ?></td>
                                <td><?= $task['insert_time'] ?></td>
                                <td><?= $task['time_limit'] ?></td>
                                <?php if ($task['task_status'] == 0) { ?>
                                    <td class="red">进行中</td>
                                <?php } elseif ($task['task_status'] == 2) { ?>
                                    <td class="red">已完成</td>
                                <?php } elseif ($task['task_status'] == 3) { ?>
                                    <td class="red">超时</td>
                                <?php } else { ?>
                                    <td class="red">取消</td>
                                <?php } ?>

                            </tr>
                        <?php } ?>
                        <!--tr>
                            <td>1505041</td>
                            <td><a href="<?= $site_url ?>reward/detail/1">求测婚姻</a></td>
                            <td class="red">￥100</td>
                            <td>人生运势</td>
                            <td>11</td>
                            <td>5</td>
                            <td>2015-05-04</td>
                            <td>2015-06-01</td>
                            <td class="red">已完成</td>
                        </tr>
                        <tr>
                            <td>1505031</td>
                            <td><a href="<?= $site_url ?>reward/detail/1">人生运势</a></td>
                            <td class="red">￥100</td>
                            <td>人生运势</td>
                            <td>11</td>
                            <td>5</td>
                            <td>2015-05-04</td>
                            <td>2015-06-01</td>
                            <td class="red">已完成</td>
                        </tr>
                        <tr>
                            <td>1505111</td>
                            <td><a href="<?= $site_url ?>reward/detail/1">测定结婚吉日</a></td>
                            <td class="red">￥100</td>
                            <td>婚恋感情</td>
                            <td>11</td>
                            <td>5</td>
                            <td>2015-05-04</td>
                            <td>2015-06-01</td>
                            <td class="red">已完成</td>
                        </tr>
                        <tr>
                            <td>1505042</td>
                            <td><a href="<?= $site_url ?>reward/detail/1">求测工作</a></td>
                            <td class="red">￥100</td>
                            <td>婚恋感情</td>
                            <td>11</td>
                            <td>5</td>
                            <td>2015-05-04</td>
                            <td>2015-06-01</td>
                            <td class="red">已完成</td>
                        </tr>
                        <tr>
                            <td>1505046</td>
                            <td><a href="<?= $site_url ?>reward/detail/1">求测工作</a></td>
                            <td class="red">￥100</td>
                            <td>人生运势</td>
                            <td>11</td>
                            <td>5</td>
                            <td>2015-05-04</td>
                            <td>2015-06-01</td>
                            <td class="red">已完成</td>
                        </tr>
                        <tr>
                            <td>1505048</td>
                            <td><a href="<?= $site_url ?>reward/detail/1">问下半年运势</a></td>
                            <td class="red">￥100</td>
                            <td>人生运势</td>
                            <td>11</td>
                            <td>5</td>
                            <td>2015-05-04</td>
                            <td>2015-06-01</td>
                            <td class="red">已完成</td>
                        </tr-->
                    </tbody>
                </table>
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
