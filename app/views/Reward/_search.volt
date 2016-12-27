{%- if (logged_in is empty) %}
       <script>window.location.href="/session/login"</script>
 {% endif %}
<form method="post" autocomplete="off">

{{ content() }}
 <h1>赏金任务一览</h1>
        <div style="border-top:5px solid #000;width:950px;height:20px;"> </div>
<ul class="pager">
</ul>

{% for t_reward_tasks in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>任务ID</th>
            <th>用户名</th>
            <th>任务介绍</th>
            <th>赏金</th>
            <th>备注</th>
            <th>发布时间</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ t_reward_tasks.task_id }}</td>
{% if t_reward_tasks.t_user %}
            <td>{{ t_reward_tasks.t_user.user_name }}</td>
            {% else %}
             <td></td>
{% endif %}
            <td>{{ t_reward_tasks.task_remark }}</td>
            <td>{{ t_reward_tasks.pay_reward }}</td>
            <td>{{ t_reward_tasks.other_remark }}</td>
            <td>{{ t_reward_tasks.insert_time }}</td>
            <td width="8%">{{ link_to("reward/detail/" ~ t_reward_tasks.task_id, ' Detail', "class": "btn") }}</td>
            <td width="8%">{{ link_to("reward/accept/" ~ t_reward_tasks.task_id, ' Accept', "class": "btn") }}</td>
            <td width="8%">{{ link_to("reward/edit/" ~ t_reward_tasks.task_id, ' Edit', "class": "btn") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
            <td colspan="10" align="right">
                <div class="btn-group">
                    {{ link_to("reward/search", '<i class="icon-fast-backward"></i> First', "class": "btn") }}
                    {{ link_to("reward/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn ") }}
                    {{ link_to("reward/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn") }}
                    {{ link_to("reward/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No users are recorded
{% endfor %}
