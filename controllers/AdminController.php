<?php 
require_once(ROOT."/models/User.php");
require_once(ROOT."/models/Book.php");
require_once(ROOT."/models/Author.php");
require_once(ROOT."/models/Genre.php");

	class AdminController {

		private $draft = ROOT."/components/draft.json";

		public function actionIndex () {

			if (isset($_SESSION['admin'])) {

			require_once(ROOT."/views/admin/index.php");
			
			return true;
			}
			else {

				header("Location: /login");
			}
		}

		public function actionLogin () {

			if (isset($_SESSION['admin'])) {

				header("Location: /admin");				
			}
			else {

				require_once(ROOT."/views/login/login.php");
			
				return true;
			}
		}

		public function actionAuthAdmin () {

			if (isset($_POST['login']) && isset($_POST['password'])) {

				if ($_POST['login'] === getenv("login") &&
					$_POST['password'] === getenv(("password"))) {

					if (User::startAdminSession()) {

						echo "true";
						return true;
					}
					else {

						echo "false";
						die();
					}
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionToArchive () {

			if (isset($_POST['bookId']) && isset($_SESSION['admin'])) {

				if (Book::toArchive($_POST['bookId'])) {

					echo "true";
					return true;
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionFromArchive () {

			if (isset($_POST['bookId']) && isset($_SESSION['admin'])) {

				if (Book::fromArchive($_POST['bookId'])) {

					echo "true";
					return true;
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionEditAuthor () {
			
			if (isset($_POST['authorId']) && isset($_POST['name']) &&
				isset($_SESSION['admin'])) {

				if (strlen($_POST['name']) >= 3 && strlen($_POST['name']) <= 50) {

					if (Author::editAuthor($_POST['name'], $_POST['authorId'])) {

						echo "true";
						return true;
					}
					else {

						echo "false";
						die();
					}
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionEditGenre () {

			if (isset($_POST['title']) && isset($_POST['genreId']) &&
				isset($_SESSION['admin'])) {

				if (strlen($_POST['title']) >= 3 && strlen($_POST['title']) <= 50) {

					if (Genre::editGenre($_POST['title'], $_POST['genreId'])) {

						echo "true";
						return true;
					}
					else {

						echo "false";
						die();
					}
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionAddAuthor () {

			if (isset($_POST['name']) && isset($_SESSION['admin'])) {

				if (strlen($_POST['name']) >= 3 && strlen($_POST['name']) <= 50) {

					try {
						
						if ($result = Author::addAuthor($_POST['name'])) {

							echo $result;
							return true;
						}
						else {

							echo "false";
							die();
						}

					} catch (Exception $e) {
						
						echo "false";
						die();
					}
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionAddGenre () {

			if (isset($_POST['title']) && isset($_SESSION['admin'])) {

				if (strlen($_POST['title']) >= 3 &&
					strlen($_POST['title']) <= 50) {

					try {
						
						if ($result = Genre::addGenre($_POST['title'])) {

							echo $result;
							return true;
						}
						else {

							echo "false";
							die();
						}
					} catch (Exception $e) {
							
							echo "false";
							die();
					}
				}
				else {

					echo "false";
					die();
				}
			}
			else {

				echo "false";
				die();
			}
		}

		public function actionAddBook() {

			if (isset($_POST['title']) && isset($_POST['description']) &&
				isset($_FILES['image']) && isset($_FILES['pdf']) &&
				isset($_POST['authorId']) && isset($_POST['genreId']) &&
				isset($_SESSION['admin'])) {

				$file = explode(".", $_FILES['image']['name']);
				$image = Book::generateName() . '.' . end($file);
				$file = explode(".", $_FILES['pdf']['name']);
				$pdf = Book::generateName() . '.' . end($file);
				$audio = null;

				if (isset($_FILES['audio'])) {
					
					$file = explode(".", $_FILES['audio']['name']);
					$audio = Book::generateName() . '.' . end($file);
				}

				if ($result = Book::addBook($_POST['title'], $_POST['authorId'],
					$_POST['genreId'], $_POST['description'], $image, 
					$pdf, $audio)) {

					// $array = ["Id" => $result, "Img" => $image];
					if ($handler = fopen($this->draft, "w")) {

						fwrite($handler, "");
						fclose($handler);

						$array['Id'] = $result;
						$array['Img'] = "/template/db_images/" . $image;
						$array['Audio'] = "/template/db_audio/" . $audio;
						$array['Pdf'] = "/template/pdf/" . $pdf;

						echo json_encode($array);
						return true;
					}
				}
				else {

					echo "false";
					die();
				}
			}
		}

		public function actionEditBook () {

			if (isset($_POST['title']) && isset($_POST['description']) &&
				isset($_POST['authorId']) && isset($_POST['genreId']) &&
				isset($_POST['bookId']) && isset($_SESSION['admin'])) {

				$audio = null;
				$image = null;
				$pdf = null;

				if (isset($_FILES['audio'])) {

					$file = explode(".", $_FILES['audio']['name']);
					$audio = Book::generateName() . '.' . end($file);
				}
				elseif (isset($_POST['auio'])) {
					
					$audio = $_POST['audio'];
				}

				if (isset($_FILES['image'])) {

					$file = explode(".", $_FILES['image']['name']);
					$image = Book::generateName() . '.' . end($file);
				}
				elseif (isset($_POST['image'])) {

					$image = $_POST['image'];
				}
 
				if (isset($_FILES['pdf'])) {

					$file = explode(".", $_FILES['pdf']['name']);
					$pdf = Book::generateName() . '.' . end($file);
				}
				elseif (isset($_POST['pdf'])) {
					$pdf = $_POST['pdf'];
				}

				if (Book::editBook($_POST['bookId'], $_POST['title'],
					$_POST['authorId'], $_POST['genreId'], $_POST['description'],
					$image, $pdf, $audio)) {

					echo "true";
					return true;
				}
				else {
					echo "false";
					die();
				}
			}
			else {
				echo "false";
				die();
			}
		}

		public function actionDraft () {

			if (isset($_POST['draft']) && isset($_SESSION['admin'])) {

				if ($handler = fopen($this->draft, "w")) {

					fwrite($handler, $_POST['draft']);
					fclose($handler);
				}
				else {

					echo "false";
					die();
				}
			}
		}

		public function actionGetDraft () {
			
			if (isset($_SESSION['admin'])) {

				$size = filesize($this->draft);

				if ($size > 0) {
				
					if ($handler = fopen($this->draft, "r")) {

						echo fread($handler, $size);
						fclose($handler);
					}
				}
				else {

					echo "false";
					die();
				}
			}
		}
	}

 ?>