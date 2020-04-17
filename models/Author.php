<?php 

	class Author {

		public static function addAuthor ($name) {
			$db = Database::getConnection();

			$result = $db->prepare("INSERT INTO authors (Name) VALUE (?)");

			if ($result->execute([$name])) {

				return $db->lastInsertId();
			}

		}


		public static function editAuthor ($name, $authorId) {
			$db = Database::getConnection();

			return $db->prepare("UPDATE authors SET Name = ? WHERE Id = ?")
			->execute([$name, $authorId]);
		}

		public static function getAuthors () {
			$db = Database::getConnection();

			$result = $db->query("SELECT * FROM authors");

			if ($result) {
				
				return $result;
			}

			return false;
		}

	}

 ?>