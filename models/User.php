<?php 

	class User {

		public static function check ($login, $password) {
			$db = Database::getConnection();
			$password = hash("sha256", $password);

			$query = "SELECT Id FROM accounts WHERE Login = :login AND 
						Password = :password";
			$result = $db->prepare($query);
			$result->bindParam(":login",  $login);
			$result->bindParam(":password", $password);
			$result->execute();

			return $result->fetch(PDO::FETCH_ASSOC)['Id'];
		}

		public static function startUserSession ($id) {
			$_SESSION['user'] = $id;

			return true;
		}

		public static function startAdminSession () {
			$_SESSION['admin'] = 1;

			return true;
		}

		public static function endUserSession () {
			unset($_SESSION['user']);
			session_destroy();
			
			return true;
		}

		public static function endAdminSession () {
			unset($_SESSION['admin']);
			session_destroy();

			return true;
		}

		public static function getUser ($id) {
			$db = Database::getConnection();

			$query = $db->prepare("SELECT Login FROM accounts WHERE Id = ?");
			$query->execute([$id]);

			return $query->fetch()['Login'];
		}

		public static function registerUser ($login, $password, $email) {
			$db = Database::getConnection();
			$password = hash("sha256", $password);

			$result = $db->prepare("INSERT INTO accounts (Login, Email, Password)
				VALUES (?, ?, ?)")->execute([$login, $email, $password]);

			if ($result) {
				return $db->lastInsertId();
			}

			return false;
		}

		public static function setNewPassword ($password, $token) {
			$db = Database::getConnection();
			$password = hash("sha256", $password);

			$query = $db->prepare("SELECT Id FROM accounts WHERE Token = ?");
			$query->execute([$token]);

			$id = $query->fetch(PDO::FETCH_ASSOC)['Id'];

			if ($id) {

				$result = $db->prepare("UPDATE accounts SET Password = ? WHERE Id = ?")
				->execute([$password, $id]);

				if ($result) {

					return $db->prepare("UPDATE accounts SET Token = null WHERE Token = ?")
					->execute([$token]);
				}

			}

			return false;
		}

		public static function remindPassword ($email) {
			$db = Database::getConnection();
			$token = hash ("sha256", date("Y-m-d H:i:s"));

			$query = "UPDATE accounts SET Token = :token WHERE Email = :email";
			$result = $db->prepare($query);
			$result->bindParam(":token", $token, PDO::PARAM_STR);
			$result->bindParam(":email", $email, PDO::PARAM_STR);
			$result = $result->execute();

			$link = "library.uvmtest.space/resetPassword?token=".$token;

			$textMessage = wordwrap("Перейдіть <a href=\"$link\">сюди</a> для поновлення пароля" );
			$mail = mail($email, 'Remember password', 
				$textMessage, "Content-type:text/html");

			if ($result && $mail) {

				return true;
			}

			return false;
		}

	}

 ?>