<?php
        include(APP_DIR."/config/link.php");
?>
   {%- if (logged_in is empty) %}
        <script>
            var site_url='<?php echo $site_url?>'
            window.location.href=site_url+"session/login"
        </script>
   {% endif %}

   <!--<link rel="stylesheet" href="http://keleyi.com/keleyi/pmedia/jquery/ui/1.10.3/css/smoothness/jquery-ui.min.css" />-->
   <script>
   function showDialog(taskid)
   {
       $("#dialog").dialog({
           resizable: false,
           height: 240,
           width: 400,
           modal: true,
           buttons: {
               "确定": function () {
//                   window.location.href = "http:// ";
                   var aj = $.ajax( {
                       url:'<?php echo $site_url; ?>/reward/apply',// 跳转到 action
                       data:{
                           task_id : taskid,
                           apply_memo : $("#dialogContent").val()
//                           apply_time :  new Date()
                       },
                       type:'post',
                       cache:false,
                       dataType:'text',
                       success:function(data) {
                           if(data =="success" ){
                               alert("成功参与！");
                           }else{
                               alert("参与失败");
                           }
                       },
                       error : function() {
                           alert("异常！");
                       }
                   });

                   $(this).dialog("close");
               },
               "取消": function () {
                   $(this).dialog("close");
               }
           }
       });
       return false;
   }

   </script>
<body>
<div id="wrapper">
    <noscript>このサイトはJavaScriptがオンになっていないと正常に表示されません</noscript>
    <section id="main">
        <ol id="pan">
            <li><a href="{{ site_url }}">返回首页</a></li>
            <li>赏金求测一览</li>
        </ol>

        <form method="post" autocomplete="off">
        {{ content() }}
        <ul class="pager">
        </ul>
        {% if page %}
        {% for t_reward_tasks in page.items %}
            {% if loop.first %}
                <table class="table table-bordered table-striped" align="center">
                <thead>
                <tr>
                    <th style="width: 8%">任务名</th>
                    <th  style="width: 10%">用户名</th>
                    <th>任务介绍</th>
                    <th  style="width: 18%">赏金</th>
                    <th  style="width: 18%">发布时间</th>
                    <th colspan="2"  style="width: 38%">操作</th>
                </tr>
                </thead>
            {% endif %}
            <tbody>
            <tr>
                <td>{{ t_reward_tasks.task_name }}</td>
                {% if t_reward_tasks.t_user %}
                    <td>{{ t_reward_tasks.t_user.user_name }}</td>
                {% else %}
                    <td></td>
                {% endif %}
                <td>{{ t_reward_tasks.task_remark }}</td>
                {% if t_reward_tasks.pay_reward != null %}
                    <td>￥{{ t_reward_tasks.pay_reward }}</td>
                {% endif%}
                <td>{{ t_reward_tasks.insert_time }}</td>
                <td width="8%">{{ link_to(site_url~"reward/detail/" ~ t_reward_tasks.task_id, ' 详细', "class": "btn") }}</td>
                {% if tflg %}
                    <!--<td width="8%">{{ link_to("reward/accept/" ~ t_reward_tasks.task_id, ' 参与', "class": "btn", "onclick":"return(showDialog("~t_reward_tasks.task_id~"))")}} </td>-->
                {% else %}
                    <td width="8%">{{ link_to(site_url~"reward/edit/" ~ t_reward_tasks.task_id, ' 编辑', "class": "btn") }}</td>
                {% endif %}
            </tr>
            </tbody>
            {% if loop.last %}
            <tbody>
            <tr>
                <td colspan="10" align="right">
                    {{partial('include/page')}}
                </td>
            </tr>
            <tbody>
            </table>
            {% endif %}
            {% else %}
                No users are recorded
        {% endfor %}
        {% endif %}
    </section>

    <section id="r_clm">
        {% include "include/menu.volt" %}
    </section>
    <br clear="all">
<div id="dialog" title="对话框" style="display: none;overflow:visible;resize: none;">
    <textarea id="dialogContent" style="width: auto; min-width: 356px; max-height: none; height: 110px;" ></textarea>
</div>
</div>
<?php include $hs_view_include_path.'footer.inc';?>
</body>
