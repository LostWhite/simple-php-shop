{{ content() }}
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
        window.open('{{ site_url }}reward/end','width=800,height=300');
    }
</script>

<body>
<div id="wrapper">

    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

    <section id="main">
        <ol id="pan">
            <li><a href="{{ site_url }}">返回首页</a></li>
            <li>赏金求测大厅</li>
        </ol>
        <div class="reward_body">

            <div class="detail_1">
                <div class="detail_1_img">
                    <img src="{{ site_url }}public/img/default_s.jpg" height="150px">
                </div>
                <div>
                    <li class="detail_1_li1"><span style="color: red">{{ task_mes[0]['user_name'] }}</span> 发布的“{{ task_mes[0]['task_name'] }}” </li>
                    <li class="detail_1_li2">任务金额：<span style="color: red">{{ task_mes[0]['pay_reward'] }}</span> 元  共收到 <span style="color: red">{{ task_mes[0]['pro_cou'] }}</span> 个预测师交流</li>
                    <li class="detail_1_li3">由  <span style="color: red">
                            {% for p in pro %}
                                {{ p['user_name'] }}
                            {% endfor %}
                            </span>  完成任务</li>
                </div>
                <div class="detail_2_mes_3">
                    {% if (task_mes[0]['task_status'] == 0 or task_mes[0]['task_status'] == 1) and pFlg %}
                        <a href="{{ site_url }}reward/end/{{ task_mes[0]['task_id'] }}">任务结算</a>
                    {% elseif task_mes[0]['task_status'] == 2 and pFlg %}
                        <a href="{{ site_url }}reward/end/{{ task_mes[0]['task_id'] }}">查看结算</a>
                    {% endif %}
                </div>
            </div>

            <div class="detail_2">
                <div class="detail_2_mes">
                    <div class="detail_2_mes_1">
                        <div style="overflow: auto;">
                            <div class="detail_1_img" style="width: 100px;">
                                <img src="{{ site_url }}public/img/default_s.jpg" style="width: 75px;height: 75px;">
                            </div>
                            <span class="detail_2_mes_1_mess">{{ task_mes[0]['user_name'] }}：{{ task_mes[0]['task_name'] }}<br>
                            酬金： <span style="color: red">{{ task_mes[0]['pay_reward'] }}</span> 元</span>
                        </div>
                        <div style="width: 100%">
                            <table style="width: 100%">
                                <tr>
                                    <td>编号：{{ task_mes[0]['task_id'] }}</td>
                                    <td>分类：{{ task_mes[0]['small_catagory_name'] }}</td>
                                </tr>
                                <tr>
                                   <!-- <td>浏览：104人</td>-->
                                    <td>已参加：{{ task_mes[0]['pro_cou'] }}人</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="detail_2_mes_2">
                        {% if task_mes[0]['task_status'] == 2 %}
                            <div><img src="{{ site_url }}public/img/task/finished.png"></div>
                            <span>此任务已结束</span>
                        {% elseif task_mes[0]['task_status'] == 0 %}
                            <div><img src="{{ site_url }}public/img/task/ing.png"></div>
                            <span>进行中</span>
                        {% elseif task_mes[0]['task_status'] == 99 %}
                            <div><img src="{{ site_url }}public/img/task/waitting.png"></div>
                            <span>等待选稿</span>
                        {% endif %}
                    </div>
                    <div class="detail_2_mes_3">
                        {% if task_mes[0]['task_status'] == 0 or task_mes[0]['task_status'] == 1 %}
                            <a href="javascript:task_answer()">解答此任务</a>
                        {% endif %}
                    </div>
                </div>
                <div class="detail_2_f">
                    <img src="{{ site_url }}public/img/task/task_{{ task_mes[0]['task_status'] }}.PNG">
                </div>
            </div>

            <div class="detail_3">
                <div class="detail_3_head">任务需求</div>
                <div class="detail_3_detail">
                    {{ task_mes[0]['task_remark'] }}
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

                {% for answer in answers %}
                    <div class="detail_4_detail">
                        <div class="detail_4_user">
                            <div>
                                <img src="{{ site_url }}public/img/default_s.jpg" style="width: 75px;height: 75px;">
                                <span>{{ answer['user_name'] }}</span>
                            </div>
                            <div>
                                <li>最后登录：{{ answer['laslogin_time'] }}</li>
                                <li>总成交量：{{ answer['sale_total'] }}</li>
                                <li>总好评率：{{ answer['eval_percent'] }}</li>
                                <li>总成交指数：{{ answer['sale_point'] }}</li>
                            </div>
                        </div>
                        <div class="detail_4_detail_mes">
                            <div class="detail_4_detail_mes1">交稿于：{{ answer['c_time'] }}<a href="javascript:answer({{ answer['answer_id1'] }},{{ answer['answer_id2'] }},{{ answer['answer_id3'] }},{{ answer['answer_id4'] }},{{ answer['answer_id5'] }},{{ answer['level'] }})">回复</a></div>
                            {% if flg or pFlg or user_id == answer['user_id'] %}
                                <div class="detail_4_detail_mes2">
                                    {{ answer['content'] }}
                                </div>
                                {% if answer['sub_flg'] %}
                                    {% for sub in answer['subAnswer'] %}
                                        {% if sub['level'] == 1 %}
                                            {% set span_style = 'text-indent: 2em;' %}
                                        {% elseif sub['level'] == 2 %}
                                            {% set span_style = 'text-indent: 4em;' %}
                                        {% elseif sub['level'] == 3 %}
                                            {% set span_style = 'text-indent: 6em;' %}
                                        {% else %}
                                            {% set span_style = 'text-indent: 8em;' %}
                                        {% endif %}
                                        {% if sub['user_id'] != answer['user_id'] %}
                                            <div class="detail_4_detail_mes3">
                                                <span style="color: #0000ff;{{ span_style }}">{{ sub['c_time'] }} {{ sub['user_name'] }}：{{ sub['content'] }}</span>
                                                {% if sub['level'] < 4 %}
                                                    <a href="javascript:answer({{ sub['answer_id1'] }},{{ sub['answer_id2'] }},{{ sub['answer_id3'] }},{{ sub['answer_id4'] }},{{ sub['answer_id5'] }},{{ sub['level'] }})">回复</a>
                                                {% endif %}
                                            </div>
                                        {% else %}
                                            <div class="detail_4_detail_mes3">
                                                <span style="color: red;{{ span_style }}">{{ sub['c_time'] }} {{ sub['user_name'] }}：{{ sub['content'] }}</span>
                                                {% if sub['level'] < 4 %}
                                                    <a href="javascript:answer({{ sub['answer_id1'] }},{{ sub['answer_id2'] }},{{ sub['answer_id3'] }},{{ sub['answer_id4'] }},{{ sub['answer_id5'] }},{{ sub['level'] }})">回复</a>
                                                {% endif %}
                                            </div>
                                        {% endif %}
                                    {% endfor %}
                                {% else %}
                                    <div class="detail_4_detail_mes3">
                                        任务主评价：未做评价
                                    </div>
                                {% endif %}
                                <div class="detail_4_detail_form" id="detail_4_detail_{{ answer['answer_id1'] }}" style="display: none">
                                    {{ form(site_url~'reward/detail/'~answer['task_id'],  'method': 'post', 'enctype': 'multipart/form-data') }}
                                        <input type="hidden" class="status" name="status" value="1">
                                        <input type="hidden" class="answer_id1_{{ answer['answer_id1'] }}" name="answer_id1" value="">
                                        <input type="hidden" class="answer_id2_{{ answer['answer_id1'] }}" name="answer_id2" value="">
                                        <input type="hidden" class="answer_id3_{{ answer['answer_id1'] }}" name="answer_id3" value="">
                                        <input type="hidden" class="answer_id4_{{ answer['answer_id1'] }}" name="answer_id4" value="">
                                        <input type="hidden" class="answer_id5_{{ answer['answer_id1'] }}" name="answer_id5" value="">
                                        <input type="hidden" class="level_{{ answer['answer_id1'] }}" name="level" value="">
                                        <textarea type="text" class="detail_4_area_{{ answer['answer_id1'] }}" name="content"></textarea>
                                        <input type="submit" value="确定" class="btn btn-primary" id="detail_mes4_submit">
                                        <input type="button" value="取消" class="btn btn-primary" id="detail_mes4_submit" onclick="cancel_answer({{ answer['answer_id1'] }})">
                                    </form>
                                </div>
                            {% else %}
                                <div class="detail_4_detail_mes2" style="color: red">
                                    已隐藏，仅参与者与发布者可见。
                                </div>
                                <div class="detail_4_detail_mes3" style="text-indent: 1em;color: red">
                                    已隐藏，仅参与者与发布者可见。
                                </div>
                            {% endif %}
                        </div>
                    </div>
                {% endfor %}

                <div class="detail_4_detail" id="detail_4_detail_task" style="display: none">
                    {{ form(site_url~'reward/detail/'~task_id,  'method': 'post', 'enctype': 'multipart/form-data') }}
                        <input type="hidden" class="status" name="status" value="0">
                        <textarea type="text" name="content"></textarea>
                        <input type="submit" value="确定" class="btn btn-primary" id="detail_mes4_submit">
                        <input type="button" value="取消" class="btn btn-primary" id="detail_mes4_submit" onclick="cancel_task()">
                    </form>
                </div>
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
