<?php require_once (ROOT.'/views/layouts/header.php'); ?>
	<div class="wrapper flex alic fdc">
		<div class="content">
			<div class="header">
				<div class="navigation-bar flex jcsb">
					<a href="/main" class="logo">Library</a>
					<div class="buttons flex alic">
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
			</div>
			<div class="book flex fdc books">
				<div class="book-inner-wrapper flex">
					<div class="book-image flex jcc alic">
						<img src="<?php echo $book['Image']; ?>" class="book-preview flex jcc alic" alt="">
						<div class="actions flex fdc jcsb">
							<div class="read-book" data-path="<?php echo $book['Pdf']; ?>">
								<img src="/template/images/eye.svg" alt="">
							</div>
							<div class="download-book" data-path="<?php echo $book['Pdf']; ?>">
								<img src="/template/images/arrow.svg" alt="">
							</div>
							<?php if (isset($_SESSION['user'])): ?>
								<?php if (!$book['Collected']): ?>
									<div class="like-book" data-id="<?php echo $book['Id']; ?>">
										<img src="/template/images/heart.svg" alt="">
									</div>
								<?php endif ?>
							<?php endif ?>
						</div>
					</div>
					<div class="book-info">
						<div class="book-title-wrapper flex alic">
							<div class="book-title"><?php echo $book['Title']; ?></div>
						</div>
						<div class="author-name"><?php echo $book['Title']; ?></div>
						<div class="genre-title"><?php echo $book['GenreTitle']; ?></div>
						<div class="book-description"><?php echo $book['Description']; ?></div>
						<?php if ($book['Audio']): ?>
							<?php if (isset($_SESSION['user'])): ?>
								<div class="book-audio-wrapper flex alic">
									<div class="audio-play pause"></div>
									<div class="controls-wrepper">
										<div class="book-audio-status flex jcsb">
											<div class="audio-current-time">00:00</div>
											<div class="audio-duration"></div>
										</div>
										<div class="time-line flex alic">
											<div class="progress-line flex alic jcfe">
											</div>
											<div class="audio-dot"></div>
										</div>
									</div>
									<audio id="audio" src="<?php echo $book['Audio'] ?>"></audio>
								</div>
								<?php else: ?>
									<div class="label-audio">
										Щоб прослухати аудіо - авторизуйтесь
									</div>
							<?php endif ?>
						<?php endif ?>
					</div>
				</div>
				<div class="hr-line"></div>
			</div>
			<div class="comments-label flex jcc alic">
				Коментарі
			</div>
			<?php if (isset($_SESSION['user'])): ?>
				<div class="comment-area-wrapper flex fdc alifs">
					<div class="error-label">
						Введіть мінімум 10 символів
					</div>
					<div class="comment-area flex">
						<textarea id="text-comment" cols="30" rows="10" placeholder="Коментар" maxlength="500"></textarea>
						<div class="comment-count-wrapper flex">
							<div id="comment-count">0</div>
							<div>/500</div>
						</div>
					</div>
					<div class="send-comment">
						Надіслати
					</div>
				</div>
			<?php else: ?>
				<div class="not-authorized flex jcc alic">
					Авторизуйтесь щоб залишити коментар
				</div>
			<?php endif ?>
			<div class="comments">
				<?php if ($comments): ?>
					<?php foreach ($comments as $comment): ?>
						<div class="comment">
							<div class="top-comment-wrapper flex alic">
								<div class="name">
									<?php echo $comment['Login']; ?>
								</div>
								<div class="date">
									<?php echo date('Y.m.d\, H:i', strtotime($comment['Date'])); ?>
								</div>
							</div>
							<div class="comment-text">
								<?php echo $comment['Comment'] ?>
							</div>
							<div class="hr-line"></div>
						</div>
					<?php endforeach ?>
				<?php endif ?>
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
	<script src="/template/scripts/book.js"></script>
	<script src="/template/scripts/uvmModal.js"></script>
	<script src="/template/scripts/audio.js"></script>
	<script src="/template/scripts/pdf.js"></script>
	<script src="/template/scripts/pdfModal.js"></script>
	<script src="/template/scripts/actionBooks.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>
