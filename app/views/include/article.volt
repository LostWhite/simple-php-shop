<div id="article_table" style="min-height:800px;margin:10px 0 0 0;">
<table style="width : 100%; font-size:15px; color:#7c7c7c;">
    <tr style="background-color:#eee; padding:5px; text-align:left;">
        <td style="width:10%">文件类型</td>
        <td style="width:50%">标题</td>
        <td style="width:15%">作者</td>
        <td style="width:25%">日期</td>
    </tr>
{% for note in notes %}
    <tr>
        <td style="width:10%">[文件类型]</td>
        <td style="width:50%"><a href="{{ site_url }}article/tarticle/{{ note['id'] }}">{{ note['title'] }}</a></td>
        <td style="width:15%"><a href="{{ site_url }}online/tab1/{{ note['ps_user_id'] }}">{{ note['user_name'] }}</a></td>
        <td style="width:25%">{{ note['date'] }}</td>
    </tr>
{% endfor %}
</table>
{% if end != 1 %}
    <?php include $hs_view_include_path.'page.inc';?>
{% endif %}
</div>