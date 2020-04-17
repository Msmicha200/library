<?php

require_once(ROOT."/models/User.php");
require_once(ROOT."/models/Book.php");
require_once(ROOT."/models/Author.php");
require_once(ROOT."/models/Genre.php");


class MainController {

	# main action
	public function actionIndex() {
		require_once(ROOT."/views/main/index.php");
		
		return true;
	}

	public function actionBook () {

		if ($book = Book::getBook($_GET['Id'])) {

			$comments = Book::getComments($_GET['Id']);
			require_once(ROOT."/views/book/index.php");
			
			return true;			
		}
		else {

			header("Location: /notfound");
		}
	}

	public function actionUser () {
		require(ROOT."/views/user/index.php");
		
		return true;
	}

	public function actionNotfound () {

		require(ROOT."/views/404/index.php");
		die();
	}
	
	public function actionDownload () {

		if (isset($_GET['path'])) {
			
			$path = $_GET['path'];
			$pdfname = basename($path);
			header("Content-Type: application/octet-stream");
			header("Content-Transfer-Encoding: Binary");
			header("Content-disposition: attachment; filename=" . $pdfname);
			echo readfile(ROOT.$path);
			die();
		}

		return true;
	}

	public function actionLastBooks () {

		if ($result = Book::lastBooks()) {

			echo json_encode($result);
			return true;
		}
		else {
			
			echo "false";
			die();
		}
	}

	public function actionRegister () {
		
		if (isset($_POST['login']) && isset($_POST['password'])
			&& isset($_POST['email'])) {

			if (strlen($_POST['password']) >= 8 && 
				strlen($_POST['login']) >= 5) {
				 
				 $result = User::registerUser($_POST['login'], $_POST['password'],
					$_POST['email']);

				 if ($result) {

				 	if (User::startUserSession($result)) {
				 		
				 		echo "true";
				 	}
				 }
			}
		}
		else {

			echo "false";
			die();
		}
	}

	public function actionSort () {

		if (isset($_GET['authorId']) && isset($_GET['genreId'])) {

			if ($result = 
				Book::getSortedBooks($_GET['authorId'], $_GET['genreId'])) {
				
				$response = array("result" => $result);

				if (isset($_SESSION['user'])) {

					$response['user_id'] = $_SESSION['user'];
				}
				else {
					$response ['user_id'] = false;
				}
				
				echo json_encode($response);
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

	public function actionComment () {

		if (isset($_SESSION['user']) && isset($_POST['bookId']) 
			&& isset($_POST['comment'])) {

			if (strlen($_POST['comment']) < 10) {

				echo "false";
				die();
			}

			if (Book::addComment($_POST['bookId'], $_POST['comment'], 
				$_SESSION['user'])) {
				
				echo User::getUser($_SESSION['user']);
				
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

	public function actionLike () {

		if (isset($_POST['bookId']) && isset($_SESSION['user'])) {

			if (Book::toCollection($_POST['bookId'], $_SESSION['user'])) {

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

	public function actionCheck () {
		
		if (isset($_POST['login']) && isset($_POST['password'])) {

			$result = User::check($_POST['login'], $_POST['password']);

			if ($result) {

				if (User::startUserSession($result)) {

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
	}

	public function actionResetPassword () {

		if (isset($_GET['token'])) {

			require_once(ROOT."/views/resetpass/index.php");
			
			return true;
		}
		else {

			header("Location: /notfound");
		}
	}

	public function actionResetIt () {

		if (isset($_POST['email'])) {
			
			if (User::remindPassword($_POST['email'])) {
				
				echo "true";
				
				return true;
			}
			else {

				echo "Error sending";
				die();
			}
		}
		else {
			
			echo "false";
			die();
		}
	}

	public function actionSetPassword () {

		if (isset($_POST['password']) && isset($_POST['token'])) {

			if (strlen($_POST['password']) >= 8) {

				if (User::setNewPassword($_POST['password'], $_POST['token'])) {

					echo "true";
					die();
				}
				else {

					echo "Error with setting new password";
					die();
				}
			}
			else {

				echo "Count error";
				die();
			}
		}
		else {

			header("Location: /notfound");
			die();
		}
	}

	public function actionLogout () {

		if (isset($_SESSION['user'])) {
			
			User::endUserSession();	
			header("Location: /main");
		}
		elseif (isset($_SESSION['admin'])) {

			User::endAdminSession();
			header("Location: /main");
		}
		else {
			header("Location: /main");
		}
	}

}

?>