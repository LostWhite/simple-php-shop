
<header>
			<div id="header_inner">
			    <div class="header_inner">
                    <!--nav>
                         <ul class="nav pull-right">
                                    {% if not(logged_in is empty) %}
                                    <li style="width:140px"><a href="#" class="dropdown-toggle"  >登录者:<font style="color:blue">{{ logged_in }}</font> <b class="caret"></b></a></li>
                                    <li>{{ link_to(site_url~'session/logout', '退出') }}</li>
                                    <li>{{ link_to(site_url~'message/information', '有新消息', "id": "new_message","class":"message_alert_default","display":"none","style":"color:red")}}</li>
                                    {% else %}
                                    <li>{{ link_to(site_url~'session/login', '登录') }}</li>
                                    <li>{{ link_to(site_url~'session/signup', '新用户注册') }}</li>
                                    {% endif %}
                                  </ul>
                    </nav-->

                    <div id="logo_index"><a href="{{ site_url }}" title="返回首页"><img src="{{ site_url }}img/logo.png" style="width:200px;height:35px;" /></a></div>
                    <div id="search_box">
                        <form id="form_quickSearch" action="{{ site_url }}" id="cse-search-box" method="post" name="focus">
                            <div>
                                <input type="text" name="q" id="text_keyword" class="text_keyword" style="color:#999;" onFocus="cText(this)" onBlur="sText(this)" placeholder="预测师检索">
                                <button type="submit" name="sa" id="search_servcies" class="button" title="检索"></button>
                            </div>
                        </form>
                    </div>
                    <div id="login_index">
                        <ul class="">
                            {% if not(logged_in is empty) %}
                                <li><a href="#" class="dropdown-toggle"  >登录者：<font style="color:blue">{{ logged_in }}</font></a></li>
                                <li><a href="{{ site_url }}session/logout">退出</a></li>
                                <li>{{ link_to(site_url~'message/information', '有新消息', "id": "new_message","class":"message_alert_default","display":"none","style":"color:red")}}</li>
                            {% else %}
                                <li></li>
                                <li><a href="{{ site_url }}session/login">登录</a></li>
                                <li><a href="{{ site_url }}session/signup">新用户注册</a></li>
                            {% endif %}
                        </ul>
                    </div>
				</div>

			</div>
		</header>
  {{ content() }}
