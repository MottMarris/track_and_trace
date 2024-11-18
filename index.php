<?php
	session_start();

	if (!isset($COOKIE["window"]) && !isset($COOKIE["window"])) {
		setcookie("window",  "1", time() + (86400 * 30), "/");
		setcookie("distance", "50", time() + (86400 * 30), "/");
	}

	if ($_SESSION["login"]) {
		header("Location: ../HTML/homepage.php");
	}
	else {
		header("Location: ../HTML/login.html");
	}

 ?>
