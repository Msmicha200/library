<?php 

	class Book {

		public static function addBook ($title, $authorId, $genreId, $description,
			$image, $pdf, $audio) {
			$db = Database::getConnection();
			$genreId = intval($genreId);
			$authorId = intval($authorId);
			$image = '/template/db_images/' .  $image;
			$pdf = '/template/pdf/' . $pdf;

			if ($audio !== null) {

				$audio = '/template/db_audio/' . $audio;
				move_uploaded_file($_FILES['audio']['tmp_name'], ROOT.$audio);
			}

			$query = "INSERT INTO books (Title, Description, Image, Audio, Pdf,
						AuthorId, GenreId) VALUES (:title, :description, :image, 
						:audio, :pdf, :authorId, :genreId)";
			
			$result = $db->prepare($query);
			$result->bindParam(":title", $title, PDO::PARAM_STR);
			$result->bindParam(":description", $description, PDO::PARAM_STR);
			$result->bindParam(":image", $image, PDO::PARAM_STR);
			$result->bindParam(":audio", $audio, PDO::PARAM_STR);
			$result->bindParam(":pdf", $pdf, PDO::PARAM_STR);
			$result->bindParam(":authorId", $authorId, PDO::PARAM_INT);
			$result->bindParam(":genreId", $genreId, PDO::PARAM_INT);

			if ($result->execute()) {

				move_uploaded_file($_FILES['image']['tmp_name'], ROOT.$image);
				move_uploaded_file($_FILES['pdf']['tmp_name'], ROOT.$pdf);
				
				return $db->lastInsertId();
			}

			return false;
		}

		public static function editBook ($bookId, $title, $authorId, $genreId, 
			$description, $image, $pdf, $audio) {
			$db = Database::getConnection();
			$bookId = intval($bookId);
			$genreId = intval($genreId);
			$authorId = intval($authorId);


			if (isset($_FILES['image'])) {

				$image = '/template/db_images/' .  $image;
				move_uploaded_file($_FILES['image']['tmp_name'], ROOT.$image);
			}

			if (isset($_FILES['pdf'])) {
				
				$pdf = '/template/pdf/' . $pdf;				
				move_uploaded_file($_FILES['pdf']['tmp_name'], ROOT.$pdf);
			}

			if (isset($_FILES['audio'])) {

				$audio = '/template/db_audio/' . $audio;
				move_uploaded_file($_FILES['audio']['tmp_name'], ROOT.$audio);	
			}

			$query = "UPDATE
						    books
						SET
						    Title = :title,
						    Description = :description,
						    Image = :image,
						    Audio = :audio, Pdf = :pdf,
						    AuthorId = :authorId,
						    GenreId = :genreId
						WHERE
						    Id = :bookId";

			$result = $db->prepare($query);
			$result->bindParam(":bookId", $bookId, PDO::PARAM_INT);
			$result->bindParam(":title", $title, PDO::PARAM_STR);
			$result->bindParam(":description", $description, PDO::PARAM_STR);
			$result->bindParam(":image", $image, PDO::PARAM_STR);
			$result->bindParam(":audio", $audio, PDO::PARAM_STR);
			$result->bindParam(":pdf", $pdf, PDO::PARAM_STR);
			$result->bindParam(":authorId", $authorId, PDO::PARAM_INT);
			$result->bindParam(":genreId", $genreId, PDO::PARAM_INT);

			if ($result->execute()) {
				
				return true;
			}

			return false;
		}

		public static function toArchive ($bookId) {
			$db = Database::getConnection();

			return $db->prepare("UPDATE books SET IsArchived = 1 WHERE Id = ?")
			->execute([$bookId]);
		}

		public static function fromArchive ($bookId) {
			$db = Database::getConnection();
			$bookId = intval($bookId);

			return $db->prepare("UPDATE books SET IsArchived = 0 WHERE Id = ?")
			->execute([$bookId]);	
		}

		public static function toCollection ($bookId, $userId) {
			$db = Database::getConnection();
			$bookId = intval($bookId);
			$userId = intval($userId);

			return $db->prepare("INSERT INTO collection (BookId, UserId) 
				VALUES (?, ?)")->execute([$bookId, $userId]);
		}

		public static function addComment ($bookId, $textComment, $userId) {
			$db = Database::getConnection();
			$bookId = intval($bookId);
			$userId = intval($userId);

			$query = "INSERT INTO comments (Comment, BookId, UserId) VALUES 
						(:comment, :bookId, :userId)";

			$result = $db->prepare($query);
			$result->bindParam(":comment", $textComment, PDO::PARAM_STR);
			$result->bindParam(":bookId", $bookId, PDO::PARAM_INT);
			$result->bindParam(":userId", $userId, PDO::PARAM_INT);

			if ($result->execute()) {
				
				return true;
			}

			return false;
		}

		public static function getComments ($bookId) {
			$db = Database::getConnection();
			$bookId = intval($bookId);

			$query = "SELECT c.Comment, a.Login, c.Date FROM comments as c, 
				accounts as a WHERE BookId = :bookId AND c.UserId = a.Id 
				ORDER BY c.Id DESC";
			$result = $db->prepare($query);
			$result->bindParam(":bookId", $bookId, PDO::PARAM_INT);
			$result->execute();
			$fetch = $result->fetchAll(PDO::FETCH_ASSOC);

			if ($fetch) {
				
				return $fetch;
			}

			return false;
		}

		public static function getBooks ($archived = false) {
			$db = Database::getConnection();
			
			if ($archived !== true) {

				$result = $db->query("SELECT
							b.Id,
						    b.Title,
						    b.Description,
						    a.Id as AuthorId,
						    a.Name,
						    g.Id as GenreId,
						    g.Title AS GenreTitle,
						    b.Image,
						    b.Audio,
						    b.Pdf
						FROM
						    books AS b,
						    authors AS a,
						    genres AS g
						WHERE
						    b.AuthorId = a.Id AND 
						    b.GenreId = g.Id AND
						    IsArchived < 1 ORDER BY b.Id DESC");
			}
			else {

				$result = $db->query("SELECT
							b.Id,
						    b.Title,
						    b.Description,
						    a.Id as AuthorId,
						    a.Name,
						    g.Id as GenreId,
						    g.Title AS GenreTitle,
						    b.Image,
						    b.Audio,
						    b.Pdf
						FROM
						    books AS b,
						    authors AS a,
						    genres AS g
						WHERE
						    b.AuthorId = a.Id AND 
						    b.GenreId = g.Id AND
						    IsArchived > 0");	
			}

			if ($result) {

				return $result;
			}

			return false;
		}

		public static function getBook ($bookId) {
			$db = Database::getConnection();
			$bookId = intval($bookId);

			$query = "SELECT
						b.Id,
					    b.Title,
					    b.Description,
					    a.Name,
					    g.Title AS GenreTitle,
					    b.Image,
					    b.Audio,
					    b.Pdf
					FROM
					    books AS b,
					    authors AS a,
					    genres AS g
					WHERE
					    b.AuthorId = a.Id AND 
					    b.GenreId = g.Id AND 
					    b.Id = :bookId AND 
					    IsArchived < 1";
			$result = $db->prepare($query);
			$result->bindParam(":bookId", $bookId, PDO::PARAM_INT);
			$result->execute();
			
			$fetch = $result->fetchAll(PDO::FETCH_ASSOC);

			foreach ($fetch as &$book) {
				$book['Collected'] = false;
			}

			if (isset($_SESSION['user'])) {
				self::checkFav($fetch, $_SESSION['user']);
			}

			if ($fetch) {

				return $fetch[0];
			}
		}

		public static function getCollection ($userId) {
			$db = Database::getConnection();
			$userId = intval($userId);

			$query = "SELECT
						b.Id,
					    b.Title,
					    b.Description,
					    a.Name,
					    g.Title AS GenreTitle,
					    b.Image,
					    b.Audio,
					    b.Pdf
					FROM
					    books AS b,
					    authors AS a,
					    genres AS g,
                        collection as c
					WHERE
					    b.AuthorId = a.Id AND 
					    b.GenreId = g.Id AND 
					    b.Id = bookId AND 
					    b.IsArchived < 1 AND 
					    c.UserId = :userId";
			$result = $db->prepare($query);
			$result->bindParam(":userId", $userId, PDO::PARAM_INT);
			$result->execute();
			
			return $result->fetchAll(PDO::FETCH_ASSOC);
		}

		public static function getSortedBooks ($authorId = 0, $genreId = 0) {
			$db = Database::getConnection();
			$authorId = intval($authorId);
			$genreId = intval($genreId);

			$query = "call sort(:authorId, :genreId)";
			$result = $db->prepare($query);
			$result->bindParam(":authorId", $authorId, PDO::PARAM_INT);
			$result->bindParam(":genreId", $genreId, PDO::PARAM_INT);
			$result->execute();
			$fetch = $result->fetchAll(PDO::FETCH_ASSOC);

			foreach ($fetch as &$book) {
				$book['Collected'] = false;
			}

			if (isset($_SESSION['user'])) {
				self::checkFav($fetch, $_SESSION['user']);
			}

			if ($fetch) {
				return $fetch;
			}

			return false; 
		}

		public static function lastBooks () {
			$db = Database::getConnection();

			$result = $db->query("SELECT b.Id, b.Title, b.Description, a.Name,
								    g.Title AS GenreTitle,
								    b.Image,
								    b.Audio,
								    b.Pdf
								FROM
								    books AS b,
								    authors AS a,
								    genres AS g
								WHERE
								    b.AuthorId = a.Id AND b.GenreId = g.Id AND b.IsArchived < 1
								ORDER BY
								    b.Id
								DESC
								LIMIT 3");
			$fetch = $result->fetchAll(PDO::FETCH_ASSOC);
			
			foreach ($fetch as &$book) {
				$book['Collected'] = false;
				$book['Auth'] = false;
			}

			if (isset($_SESSION['user'])) {

				self::checkFav($fetch, $_SESSION['user']);
				
				foreach ($fetch as &$book) {
					$book['Auth'] = true;
				}
			}

			if ($fetch) {

				return $fetch;
			}

			return false;
		}

		public static function checkFav (&$books, $uid) {
			$db = Database::getConnection();
			$uid = intval($uid);
			$arr = [];
			$fetch = $db->query("SELECT * FROM collection WHERE UserId = $uid");

			foreach ($books as &$item) {
				$arr[$item['Id']] = &$item;			
			}

			foreach ($fetch as $sel) {
				$arr[$sel['BookId']]['Collected'] = true;
			}
		}

		public static function generateName () {
			$string = date("Y-m-d H:i:s") . rand(1, 1000) . rand(1, 1020);
			$string = hash("sha256", $string);
			
			return mb_substr($string, 10, 15, 'UTF8');
		}

	}

 ?>