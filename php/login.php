<?php

	$login = false;
	$name;
	$uname;

	$username = $_POST["username"];
	$password = $_POST["password"];

	$servername = 'localhost';
	$sql_username = "Mottmarris";
	$sql_password = "password";
	$dbname = "webdev";

	$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

	$sql = "SELECT fname, uname, pword FROM users";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
	    if ($row["uname"] == $username) {
				if (password_verify($password, $row["pword"])) {
					$login = true;
					$name = $row["fname"];
					$uname = $row["uname"];
				}
			}
		}
	}

	else {
	  echo "0 results";
	}
	$conn->close();

	if ($login == true) {
		session_start();
		$_SESSION["name"] = $name;
		$_SESSION["uname"] = $uname;
		$_SESSION["login"] = true;
		header("Location: ../HTML/homepage.php");
		die();
	}
	else {
		header("Location: ../HTML/login.html");
	}
?>
