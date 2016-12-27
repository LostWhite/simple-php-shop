<?php
  include(APP_DIR."/config/link.php");
?>
<form method="post" autocomplete="off">

{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("index/index", "&larr; Go Back") }}
    </li>
</ul>
{%- if (logged_in is empty) %}
    <script>
        var site_url='<?php echo $site_url?>'
        window.location.href=site_url+"session/login"
    </script>
{% endif %}

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

</table>

