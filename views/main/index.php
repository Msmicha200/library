<?php require_once (ROOT.'/views/layouts/header.php'); ?>
	<div class="wrapper flex alic fdc">
		<div class="content">
			<div class="header">
				<div class="navigation-bar flex jcsb">
					<a href="/main" class="logo">Library</a>
					<div class="buttons flex alic">
						<div class="main-search">
							<input type="text" placeholder="Пошук..." id="search-book">
						</div>
						<?php if (isset($_SESSION['user'])): ?>
						<a class="to-collection" href="/user">
							<img src="/template/images/login.svg" alt="">
						</a>
						<?php else: ?>
						<div class="login">
							<img src="/template/images/login.svg" alt="">
						</div>
						<?php endif ?>
					</div>
				</div>
				<div class="city-image">
					<img src="/template/images/city.png" alt="">
				</div>
			</div>
			<div class="sorts flex alic">
				<div class="uvm--select">
					<div class="uvm--current-item current-author">
						Оберіть автора
					</div>
					<div class="uvm--options">
						<div class="uvm--search-container">
							<input type="text" placeholder="Пошук..." class="uvm--input-search">
						</div>
						<ul class="uvm--options-list author-items">
							<?php if ($result = Author::getAuthors()): ?>
								
								<?php foreach ($result as $author): ?>
									<li class="uvm--option author-item" data-id="<?php echo $author['Id']; ?>">
										<?php echo $author['Name']; ?>
									</li>
								<?php endforeach ?>
							<?php endif ?>
						</ul>
					</div>
				</div>
				<div class="uvm--select">
					<div class="uvm--current-item current-genre">
						Оберіть жанр
					</div>
					<div class="uvm--options">
						<div class="uvm--search-container">
							<input type="text" placeholder="Пошук..." class="uvm--input-search">
						</div>
						<ul class="uvm--options-list genre-items">
							<?php if ($result = Genre::getGenres()): ?>
								
								<?php foreach ($result as $genre): ?>
									<li class="uvm--option genre-item" data-id="<?php echo $genre['Id']; ?>">
										<?php echo $genre['Title']; ?>
									</li>
								<?php endforeach ?>
							<?php endif ?>
						</ul>
					</div>
				</div>
				<div class="clear flex alic">
					<img src="/template/images/stop.svg" alt="">
				</div>
			</div>
			<div class="books">

			</div>
		</div>
	</div>
	<div class="uvm--modal-wrapper uvm-modal-flex">
		<div class="uvm--modal-content uvm-modal-flex jcfs">
			<div id="first-tab" class="flex fdc alic jcsa current-tab">
				<div class="auth-label">
					Вхід
				</div>
				<div class="error-auth">
					Невірний логін або пароль
				</div>
				<div class="auth-inputs flex fdc">
					<input type="text" id="login" placeholder="Логін">
					<div class="password-input flex alic jcfe">
						<input type="password" id="password" placeholder="Пароль">
						<div class="remember-password">
							Забули пароль?
						</div>
					</div>
				</div>
				<div class="uvm--modal-buttons uvm-modal-flex">
					<div id="registration" class="uvm--modal-button">Реестрація</div>
					<div class="uvm--modal-button log-in">Увійти</div>
				</div>
			</div>
			<div id="second-tab" class="flex fdc alic">
				<div class="back-arrow flex alic"></div>
				<div class="remember-label">
					Забули пароль
				</div>
				<div class="remember-error">
					Такого користувача не існує
				</div>
				<div class="remember-items flex fdc alic jcsb">
					<input type="email" placeholder="E-mail" id="remember-mail">
					<div class="accept-remember flex jcc alic">
						Підтвердити
					</div>
				</div>
			</div>
			<div id="third-tab" class="flex fdc alic">
				<div class="back-arrow flex alic"></div>
				<div class="regestration-label">
					Реестрація
				</div>
				<div class="error-reg">
					Введіть коректні дані. <br> Логін не меньше 5 символів і пароль не меньше 8
				</div>
				<div class="regestration-items flex fdc alic jcsb">
					<div class="input-reg-wrapper flex alic jcfe">
						<input type="text" id="reg-login" placeholder="Логін" maxlength="60">
						<span class="length-container flex">
							<div id="login-count">0</div>/60
						</span>
					</div>
					<div class="input-reg-wrapper flex alic">
						<input type="password" id="reg-password" maxlength="60" placeholder="Пароль">
						<span class="length-container flex">
							<div id="password-count">0</div>/60
						</span>						
					</div>
					<div class="input-reg-wrapper flex alic">
						<input type="email" id="reg-mail" maxlength="80" placeholder="E-mail">
						<span class="length-container flex">
							<div id="mail-count">0</div>/80
						</span>
					</div>
					<div class="accept-regestration flex jcc alic">
						Підтвердити
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="pdf-modal-wrapper flex jcc">
		<div class="pdf-modal-content" id="pdf-content">
			
		</div>
	</div>
	<script src="/template/scripts/jquery3.4.1.js"></script>
	<script src="/template/scripts/search.js"></script>
	<script src="/template/scripts/uvmSearchSelect.js"></script>
	<script src="/template/scripts/pdf.js"></script>
	<script src="/template/scripts/main.js"></script>
	<script src="/template/scripts/uvmModal.js"></script>
	<script src="/template/scripts/actionBooks.js"></script>
	<script src="/template/scripts/pdfModal.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>