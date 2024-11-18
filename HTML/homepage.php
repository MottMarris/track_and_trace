<?php
	session_start();
?>
<html>
	<head>
		<title>COVID-CT: Home Page</title>
		<link rel="stylesheet" href="../stylesheets/background_and_title.css">
		<style>
			div.text {
				margin-left: 13.5cm;
				width: 6cm;
				font-family: "Times New Roman";
				font-size: 20;
			}
			div.text p {
				padding-bottom: 3.5cm
			}
		</style>
		<script>
			function markerClick(img){
				var datetime = img.getAttribute("value");
				var date = datetime.substring(0, 10);
				var time = datetime.substring(10, 16);
				var string = new String("A person who recently tested positive for COVID-19 was at this location on " + date + " at" + time + ".");
				alert(string);
			}
		</script>
	</head>
	<body id="body">
		<img class="background" src="../img/covid.png" width="550px">
		<img class="exeter" src="../img/exeter.jpg" id="exeter">
		<h1 class="title">COVID-19 Contact Tracing</h1>
		<ul class="menu">
			<li><a class="current">Home</a></li>
			<li><a href="overview.php">Overview</a></li>
			<li><a href="add_visit.html">Add Visit</a></li>
			<li><a href="report.html">Report</a></li>
			<li><a href="settings.php">Settings</a></li>
			<li><a href="../php/logout.php" class="logout">Logout</a></li>
		</ul>
		<h2 class="page-title">Status</h2>
		<hr class="underline">
		<div class="text">
			<p id="greeting">
				Hi <?php echo $_SESSION["name"] ?>, you might have had a connection to an
				infected person at the location shown in red.
			</p>
			<p>Click on the marker to see details about the infection.</p>
		</div>
		<?php
			if (($handle = curl_init())===false) {
				echo "Curl-Error: " . curl_error($handle);
			}
			else {
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_FAILONERROR, true);
			}
			switch ($_COOKIE["window"]) {
				case "One week":
					$ts = 1;
					break;
				case "Two weeks":
					$ts = 2;
					break;
				case "Three weeks":
					$ts = 3;
					break;
				case "Four weeks":
					$ts = 4;
					break;
				default:
					$ts = 10;
					break;
			}
			$url = "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/infections?ts=$ts";
			curl_setopt($handle, CURLOPT_URL, $url);
			curl_setopt($handle, CURLOPT_HTTPGET, true);
			curl_setopt($handle, CURLOPT_HEADER, false);
			if (($output = curl_exec($handle)) !== false) {
				$infections = json_decode($output, true);
			}
			$id = 1;
			foreach($infections as $infection) {
				$servername = 'localhost';
				$sql_username = "Mottmarris";
				$sql_password = "password";
				$dbname = "webdev";

				$conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

				$sql = "SELECT * FROM visits";
				$result = $conn->query($sql);

				$contact = false;

				if ($result->num_rows > 0) {
				  while($row = $result->fetch_assoc()) {
				    $distance = sqrt(pow($row["X"] - $infection["x"], 2) + pow($row["Y"] - $infection["y"], 2));
						if ($distance < $_COOKIE["distance"] && $row["uname"] == $_SESSION["uname"]) {
							$contact = true;
						}
					}
				}
				$conn->close();
				?>
				<script type="text/javascript">
				  var contact = false;
					<?php if ($contact === true) {
						?> contact = true;
						<?php } ?>
					var img = document.createElement("img");
					var exeter = (document.getElementById("exeter"));
					if (contact) {
						img.src = "../img/marker_red.png";
					}
					if (!contact) {
						img.src = "../img/marker_black.png";
					}
					img.width = 25;
					img.style.position = "absolute";
					img.style.top = <?php echo $infection["y"] ?> + exeter.offsetTop - 23;
					img.style.left = <?php echo $infection["x"] ?> + exeter.offsetLeft - 10;
					<?php $date = str_replace('-', '/', $infection["date"]); $date = strval(date("d/m/Y", strtotime($date))); ?>
					img.setAttribute("value", "<?php echo $date ?>".concat(" <?php echo $infection["time"] ?>"));
					img.setAttribute('onclick','markerClick(this)');
					if (!(parseInt(img.style.left, 10) < 773 || parseInt(img.style.left, 10) > 1166)
					&& !(parseInt(img.style.top, 10) < 282 || parseInt(img.style.top, 10) >  615)) {
						document.getElementById("body").appendChild(img)
					}
				</script>
			<?php
					$id++;
			}
		 ?>
	</body>
</html>
