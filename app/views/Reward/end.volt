{{ content() }}
<?php
include(APP_DIR."/config/link.php");
?>

<script>
    $(function(){
        $("#detail_mes4_submit").click(function(){
            var count = 0;
            $(":input[type='text']").each(function(){
                if(this.value){
                    count = count + parseFloat(this.value);
                }
            });
            if(count < 100){
                $.MsgBox.Alert("系统提示","请将您的奖金分配完全。");
            }
            if(count == 100){
                $('#forms').submit();
            }
        });
    })
    function changeText(user_id){
        var checkId = "checkbox_"+user_id;
        var textId = "text_"+user_id;
        if($('#'+checkId).prop('checked')){
            $("#"+textId).removeAttr("disabled");
        }else{
            $("#"+textId).val("");
            $("#"+textId).attr("disabled",true);
        }
    }
    function changeNum(user_id){
        var num = $('#text_'+user_id).val();
        if(num <= 0){
            $.MsgBox.Alert("系统提示",  "您分配的额度不能小于0。");
        }else{
            var count = 0;
            $(":input[type='text']").each(function(){
                if(this.value){
                    count = count + parseFloat(this.value);
                }
            });
            if(count > 100){
                $.MsgBox.Alert("系统提示","您分配的总额度超过了您的赏金。");
                $('#text_'+user_id).val("");
            }
        }
    }
</script>

<body>
<div id="wrapper">

    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>

    <section id="main">
        <ol id="pan">
            <li><a href="{{ site_url }}">返回首页</a></li>
            <li>任务结算</li>
        </ol>
        <div class="end_body">

            <div class="end_head">
                <li>发布人：<span style="color: red">{{ task_mes[0]['user_name'] }}</span></li>
                <li>任务金额：<span style="color: red">{{ task_mes[0]['pay_reward'] }}</span></li>
                <li>任务名称：<span style="color: red">{{ task_mes[0]['task_name'] }}</span></li>
                <li>参与预测师：<span style="color: red">
                        {% for answer in answers %}
                            {{ answer['user_name'] }}
                        {% endfor %}
                </span></li>
            </div>

            <div class="end_detail">
                <li>请选择你满意的预测师并为之分配赏金：</li>
                {{ form(site_url~'reward/end/'~task_mes[0]['task_id'], 'id':'forms', 'method': 'post', 'enctype': 'multipart/form-data') }}
                    <table>
                        {% if task_mes[0]['task_status'] == 2 %}
                            <tbody>
                                {% for answer in answers %}
                                    <tr>
                                        <td style="width: 10%">预测师：</td>
                                        {% if answer['flg'] %}
                                            <td style="color: red"><input type="checkbox" checked>{{ answer['user_name'] }}</td>
                                            <td><input type="text" value="{{ answer['ps_price'] }}" disabled ></td>
                                        {% else %}
                                            <td style="color: red"><input type="checkbox">{{ answer['user_name'] }}</td>
                                            <td><input type="text" value="" disabled ></td>
                                        {% endif %}
                                        <td style="width: 50%">{{ answer['content'] }}……</td>
                                    </tr>
                                {% endfor %}
                            </tbody>
                        {% else %}
                            <tbody>
                                {% for answer in answers %}
                                    <tr>
                                        <td style="width: 10%">预测师：</td>
                                        <td style="color: red"><input type="checkbox" id="checkbox_{{ answer['user_id'] }}" onclick="changeText({{ answer['user_id'] }})">{{ answer['user_name'] }}</td>
                                        <td><input type="text" name="{{ answer['user_id'] }}" class="" id="text_{{ answer['user_id'] }}" disabled onblur="changeNum({{ answer['user_id'] }})" onkeyup="value=value.replace(/[^\d]/g,'') ">%</td>
                                        <td style="width: 50%">{{ answer['content'] }}……</td>
                                    </tr>
                                {% endfor %}
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><input type="button" value="确定" class="btn btn-primary" id="detail_mes4_submit"></td>
                                    <td><input type="button" value="取消" class="btn btn-primary" id="detail_mes4_submit" onclick="cancel_end()"></td>
                                </tr>
                            </tbody>
                        {% endif %}
                    </table>
                </form>
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