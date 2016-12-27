<?= $this->getContent() ?>
<?php
include(APP_DIR."/config/link.php");
?>

<script>
    function answer(answer_id1,answer_id2,answer_id3,answer_id4,answer_id5,level){
        var t_class = "detail_4_detail_" + answer_id1;
        $("#"+t_class).css('display','block');
        level += 1;
        $(".answer_id1_"+answer_id1).val(answer_id1);
        $(".answer_id2_"+answer_id1).val(answer_id2);
        $(".answer_id3_"+answer_id1).val(answer_id3);
        $(".answer_id4_"+answer_id1).val(answer_id4);
        $(".answer_id5_"+answer_id1).val(answer_id5);
        $(".level_"+answer_id1).val(level);
    }
    function cancel_answer(answer_id1){
        var t_class = "detail_4_detail_" + answer_id1;
        $("#"+t_class).css('display','none');
    }
    function task_answer(){
        $("#detail_4_detail_task").css('display','block');
        window.location.href = "#detail_4_detail_task";
    }
    function cancel_task(){
        $("#detail_4_detail_task").css('display','none');
    }
    function end_task(){
        window.open('<?= $site_url ?>reward/end','width=800,height=300');
    }
</script>

<body>
<div id="wrapper">

    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

    <section id="main">
        <ol id="pan">
            <li><a href="<?= $site_url ?>">返回首页</a></li>
            <li>赏金求测大厅</li>
        </ol>
        <div class="reward_body">

            <div class="detail_1">
                <div class="detail_1_img">
                    <img src="<?= $site_url ?>public/img/default_s.jpg" height="150px">
                </div>
                <div>
                    <li class="detail_1_li1"><span style="color: red"><?= $task_mes[0]['user_name'] ?></span> 发布的“<?= $task_mes[0]['task_name'] ?>” </li>
                    <li class="detail_1_li2">任务金额：<span style="color: red"><?= $task_mes[0]['pay_reward'] ?></span> 元  共收到 <span style="color: red"><?= $task_mes[0]['pro_cou'] ?></span> 个预测师交流</li>
                    <li class="detail_1_li3">由  <span style="color: red">
                            <?php foreach ($pro as $p) { ?>
                                <?= $p['user_name'] ?>
                            <?php } ?>
                            </span>  完成任务</li>
                </div>
                <div class="detail_2_mes_3">
                    <?php if (($task_mes[0]['task_status'] == 0 || $task_mes[0]['task_status'] == 1) && $pFlg) { ?>
                        <a href="<?= $site_url ?>reward/end/<?= $task_mes[0]['task_id'] ?>">任务结算</a>
                    <?php } elseif ($task_mes[0]['task_status'] == 2 && $pFlg) { ?>
                        <a href="<?= $site_url ?>reward/end/<?= $task_mes[0]['task_id'] ?>">查看结算</a>
                    <?php } ?>
                </div>
            </div>

            <div class="detail_2">
                <div class="detail_2_mes">
                    <div class="detail_2_mes_1">
                        <div style="overflow: auto;">
                            <div class="detail_1_img" style="width: 100px;">
                                <img src="<?= $site_url ?>public/img/default_s.jpg" style="width: 75px;height: 75px;">
                            </div>
                            <span class="detail_2_mes_1_mess"><?= $task_mes[0]['user_name'] ?>：<?= $task_mes[0]['task_name'] ?><br>
                            酬金： <span style="color: red"><?= $task_mes[0]['pay_reward'] ?></span> 元</span>
                        </div>
                        <div style="width: 100%">
                            <table style="width: 100%">
                                <tr>
                                    <td>编号：<?= $task_mes[0]['task_id'] ?></td>
                                    <td>分类：<?= $task_mes[0]['small_catagory_name'] ?></td>
                                </tr>
                                <tr>
                                   <!-- <td>浏览：104人</td>-->
                                    <td>已参加：<?= $task_mes[0]['pro_cou'] ?>人</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="detail_2_mes_2">
                        <?php if ($task_mes[0]['task_status'] == 2) { ?>
                            <div><img src="<?= $site_url ?>public/img/task/finished.png"></div>
                            <span>此任务已结束</span>
                        <?php } elseif ($task_mes[0]['task_status'] == 0) { ?>
                            <div><img src="<?= $site_url ?>public/img/task/ing.png"></div>
                            <span>进行中</span>
                        <?php } elseif ($task_mes[0]['task_status'] == 99) { ?>
                            <div><img src="<?= $site_url ?>public/img/task/waitting.png"></div>
                            <span>等待选稿</span>
                        <?php } ?>
                    </div>
                    <div class="detail_2_mes_3">
                        <?php if ($task_mes[0]['task_status'] == 0 || $task_mes[0]['task_status'] == 1) { ?>
                            <a href="javascript:task_answer()">解答此任务</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="detail_2_f">
                    <img src="<?= $site_url ?>public/img/task/task_<?= $task_mes[0]['task_status'] ?>.PNG">
                </div>
            </div>

            <div class="detail_3">
                <div class="detail_3_head">任务需求</div>
                <div class="detail_3_detail">
                    <?= $task_mes[0]['task_remark'] ?>
                </div>
                <div class="detail_3_table">
                    <table>
                        <tr><th>个人信息：</th></tr>
                        <tr><td>仅参与者可见（报名后可见） </td></tr>
                    </table>
                </div>
            </div>

            <div class="detail_4">
                <div class="detail_4_head">交流区</div>

                <?php foreach ($answers as $answer) { ?>
                    <div class="detail_4_detail">
                        <div class="detail_4_user">
                            <div>
                                <img src="<?= $site_url ?>public/img/default_s.jpg" style="width: 75px;height: 75px;">
                                <span><?= $answer['user_name'] ?></span>
                            </div>
                            <div>
                                <li>最后登录：<?= $answer['laslogin_time'] ?></li>
                                <li>总成交量：<?= $answer['sale_total'] ?></li>
                                <li>总好评率：<?= $answer['eval_percent'] ?></li>
                                <li>总成交指数：<?= $answer['sale_point'] ?></li>
                            </div>
                        </div>
                        <div class="detail_4_detail_mes">
                            <div class="detail_4_detail_mes1">交稿于：<?= $answer['c_time'] ?><a href="javascript:answer(<?= $answer['answer_id1'] ?>,<?= $answer['answer_id2'] ?>,<?= $answer['answer_id3'] ?>,<?= $answer['answer_id4'] ?>,<?= $answer['answer_id5'] ?>,<?= $answer['level'] ?>)">回复</a></div>
                            <?php if ($flg || $pFlg || $user_id == $answer['user_id']) { ?>
                                <div class="detail_4_detail_mes2">
                                    <?= $answer['content'] ?>
                                </div>
                                <?php if ($answer['sub_flg']) { ?>
                                    <?php foreach ($answer['subAnswer'] as $sub) { ?>
                                        <?php if ($sub['level'] == 1) { ?>
                                            <?php $span_style = 'text-indent: 2em;'; ?>
                                        <?php } elseif ($sub['level'] == 2) { ?>
                                            <?php $span_style = 'text-indent: 4em;'; ?>
                                        <?php } elseif ($sub['level'] == 3) { ?>
                                            <?php $span_style = 'text-indent: 6em;'; ?>
                                        <?php } else { ?>
                                            <?php $span_style = 'text-indent: 8em;'; ?>
                                        <?php } ?>
                                        <?php if ($sub['user_id'] != $answer['user_id']) { ?>
                                            <div class="detail_4_detail_mes3">
                                                <span style="color: #0000ff;<?= $span_style ?>"><?= $sub['c_time'] ?> <?= $sub['user_name'] ?>：<?= $sub['content'] ?></span>
                                                <?php if ($sub['level'] < 4) { ?>
                                                    <a href="javascript:answer(<?= $sub['answer_id1'] ?>,<?= $sub['answer_id2'] ?>,<?= $sub['answer_id3'] ?>,<?= $sub['answer_id4'] ?>,<?= $sub['answer_id5'] ?>,<?= $sub['level'] ?>)">回复</a>
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="detail_4_detail_mes3">
                                                <span style="color: red;<?= $span_style ?>"><?= $sub['c_time'] ?> <?= $sub['user_name'] ?>：<?= $sub['content'] ?></span>
                                                <?php if ($sub['level'] < 4) { ?>
                                                    <a href="javascript:answer(<?= $sub['answer_id1'] ?>,<?= $sub['answer_id2'] ?>,<?= $sub['answer_id3'] ?>,<?= $sub['answer_id4'] ?>,<?= $sub['answer_id5'] ?>,<?= $sub['level'] ?>)">回复</a>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <div class="detail_4_detail_mes3">
                                        任务主评价：未做评价
                                    </div>
                                <?php } ?>
                                <div class="detail_4_detail_form" id="detail_4_detail_<?= $answer['answer_id1'] ?>" style="display: none">
                                    <?= $this->tag->form([$site_url . 'reward/detail/' . $answer['task_id'], 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
                                        <input type="hidden" class="status" name="status" value="1">
                                        <input type="hidden" class="answer_id1_<?= $answer['answer_id1'] ?>" name="answer_id1" value="">
                                        <input type="hidden" class="answer_id2_<?= $answer['answer_id1'] ?>" name="answer_id2" value="">
                                        <input type="hidden" class="answer_id3_<?= $answer['answer_id1'] ?>" name="answer_id3" value="">
                                        <input type="hidden" class="answer_id4_<?= $answer['answer_id1'] ?>" name="answer_id4" value="">
                                        <input type="hidden" class="answer_id5_<?= $answer['answer_id1'] ?>" name="answer_id5" value="">
                                        <input type="hidden" class="level_<?= $answer['answer_id1'] ?>" name="level" value="">
                                        <textarea type="text" class="detail_4_area_<?= $answer['answer_id1'] ?>" name="content"></textarea>
                                        <input type="submit" value="确定" class="btn btn-primary" id="detail_mes4_submit">
                                        <input type="button" value="取消" class="btn btn-primary" id="detail_mes4_submit" onclick="cancel_answer(<?= $answer['answer_id1'] ?>)">
                                    </form>
                                </div>
                            <?php } else { ?>
                                <div class="detail_4_detail_mes2" style="color: red">
                                    已隐藏，仅参与者与发布者可见。
                                </div>
                                <div class="detail_4_detail_mes3" style="text-indent: 1em;color: red">
                                    已隐藏，仅参与者与发布者可见。
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <div class="detail_4_detail" id="detail_4_detail_task" style="display: none">
                    <?= $this->tag->form([$site_url . 'reward/detail/' . $task_id, 'method' => 'post', 'enctype' => 'multipart/form-data']) ?>
                        <input type="hidden" class="status" name="status" value="0">
                        <textarea type="text" name="content"></textarea>
                        <input type="submit" value="确定" class="btn btn-primary" id="detail_mes4_submit">
                        <input type="button" value="取消" class="btn btn-primary" id="detail_mes4_submit" onclick="cancel_task()">
                    </form>
                </div>
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
