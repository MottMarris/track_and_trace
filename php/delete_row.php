<?php

$id = $_POST["id"];

$servername = 'localhost';
$sql_username = "Mottmarris";
$sql_password = "password";
$dbname = "webdev";

$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

$sql = "DELETE FROM visits WHERE id=$id";
$result = $conn->query($sql);

$conn->close();


 ?>
