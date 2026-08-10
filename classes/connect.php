<?php

/**
 * Thin mysqli wrapper used across the app.
 *
 * Credentials come from the environment so nothing secret lives in the repo.
 * Copy .env.example to .env and set them, or export them in your web server
 * config. The defaults below are the usual local XAMPP/MAMP values.
 */
class Database
{
	private $host;
	private $username;
	private $password;
	private $db;

	function __construct()
	{
		$this->host     = getenv('DB_HOST')     ?: 'localhost';
		$this->username = getenv('DB_USER')     ?: 'root';
		$this->password = getenv('DB_PASSWORD') ?: '';
		$this->db       = getenv('DB_NAME')     ?: 'but_db';
	}

	function connect()
	{
		$connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);

		if (!$connection) {
			die('Database connection failed: ' . mysqli_connect_error());
		}

		mysqli_set_charset($connection, 'utf8mb4');

		return $connection;
	}

	function read($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn, $query);

		if (!$result) {
			return false;
		} else {
			$data = false;
			while ($row = mysqli_fetch_assoc($result)) {

				$data[] = $row;

			}

			return $data;
		}
	}

	function save($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn, $query);

		if (!$result) {
			return false;
		} else {
			return true;
		}
	}

}
