

{%- if (logged_in is empty) %}
       <script>window.location.href="/session/login"</script>
 {% endif %}
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("reward/search", "&larr; Go Back") }}
    </li>
</ul>

{{ content() }}
 <h1>任务详细</h1>
        <div style="border-top:5px solid #000;width:950px;height:20px;"> </div>
<div class="center scaffold">
{% if reward %}
<div class="tabbable">

                <table>
                    <tr>
                        <td width=100px><label for="user_name">发布人: </label></td>
                        {% if reward.t_user %}
                                 <td>{{ form.render("user_name",["value": reward.t_user.user_name,"disabled": "true"]) }}</td>
                        {% else %}
                                 <td>{{ form.render("user_name") }}</td>
                        {% endif %}
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="task_name">任务名: </label></td>
                        <td>{{ form.render("task_name",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="big_catagory">大分类: </label></td>
                        <td>{{ form.render("big_catagory",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="small_catagory">小分类: </label></td>
                        <td>{{ form.render("small_catagory",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="task_remark">任务介绍: </label></td>
                        <td>{{ form.render("task_remark",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="pay_type">赏金类型: </label></td>
                        {% if reward.m_common %}
                                 <td>{{ form.render("item_name",["value": reward.m_common.item_name,"disabled": "true"]) }}</td>
                        {% else %}
                                 <td>{{ form.render("item_name",["disabled": "true"]) }}</td>
                        {% endif %}
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="pay_reward">赏金: </label></td>
                        <td>{{ form.render("pay_reward",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="time_limit">期限: </label></td>
                        <td>{{ form.render("time_limit",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="other_remark">备注: </label></td>
                        <td>{{ form.render("other_remark",["disabled": "true"]) }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label for="other_remark">提供材料1: </label></td>
                        <td>{{ form.render("file1_path",["disabled": "true"]) }}</td>
                        <td>{{ link_to("reward/download?taskid="~ reward.task_id ~"&file=1", '<i class="icon-pencil"></i> 下载', "class": "btn") }}</td>
                    </tr>

                    <tr>
                        <td><label for="other_remark">提供材料2: </label></td>
                        <td>{{ form.render("file2_path",["disabled": "true"]) }}</td>
                        <td>{{ link_to("reward/download?taskid="~ reward.task_id ~"&file=2", '<i class="icon-pencil"></i> 下载', "class": "btn") }}</td>
                    </tr>

                    <tr>
                        <td><label for="other_remark">提供材料3: </label></td>
                        <td>{{ form.render("file3_path",["disabled": "true"]) }}</td>
                        <td>{{ link_to("reward/download?taskid="~ reward.task_id ~"&file=3", '<i class="icon-pencil"></i> 下载', "class": "btn") }}</td>
                    </tr>
                    </table>

</div>
{% endif %}

</div>