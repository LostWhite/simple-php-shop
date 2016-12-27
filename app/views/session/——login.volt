{{ content() }}

<div align="center" class="well">

	{{ form('class': 'form-search') }}

	<div align="left">
		<h2>登录画面</h2>
	</div>

		{{ form.render('email') }}<br />
		{{ form.render('password') }}<br />
		{{ form.render('go') }}

		<div align="center" class="remember">
			{{ link_to("session/signup", "注册") }}<br />
		</div>

		{{ form.render('csrf', ['value': security.getToken()]) }}

		<hr>

		<div class="forgot">


		</div>

	</form>

</div>