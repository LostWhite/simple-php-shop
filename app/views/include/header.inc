	    		<header>
			<div id="header_inner">
				<nav>
					<ul class='myhead'>
						<?php //$usename = $_GET['usename'];
						if(empty($username))
						{
							//echo "<a href='$site_url/login'>登录</a>";//Phalcon\Tag::linkTo("login","登录");
							echo "<a href='$site_url/login' title='登录'>登录</a>";
							echo "<label id='name_flg' style='display:none'></label>";
							echo "<em class='line4'>|</em>";
							echo "<a href='$site_url/signup' title='免费注册'>免费注册</a>";
						}
						else{
							echo "欢迎光临".$username; 
							echo "<label id='name_flg' style='display:none'>".$username."</label>";
							echo "<em class='line4'>|</em>";
							echo "<a href='$site_url/index'>退出登录</a>";//Phalcon\Tag::linkTo("index","退出登录");
							//echo $num;
							//if($num > 0){
							//echo "有<a href='$site_url/conversation?num=$num&sender=$usename&geter=$getname'>$num</a>条新消息";
							//}
						}
						?>
						<!-- <li class='logout'><a href='$site_url/login' title='登录'>登录</a></li> -->
					   						<!-- <li class="cart"><a href="/pc_cart_index.html" title="買い物カゴ">買い物カゴ</a></li> -->
						<!-- <li class="mypage"><a href="/pc_topMypage_index1.html" title="免费注册">免费注册</a></li> -->

					</ul>
				</nav>

				<!--h1 style="color: #000077"><a href="" title="シフト">シフト</a></h1-->

                <div>
                    <img src="<?php echo $site_url; ?>img/test01_0.jpg" style="height:20px;" />
                </div>

				<div id="searchbox">
					<form id="form_quickSearch" action="" id="cse-search-box" method="get" name="focus">
						<div>
							<input type="hidden" name="cx" value="011579495771186102644:qndnpoddr30">
							<input type="hidden" name="cof" value="FORID:10;NB:1">
							<input type="hidden" name="ie" value="UTF-8">
							<input type="hidden" name="sType" value="1" />
							<input type="text" name="q" id="text_keyword" class="text_keyword" style="color:#999;" onFocus="cText(this)" onBlur="sText(this)" value="关键字搜索">
							<button type="submit" name="sa" class="button" title="检索">检索</button>
						</div>
					</form>
				</div>
			</div>
		</header>