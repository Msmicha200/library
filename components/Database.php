<?php
# UVM

# Класс для работы с базой данных

# Class for working with database

class Database
{
	public static function getConnection()
	{
		$config = ROOT."/config/database.config.php";
		$parameters = include($config);
		$host = $parameters["host"];
		$dbname = $parameters["dbname"];
		$db = new PDO("mysql:host=$host;charset=utf8;dbname=$dbname", $parameters["user"], $parameters["password"]);
		
		return $db;
	}

}

# UVM
?>