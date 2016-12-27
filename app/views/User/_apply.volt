{{ content() }}

{%- if (logged_in is empty) %}
       <script>window.location.href="/session/login"</script>
 {% endif %}

<!--form method="post"  autocomplete="off"-->
{{ form('user/apply',  'method': 'post', 'enctype': 'multipart/form-data') }}
{% if !successFlg %}
    <div class="center scaffold">
        <h1>申请成为预测师</h1>
        <div style="border-top:5px solid #000;width:800px;height:20px;"> </div>
        <div>
            <table>
                <tr>
                     <td colspan="3" height="24px"><label for="id">请认真填写实名认证的相关信息，在申请提交的 24 小时内，预约管理员会与您联系，进行视频考核认证。</label></td>
                </tr>
                <tr>
                         <td colspan="3" height="10px"></td>
                    </tr>
                <tr>
                     <td><label for="id">真实姓名:</label></td>
                     {% if showFlg %}
                         <td>{{ form.render("real_name")}}</td>
                     {% else %}
                        <td>{{ form.render("real_name",["value": teacherInfo.real_name,"disabled":true])}}</td>
                     {% endif %}
                     <td><label for="id">必需填写真实姓名</label></td>
                </tr>

                <tr>
                     <td><label for="id">身份证号码：</label></td>
                     {% if showFlg %}
                         <td>{{ form.render("identif_id")}}</td>
                      {% else %}
                         <td>{{ form.render("identif_id",["value": teacherInfo.identif_id,"disabled":true])}}</td>
                      {% endif %}
                     <td><label for="id">身份证号码和影本将用于身份认证 </label></td>
                </tr>

                <tr>
                     <td><label for="id">身份证正面：</label></td>
                      {% if showFlg %}
                          <td>{{ form.render("identif_img_front") }}</td>
                       {% else %}
                          <td>{{ form.render("identif_img_front",["disabled":true]) }}</td>
                       {% endif %}
                     <td><label for="id">支持文件格式：JPG，GIF，PNG </label></td>
                </tr>

                <tr>
                     <td><label for="id">身份证反面：</label></td>
                       {% if showFlg %}
                           <td>{{ form.render("identif_img_back") }}</td>
                        {% else %}
                           <td>{{ form.render("identif_img_back",["disabled":true]) }}</td>
                        {% endif %}
                     <td><label for="id">支持文件格式：JPG，GIF，PNG </label></td>
                </tr>

                <tr>
                     <td><label for="id">联系地址：</label></td>
                     {% if showFlg %}
                         <td>{{ form.render("address") }}</td>
                      {% else %}
                        <td>{{ form.render("address",["value": teacherInfo.address,"disabled":true]) }}</td>
                      {% endif %}
                     <td><label for="id">必需填写真实地址</label></td>
                </tr>

                <tr>
                     <td><label for="id">手机：</label></td>
                     {% if showFlg %}
                         <td>{{ form.render("mobile_num") }}</td>
                      {% else %}
                        <td>{{ form.render("mobile_num",["value": teacherInfo.mobile_num,"disabled":true]) }}</td>
                      {% endif %}
                     <td><label for="id">手机方便我们联系</label></td>
                </tr>

                <tr>
                     <td><label for="id">擅长的预测方式：</label></td>
                     {% if showFlg %}
                        <td> {{ form.render("expert_content") }}</td>
                      {% else %}
                        <td> {{ form.render("expert_content",["value": teacherInfo.expert_content,"disabled": true]) }}</td>
                      {% endif %}
                     <td><label for="id">字数不得超过 500 字，不支持HTML标签 </label></td>
                </tr>

                <tr>
                <td colspan="3" height="24px"> </td>
                </tr>
                <tr>
                    <td></td>
                    {% if showFlg %}
                        <td> {{ submit_button("提交管理员审核", "class": "btn btn-primary") }}</td>
                    {% else %}
                        <td> {{ submit_button("提交管理员审核", "class": "btn btn-primary","disabled": true) }}</td>
                    {% endif %}
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
{% else %}
    <div>
    <h1>恭喜您已经注册成为专家！</h1>
    </div>
{% endif %}
</form>