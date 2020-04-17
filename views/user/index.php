<?php require_once (ROOT.'/views/layouts/header.php'); ?>
	<div class="wrapper flex alic fdc">
		<div class="content">
			<div class="header">
				<div class="navigation-bar flex jcsb">
					<a href="/main" class="logo">Library</a>
					<div class="buttons flex alic">
						<div class="main-search active-search">
							<input type="text" placeholder="Пошук..." id="search-book">
						</div>
						<a href="/logout">
							<img src="/template/images/logout.png" alt="">
						</a>
					</div>
				</div>
			</div>	
			<div class="books">
				<?php if ($result = Book::getCollection($_SESSION['user'])): ?>
					<?php foreach ($result as $book): ?>
						<div class="book flex fdc">
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
									<div class="author-name"><?php echo $book['Title']; ?></div>
									<div class="genre-title"><?php echo $book['GenreTitle']; ?></div>
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
	<div class="pdf-modal-wrapper flex jcc">
		<div class="pdf-modal-content" id="pdf-content">
			
		</div>
	</div>
	<script src="/template/scripts/jquery3.4.1.js"></script>
	<script src="/template/scripts/pdf.js"></script>
	<script src="/template/scripts/search.js"></script>
	<script src="/template/scripts/uvmSearchSelect.js"></script>
	<script src="/template/scripts/uvmModal.js"></script>	
	<script src="/template/scripts/pdfModal.js"></script>
	<script src="/template/scripts/actionBooks.js"></script>
<?php require_once (ROOT.'/views/layouts/footer.php'); ?>