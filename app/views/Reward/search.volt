{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<link rel="stylesheet" type="text/css" href="http://127.0.0.1:8080/bbs_new/public/css/new.css">



<body>
<div id="wrapper">

    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

    <section id="main">
        <ol id="pan">
            <li><a href="{{ site_url }}">返回首页</a></li>
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
                        {% for head in reward_head %}
                            <tr>
                                {% for line in head %}
                                    <td><span>￥{{ line['pay_reward'] }}</span> <a href="{{ site_url }}reward/detail/{{ line['task_id'] }}">{{ line['task_name'] }}</a></td>
                                {% endfor %}
                            </tr>
                        {% endfor %}
                        <!--tr>
                            <td><span>￥150</span> <a href="{{ site_url }}reward/detail/1">求测工作和婚姻</a></td>
                            <td><span>￥100</span> <a href="{{ site_url }}reward/detail/1">人生运势</a></td>
                            <td><span>￥50</span> <a href="{{ site_url }}reward/detail/1">8月份试用期是否能过？</a></td>
                        </tr>
                        <tr>
                            <td><span>￥250</span> <a href="{{ site_url }}reward/detail/1">请看最近5年事业财运方面</a></td>
                            <td><span>￥150</span> <a href="{{ site_url }}reward/detail/1">请帮忙测定结婚吉日</a></td>
                            <td><span>￥150</span> <a href="{{ site_url }}reward/detail/1">请大师帮我测:两人能否成婚合婚</a></td>
                        </tr>
                        <tr>
                            <td><span>￥350</span> <a href="{{ site_url }}reward/detail/1">明天出行，问下半年运势。</a></td>
                            <td><span>￥100</span> <a href="{{ site_url }}reward/detail/1">婚恋感情</a></td>
                            <td><span>￥150</span> <a href="{{ site_url }}reward/detail/1">下半年运势</a></td>
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
                        {% for task in reward_task %}
                            <tr>
                                <td>{{ task['task_id'] }}</td>
                                <td><a href="{{ site_url }}reward/detail/{{ task['task_id'] }}">{{ task['task_name'] }}</a></td>
                                <td class="red">￥{{ task['pay_reward'] }}</td>
                                <td>{{ task['small_catagory_name'] }}</td>
                                <td>{{ task['pro_cou'] }}</td>
                                <td>{{ task['draft_cou'] }}</td>
                                <td>{{ task['insert_time'] }}</td>
                                <td>{{ task['time_limit'] }}</td>
                                {% if task['task_status'] == 0 %}
                                    <td class="red">进行中</td>
                                {% elseif task['task_status'] == 2 %}
                                    <td class="red">已完成</td>
                                {% elseif task['task_status'] == 3 %}
                                    <td class="red">超时</td>
                                {% else %}
                                    <td class="red">取消</td>
                                {% endif %}

                            </tr>
                        {% endfor %}
                        <!--tr>
                            <td>1505041</td>
                            <td><a href="{{ site_url }}reward/detail/1">求测婚姻</a></td>
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
                            <td><a href="{{ site_url }}reward/detail/1">人生运势</a></td>
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
                            <td><a href="{{ site_url }}reward/detail/1">测定结婚吉日</a></td>
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
                            <td><a href="{{ site_url }}reward/detail/1">求测工作</a></td>
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
                            <td><a href="{{ site_url }}reward/detail/1">求测工作</a></td>
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
                            <td><a href="{{ site_url }}reward/detail/1">问下半年运势</a></td>
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
                {% if end != 1 %}
                    {% include "include/page.inc" %}
                {% endif %}
            </div>
        </div>
    </section>

    <section id="r_clm">
        {% include "include/menu.volt" %}

    </section>
    <br clear="all">

</div>

<?php include $hs_view_include_path.'footer.inc';?>
</body>
