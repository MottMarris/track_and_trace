<?php

	setcookie("window",  $_POST["window"], time() + (86400 * 30), "/");
	setcookie("distance", $_POST["distance"], time() + (86400 * 30), "/");

	header("Location: ../HTML/settings.php");

 ?>
