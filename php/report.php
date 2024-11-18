<?php
	session_start();

	$date = $_POST["date"];
	$time = $_POST["time"];
	$uname = $_SESSION["uname"];

	$date = str_replace('/', '-', $date);
	$date = strval(date("Y-m-d", strtotime($date)));

	$servername = 'localhost';
	$sql_username = "Mottmarris";
	$sql_password = "password";
	$dbname = "webdev";

	$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

	$sql = "INSERT INTO infections (date, time, uname)
	VALUES ('$date', '$time', '$uname')";

	$conn->query($sql);

	$sql = "SELECT * FROM visits";

	$result = $conn->query($sql);

	$infections = array();

	while($row = $result->fetch_assoc()) {
		array_push($infections, json_encode(array("x"=>intval($row["X"]), "y"=>intval($row["Y"]),
		"date"=>$row["date"], "time"=>$row["time"], "duration"=>intval($row["duration"]))));
	}

	$conn->close();

	if (($handle = curl_init())===false) {
		echo "Curl-Error: " . curl_error($handle);
	}
	else {
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_FAILONERROR, true);
	}

	$url = "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/report";
	curl_setopt($handle, CURLOPT_URL, $url);
	curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
	for ($i = 0; $i < count($infections); $i ++) {
		curl_setopt($handle, CURLOPT_POSTFIELDS, $infections[$i]);
		echo $infections[$i];
		curl_exec($handle);
	}
 ?>
