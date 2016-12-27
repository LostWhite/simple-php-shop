<div class="navbar">
    <div class="navbar-inner">
      <div class="container" style="width: auto;">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        {{ link_to(null, 'class': 'brand', '人生咨询预测平台')}}
        <div class="nav-collapse">
          <ul class="nav">

            {%- set menus = [
              '主页': 'index',
               '发布赏金求测': 'reward/public',
               '赏金求测一览': 'reward/search',
               '申请成为专家': 'user/apply',
               '试测验证': 'chat/index?room_id=3_1&task_id=9',
               '我的信箱': 'user/message'
            ] -%}
            {%- for key, value in menus %}
              {% if value == dispatcher.getControllerName() %}
              <li class="active">{{ link_to(value, key) }}</li>
              {% else %}
              <li>{{ link_to(value, key) }}</li>
              {% endif %}
            {%- endfor -%}

          </ul>

          <ul class="nav pull-right">
            {%- if not(logged_in is empty) %}
            <li style="width:140px"><a href="#" class="dropdown-toggle"  >登录者:<font style="color:yellow">{{ logged_in }}</font> <b class="caret"></b></a></li>
            <li>{{ link_to('session/logout', '退出') }}</li>
            {% else %}
            <li>{{ link_to('session/login', '登录') }}</li>
            {% endif %}
          </ul>
        </div><!-- /.nav-collapse -->
      </div>
    </div><!-- /navbar-inner -->
  </div>

<div class="container main-container">
  {{ content() }}
</div>

<footer>
xxxxx© 2015 All-Connect Team.
</footer>
