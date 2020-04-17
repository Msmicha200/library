<?php require_once (ROOT.'/views/layouts/header.php'); ?>
	<div class="wrapper flex jcc fdc alic">
		<div class="reset-pass-items flex fdc alic jcc">
			<div class="error-pass flex jcc">
				Введіть пароль не меньше 8 символів
			</div>
			<div class="input-reset-wrapper flex alic">
				<input type="password" id="new-password" maxlength="60" placeholder="Новий пароль">
				<span class="length-container flex">
					<div id="new-password-count">0</div>/60
				</span>						
			</div>
			<div class="input-reset-wrapper flex alic">
				<input type="password" id="rep-new-password" maxlength="60" placeholder="Пароль ще раз">
				<span class="length-container flex">
					<div id="rep-pass-count">0</div>/60
				</span>						
			</div>
			<div class="accept-reset-pass flex jcc alic">
				Підтвердити
			</div>
		</div>
	</div>
	<script src="/template/scripts/jquery3.4.1.js"></script>
	<script src="/template/scripts/resetPassword.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>