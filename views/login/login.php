<?php require_once (ROOT.'/views/layouts/header.php'); ?>
	<div class="wrapper flex alic fdc">
		<div class="content">
			<div class="header">
				<div class="navigation-bar flex jcfs">
					<a href="/main" class="logo">Library</a>
				</div>
			</div>
			<div class="main flex fdc alic">
				<div class="login-admin-label">
					Адмін панель
				</div>
				<div class="login-inputs-wrapper flex fdc alic">
					<input type="text" id="login" placeholder="Логін" class="admin-input">
					<input type="password" id="password" placeholder="Пароль" class="admin-input">
					<div class="login-button">
						Увійти
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="/template/scripts/jquery3.4.1.js"></script>
	<script src="/template/scripts/adminLogin.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>