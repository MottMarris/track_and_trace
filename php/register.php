<?php

	session_start();

	$taken = false;

	$name = $_POST["name"];
	$surname = $_POST["surname"];
	$username = $_POST["username"];
	$password = $_POST["password"];

	if (strlen($password) < 8) {
		header('HTTP/1.1 400 Invalid password');
		die();
	}

	$servername = 'localhost';
	$sql_username = "Mottmarris";
	$sql_password = "password";
	$dbname = "webdev";

	$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

	$sql = "SELECT uname FROM users";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
	    if ($row["uname"] == $username) {
				$taken = true;
			}
		}
	}

	if ($taken == true) {
		header('HTTP/1.1 400 Username taken');
		die();
	}
	else {

		$options = ["cost" => 12];
		$password = password_hash($password, PASSWORD_BCRYPT, $options);

		$sql = "INSERT INTO users (fname, lname, uname, pword)
		VALUES ('$name', '$surname', '$username', '$password')";
		$conn->query($sql);
	}

	$conn->close();

	$_SESSION["name"] = $name;
	$_SESSION["uname"] = $username;
	$_SESSION["login"] = true;

	die();

?>
