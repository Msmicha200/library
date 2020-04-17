<?php require_once (ROOT.'/views/layouts/header.php'); ?>
	<div class="wrapper flex alic fdc">
		<div class="content">
			<div class="header">
				<div class="navigation-bar flex jcsb">
					<a href="/main" class="logo">Library</a>
					<div class="buttons flex alic">
						<div class="search">
							<input type="text" placeholder="Пошук..." id="search-book">
						</div>
						<a href="/logout">
							<img src="/template/images/logout.png" alt="">
						</a>
					</div>
				</div>
			</div>
			<div class="tab-buttons flex">
				<div class="tab-item add-book-tab current-tab">
					Додати книгу
				</div>
				<div class="tab-item all-books-tab">
					Книги
				</div>
				<div class="tab-item add-author-tab">
					Автор
				</div>
				<div class="tab-item add-genre-tab">
					Жанр
				</div>
				<div class="tab-item archive-tab">
					Архів
				</div>
			</div>
			<div id="first-tab" class="active-content">
				<div class="inner-tab-wrapper flex fdc alifs">
					<div class="status-label">
						<div class="error-edit-book">
							Укажіть всі значення коректно
						</div>
						<div class="success-adding">
							Успішно додано
						</div>	
					</div>
					<div class="input-title-wrapper flex alic jcfe">
						<input type="text" id="book-title" maxlength="50" placeholder="Назва" maxlength="60">
						<div class="length-container flex">
							<div id="book-title-count">0</div>/50
						</div>
					</div>
					<div class="uvm--select">
						<div class="uvm--current-item current-author">
							<!-- selected item -->
							Автор
						</div>
						<div class="uvm--options">
							<div class="uvm--search-container">
								<input type="text" placeholder="Пошук..." class="uvm--input-search">
							</div>
							<ul class="uvm--options-list authors-list">
								<?php if ($result = Author::getAuthors()): ?>
									
									<?php foreach ($result as $author): ?>
										<li class="uvm--option author-item author-data" data-id="<?php echo $author['Id']; ?>">
											<?php echo $author['Name']; ?>
										</li>
									<?php endforeach ?>
								<?php endif ?>
							</ul>
						</div>
					</div>
					<div class="uvm--select">
						<div class="uvm--current-item current-genre">
							<!-- selected item -->
							Жанр
						</div>
						<div class="uvm--options">
							<div class="uvm--search-container">
								<input type="text" placeholder="Пошук..." class="uvm--input-search">
							</div>
							<ul class="uvm--options-list genre-list">
								<?php if ($result = Genre::getGenres()): ?>
									
									<?php foreach ($result as $genre): ?>
										<li class="uvm--option genre-item genre-data" data-id="<?php echo $genre['Id']; ?>">
											<?php echo $genre['Title']; ?>
										</li>
									<?php endforeach ?>
								<?php endif ?>
							</ul>
						</div>
					</div>
					<div class="book-area-wrapper flex fdc alifs">
						<div class="book-description-area flex">
							<textarea id="book-description" maxlength="500" cols="30" rows="10" placeholder="Опис" maxlength="500"></textarea>
							<div class="description-count-wrapper flex">
								<div id="description-book-count">0</div>
								<div>/500</div>
							</div>
						</div>
					</div>
					<div class="book-accept-buttons flex fdc">
						<div class="first-row-buttons flex jcsb">
							<label for="add-audio-input" class="book-audio-button input">
								Аудіо
							</label>
							<input type="file" accpept=".mp3, .wav" hidden="" id="add-audio-input">
							<label for="add-pdf-input" class="book-pdf-button input">
								PDF
							</label>
							<input type="file" hidden="" accept="pdf" id="add-pdf-input">
						</div>
						<div class="second-row-buttons flex jcsb">
							<label for="add-preview-input" class="book-preview-button input">
								Облкадинка
							</label>
							<input type="file" hidden="" accept=".jpeg,.png,.svg,.jpg" id="add-preview-input">
							<div class="book-accept-button added">
								Додати
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="second-tab">
				<div class="books edit-books-wrapper">
					<?php if ($books = Book::getBooks()): ?>

						<?php foreach ($books as $book): ?>
							<div class="book flex fdc">
								<div class="book-inner-wrapper flex">
									<div class="book-image flex jcc alic">
										<img src="<?php echo $book['Image']; ?>" class="book-preview flex jcc alic" alt="">
										<div class="actions flex fdc jcsb">
											<div class="edit-book" data-pdf="<?php echo $book['Pdf'] ?>" data-audio="<?php echo $book['Audio'] ?>" data-id="<?php echo $book['Id'] ?>">
												<img src="/template/images/edit.svg" alt="">
											</div>
											<div class="to-archive" data-id="<?php echo $book['Id'] ?>">
												<img src="/template/images/toArchive.svg" alt="">
											</div>
										</div>
									</div>
									<div class="book-info">
										<div class="book-title-wrapper flex alic">
											<a class="book-title" href="<?php echo '/book?Id='.$book['Id'] ?>"><?php echo $book['Title']; ?></a>
											<?php if ($book['Audio']): ?>
												<div class="is-sounded" title="Є аудіо версія">
													<img src="/template/images/sound.png" alt="">
												</div>
											<?php endif ?>
										</div>
										<div class="author-name author-data" data-id="<?php echo $book['AuthorId']?>"><?php echo $book['Name']; ?></div>
										<div class="genre-title genre-data" data-id="<?php echo $book['GenreId']?>"><?php echo $book['GenreTitle']; ?></div>
										<div class="book-description"><?php echo $book['Description']; ?></div>
									</div>
								</div>
								<div class="hr-line"></div>
							</div>
						<?php endforeach ?>						
					<?php endif ?>
				</div>
			</div>
			<div id="third-tab">
				<div class="inner-tab-wrapper">
					<div class="error-edit-author">
						Введіть коректні дані. Від 3 до 50 символів
					</div>
					<div class="input-author-name-wrapper flex alic jcfe">
						<input type="text" id="author-name" maxlength="50" placeholder="Ім'я автора" maxlength="60">
						<div class="length-container flex">
							<div id="book-author-name-count">0</div>/50
						</div>
					</div>
					<div class="accept-adding-author added">
						Додати
					</div>
					<div class="authors-wrapper">
						<div class="all-authors-content">
							<table class="all-authors">
								<tr>
									<th height="35px" colspan="2">Імʼя</th>
								</tr>
								<?php if ($result = Author::getAuthors()): ?>
									<?php foreach ($result as $author): ?>
										<tr>
											<td><?php echo $author['Name']; ?></td>
											<td align="center">
												<button class="edit-author-button" data-id="<?php echo $author['Id'] ?>">
													<img src="/template/images/edit.png" alt="">
												</button>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div id="fourth-tab">
				<div class="inner-tab-wrapper">
					<div class="error-edit-genre">
						Введіть коректні дані. Від 3 до 50 символів
					</div>
					<div class="input-genre-wrapper flex alic jcfe">
						<input type="text" id="genre-title" maxlength="50" placeholder="Назва жанру" maxlength="60">
						<div class="length-container flex">
							<div id="book-genre-count">0</div>/50
						</div>
					</div>
					<div class="accept-adding-genre added">
						Додати
					</div>
					<div class="genres-wrapper">
						<div class="all-genres-content">
							<table class="all-genres">
								<tr>
									<th height="35px" colspan="2">Імʼя</th>
								</tr>
								<?php if ($result = Genre::getGenres()): ?>
									<?php foreach ($result as $genre): ?>
										<tr>
											<td><?php echo $genre['Title']; ?></td>
											<td align="center">
												<button data-id="<?php echo $genre['Id'] ?>" class="edit-genre-button">
													<img src="/template/images/edit.png" alt="">
												</button>
											</td>
										</tr>
									<?php endforeach ?>
								<?php endif ?>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div id="fifth-tab">
				<div class="books-archived edit-books-wrapper">
					<?php if ($books = Book::getBooks(true)): ?>
							
						<?php foreach ($books as $book): ?>
							<div class="book flex fdc">
								<div class="book-inner-wrapper flex">
									<div class="book-image flex jcc alic">
										<img src="<?php echo $book['Image']; ?>" class="book-preview flex jcc alic" alt="">
										<div class="actions flex fdc jcsb">
											<div class="edit-book" data-id="<?php echo $book['Id'] ?>">
												<img src="/template/images/edit.svg" alt="">
											</div>
											<div class="from-archive" data-id="<?php echo $book['Id'] ?>">
												<img src="/template/images/back.svg" alt="">
											</div>
										</div>
									</div>
									<div class="book-info">
										<div class="book-title-wrapper flex alic">
											<a class="book-title" href="<?php echo '/book?Id='.$book['Id'] ?>"><?php echo $book['Title']; ?></a>
											<?php if ($book['Audio']): ?>
												<div class="is-sounded" title="Є аудіо версія">
													<img src="/template/images/sound.png" alt="">
												</div>
											<?php endif ?>
										</div>
										<div class="author-name author-data" data-id="<?php echo $book['AuthorId']?>"><?php echo $book['Name']; ?></div>
										<div class="genre-title genre-data" data-id="<?php echo $book['GenreId']?>"><?php echo $book['GenreTitle']; ?></div>
										<div class="book-description"><?php echo $book['Description']; ?></div>
									</div>
								</div>
								<div class="hr-line"></div>
							</div>
						<?php endforeach ?>						
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
	<div class="edit-author-modal-wrapper flex jcc">
		<div class="edit-author-content">
			<div class="error-edit-author">
				Введіть коректні дані. Від 3 до 50 символів
			</div>
			<div class="input-author-name-wrapper flex alic jcfe">
				<input type="text" id="edit-author" maxlength="50" placeholder="Ім'я автора">
				<div class="length-container flex">
					<div id="edit-author-name-count">0</div>/50
				</div>
			</div>
			<div class="accept-editing-author added">
				Додати
			</div>
		</div>
	</div>
	<div class="edit-genre-modal-wrapper flex jcc">
		<div class="edit-genre-content">
			<div class="error-edit-genre">
				Введіть коректні дані. Від 3 до 50 символів
			</div>
			<div class="input-genre-wrapper flex alic jcfe">
				<input type="text" id="edit-genre" maxlength="50" placeholder="Ім'я автора">
				<div class="length-container flex">
					<div id="edit-genre-count">0</div>/50
				</div>
			</div>
			<div class="accept-editing-genre added">
				Додати
			</div>
		</div>
	</div>
	<div class="edit-book-modal-wrapper flex jcc">
		<div class="edit-book-content flex alifs">
			<div class="left-edit-side">
				<label for="edit-book-preview" class="book-image flex jcc">
					<img src="/template/images/db_images/test.jpg" alt="">
				</label>
				<input type="file" hidden="" accept=".jpeg,.png,.svg,.jpg" id="edit-book-preview">
				<div class="edit-book-buttons flex fdc">
					<label for="edit-audio-input" class="book-audio-button added">
						Аудіо
					</label>
					<input type="file" hidden="" accept=".mp3, .wav" id="edit-audio-input">
					<label for="edit-pdf-input" class="edit-pdf-button added">
						PDF
					</label>
					<input type="file" hidden="" accept=".pdf" id="edit-pdf-input">
				</div>
			</div>
			<div class="right-edit-side">
				<div class="error-edit-book">
					Укажіть всі значення коректно
				</div>
				<div class="input-title-wrapper flex alic jcfe">
					<input type="text" id="edit-book-title" maxlength="50" placeholder="Назва" maxlength="60">
					<div class="length-container flex">
						<div id="edit-book-title-count">0</div>/50
					</div>
				</div>
				<div class="uvm--select">
					<div class="uvm--current-item edit-author-current">
						<!-- selected item -->
						Select your item
					</div>
					<div class="uvm--options">
						<div class="uvm--search-container">
							<input type="text" placeholder="Пошук..." class="uvm--input-search">
						</div>
						<ul class="uvm--options-list edit-author-list">
							<?php if ($result = Author::getAuthors()): ?>
								
								<?php foreach ($result as $author): ?>
									<li class="uvm--option author-edit-item author-data" data-id="<?php echo $author['Id']; ?>">
										<?php echo $author['Name']; ?>
									</li>
								<?php endforeach ?>
							<?php endif ?>
						</ul>
					</div>
				</div>
				<div class="uvm--select">
					<div class="uvm--current-item edit-genre-current">
						<!-- selected item -->
						Select your item
					</div>
					<div class="uvm--options">
						<div class="uvm--search-container">
							<input type="text" placeholder="Пошук..." class="uvm--input-search">
						</div>
						<ul class="uvm--options-list edit-genre-list">
							<?php if ($result = Genre::getGenres()): ?>
								
								<?php foreach ($result as $genre): ?>
									<li class="uvm--option genre-edit-item genre-data" data-id="<?php echo $genre['Id']; ?>">
										<?php echo $genre['Title']; ?>
									</li>
								<?php endforeach ?>
							<?php endif ?>
						</ul>
					</div>
				</div>
				<div class="book-area-wrapper flex fdc alifs">
					<div class="book-description-area flex">
						<textarea id="edit-book-description" maxlength="500" cols="30" rows="10" placeholder="Опис" maxlength="500"></textarea>
						<div class="description-count-wrapper flex">
							<div id="edit-description-book-count">0</div>
							<div>/500</div>
						</div>
					</div>
				</div>
			</div>
			<div class="save-edit-button added">
				Зберегти
			</div>
		</div>
	</div>
	<input type="text" id="edit-hidden-input" hidden="">
	<script src="/template/scripts/jquery3.4.1.js"></script>
	<script src="/template/scripts/admin.js"></script>
	<script src="/template/scripts/uvmSearchSelect.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>