<?php 

	class Genre {

		public static function addGenre ($title) {
			$db = Database::getConnection();

			$result = $db->prepare("INSERT INTO genres (Title) VALUE (?)");

			if ($result->execute([$title])) {

				return $db->lastInsertId();
			}
		}

		public static function editGenre ($title, $genreId) {
			$db = Database::getConnection();

			return $db->prepare("UPDATE genres SET Title = ? WHERE Id = ?")
			->execute([$title, $genreId]);
		}

		public static function getGenres () {
			$db = Database::getConnection();

			$result = $db->query("SELECT * FROM genres");

			if ($result) {
				return $result;
			}

			return false;
		}

	}

 ?>