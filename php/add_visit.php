<?php
	session_start();

	$date = $_POST["date"];
	$time = $_POST["time"];
	$duration = $_POST["duration"];
	$x = $_POST["x"];
	$y = $_POST["y"];
	$uname = $_SESSION["uname"];

	$date = str_replace('/', '-', $date);
	$date = strval(date("Y-m-d", strtotime($date)));

	$servername = 'localhost';
	$sql_username = "Mottmarris";
	$sql_password = "password";
	$dbname = "webdev";

	$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

	$sql = "INSERT INTO visits (date, time, duration, X, Y, uname)
					VALUES ('$date', '$time', '$duration', '$x', '$y', '$uname')";

	$conn->query($sql);
	$conn->close();

	header("Location: ../HTML/add_visit.html");
	die();

 ?>
