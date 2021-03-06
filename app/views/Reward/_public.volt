{{ content() }}

        <?php
                include(APP_DIR."/config/link.php");
                ?>
{%- if (logged_in is empty) %}
       <script>window.location.href="/session/login"</script>
 {% endif %}
<!--form method="post"  autocomplete="off"-->
{{ form('reward/public',  'method': 'post', 'enctype': 'multipart/form-data') }}
    <div class="center scaffold">

        <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;预测任务</h2>
        <div >
            <!-- <span for="id">ID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>-->
             <!--   <span> {{auth.getIdentity()['id'] }}<span>-->
      <!--  {{ form.render("user_id",["value":auth.getIdentity()['id'],"disabled":"true"]) }}-->
        </div>
        <input type="hidden" id="user_id" name="user_id" value={{auth.getIdentity()['id']}}>
        <div class="clearfix">
            <span for="task_name">任务名&nbsp;&nbsp;&nbsp;&nbsp;</span>
            {{ form.render("task_name") }}
        </div>
         <div class="clearfix">
          <span for="big_catagory">大分类&nbsp;&nbsp;&nbsp;&nbsp;</span>
          {{ form.render("big_catagory") }}
       </div>

          <div class="clearfix">
           <span for="small_catagory">小分类&nbsp;&nbsp;&nbsp;&nbsp;</span>
           {{ form.render("small_catagory") }}
        </div>
         <div class="clearfix">
            <span for="task_remark">任务介绍&nbsp;</span>
            {{ form.render("task_remark") }}
        </div>
          <div class="clearfix">
             <span for="pay_reward">赏金类型&nbsp;</span>
             {{ form.render("pay_type") }}
         </div>
         <div class="clearfix">
             <span for="pay_reward">赏金&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
             {{ form.render("pay_reward") }}
          </div>
           <div class="clearfix">
              <span for="other_remark">备注&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              {{ form.render("other_remark") }}
          </div>
        <div class="clearfix">
             <span for="time_limit">期限&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
             {{ form.render("time_limit") }}
         </div>

        <div class="clearfix">
             <label for="file">提供材料(文件的大小不能超过3M)</label>
              <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
             {{ form.render("fileName") }}
         </div>
         <div class="clearfix">
          <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
              {{ form.render("fileName2") }}
          </div>
          <div class="clearfix">
          <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
               {{ form.render("fileName3") }}
           </div>

        <div class="clearfix">
        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            {{ submit_button("Save", "class": "btn btn-primary") }}
        </div>

    </div>

</form>

<script>
$(document).ready(function(){

    $('#big_catagory').bind('change',function(){

        var pid = $('#big_catagory').val();
         if(pid>0)
         {
             $.ajax( {
                url:'/reward/smallClass/'+pid,// 跳转到 action

                type:'post',
                cache:false,
                dataType:'text',
                success:function(data) {
                   // alert(data);
                   $('#small_catagory').empty();
                   $('#small_catagory').html(data);
                 },
                 error : function() {
                      alert("异常！");
                 }
            });
        }
    });

    $(".btn1").click(function(){
    $("p").slideToggle();
    });
});
</script>