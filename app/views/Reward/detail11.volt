
{{ content() }}
<?php
    include(APP_DIR."/config/link.php");
?>
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
                        url:'{{site_url}}reward/apply',// 跳转到 action
                        data:{
                            task_id : taskid,
                            apply_memo : $("#dialogContent").val()
//                           apply_time :  new Date()
                        },
                        type:'post',
                        cache:false,
                        dataType:'text',
                        success:function(data) {
                           // if(data =="success" ){
                               if( data.indexOf("success") >= 0){
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
				<li>赏金求测详细</li>
			</ol>
             {%- if (logged_in is empty) %}
                <script>
                    var site_url='<?php echo $site_url?>'
                    window.location.href=site_url+"session/login"
                </script>
             {% endif %}
             <ul class="pager">
                <li class="previous pull-left">
                    {{ link_to("reward/search", "&larr; Go Back") }}
                </li>
             </ul>
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
                            <td>{{ link_to(site_url~"reward/download?taskid="~ reward.task_id ~"&file=1", '<i class="icon-pencil"></i> 下载', "class": "btn") }}</td>
                        </tr>
                        <tr>
                            <td><label for="other_remark">提供材料2: </label></td>
                            <td>{{ form.render("file2_path",["disabled": "true"]) }}</td>
                            <td>{{ link_to(site_url~"reward/download?taskid="~ reward.task_id ~"&file=2", '<i class="icon-pencil"></i> 下载', "class": "btn") }}</td>
                        </tr>
                        <tr>
                            <td><label for="other_remark">提供材料3: </label></td>
                            <td>{{ form.render("file3_path",["disabled": "true"]) }}</td>
                            <td>{{ link_to("reward/download?taskid="~ reward.task_id ~"&file=3", '<i class="icon-pencil"></i> 下载', "class": "btn") }}</td>
                        </tr>
                        </table>
                 {% if tflg %}
                 <div>{{ link_to(site_url~"reward/detail?taskid="~ reward.task_id, '参与', "class": "btn", "onclick":"return(showDialog("~reward.task_id~"))") }}</div>
                {% endif %}
                 <div id="dialog" title="对话框" style="display: none;overflow:visible;resize: none;">
                     <textarea id="dialogContent" style="width: auto; min-width: 356px; max-height: none; height: 110px;" ></textarea>
                 </div>
                 </div>

                 {% if userShow %}
                  <div id = "dApplyMsg">
                  </br>
                   <h1 style="font-size:24px">预测师申请一览</h1>
                   </br>
                    <table  id="tApplyMsg" name="tApplyMsg" border="1" bordercolor="#FFC8B4" style="border-collapse:collapse;width:80%">
                  {% if page %}
                       {% for trMessage in page.items %}
                            <tbody>
                                     <tr bgcolor="#FFC8B4">
                                         <td width=30%>预测师：{{trMessage.mst_user.user_name}}</td>
                                         <td width=60%>申请日：{{trMessage.apply_time}}</td>
                                         <td style="vertical-align:middle; text-align:center;">{{ link_to(site_url~"reward/test?task_id="~ reward.task_id ~"&ps_user_id="~ trMessage.ps_user_id, '<i class="icon-pencil"></i> 测试', "class": "btn") }}</td>
                                      </tr>
                                      <tr>
                                          <td colspan=3>{{trMessage.apply_memo}}</td>
                                      </tr>
                          </tbody>
                          {% if loop.last %}
                              <tbody>
                                  <tr>
                                      <td colspan="3" align="right">
                                          {{partial('include/page')}}
                                      </td>
                                  </tr>
                              <tbody>

                          {% endif %}
                  {% else %}
                           <tr>
                               <td colspan=3>暂无预测师申请测试！</td>
                           </tr>
                  {% endfor %}
                  {% endif %}
                   </table>
                  </div>
                  {% endif %}
                  {% endif %}
             </div>
		</section>
		<section id="r_clm">
			{% include "include/menu.volt" %}
		</section>
		<br clear="all">
	</div>
		<?php include $hs_view_include_path.'footer.inc';?>
</body>
