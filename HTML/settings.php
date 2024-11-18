<html>
	<head>
		<title>COVID-CT: Settings</title>
		<link rel="stylesheet" href="../stylesheets/background_and_title.css">
		<style>
			h2.page-title {
				left: 19.5cm;
			}
			div.text {
				font-family: "Times New Roman";
				font-size: 20;
				width:15cm;
				margin-left: 14cm;
				text-align: center;
			}
			form.report label {
				text-align: left;
				font-size: 17s;
				font-family: "Times New Roman";
			}
			form.report {
				width: 12cm;
				height:20cm;
				margin: auto;
				margin-left: 14.8cm;
			}
			form.report select {
				width:10cm;
				height:1.2cm;
				margin-bottom: 0.4cm;
				margin-top: 0.5cm;
				background-color: transparent;
				border: 1px solid black;
			}
			form.report input.distance {
				width:10cm;
				height:1.2cm;
				background-color: transparent;
				border: 1px solid black;
			}
			input[type="text"] {
				text-align: center;
				font-size: 17;
				font-family: "Times New Roman";
			}
			form.report input.reportbutton {
				border: 1px solid black;
				background-color: white;
				border-radius: 10px;
				height: 1.2cm;
				width: 3.5cm;
				margin-top: 0.5cm;
				margin-right: 3.5cm;
				margin-left: 1.3cm;
			}
			form.report input.cancelbutton {
				border: 1px solid black;
				background-color: white;
				border-radius: 10px;
				height: 1.2cm;
				width: 3.5cm;
				margin-top: 0.5cm;
				/* margin-right: 1cm; */
			}
			input[type=submit] {
				text-align: center;
				font-size: 17;
				font-family: "Times New Roman";
			}
		</style>
		<script>
			function checkForm() {

				var userWindow = document.getElementById("window").value;
				var distance = document.getElementById("distance").value;

				if (userWindow == null || userWindow == "") {
					alert("Please select a window.");
					return false;
				}

				if (distance == null || distance == "") {
					alert("Please enter a distance.");
					return false;
				}
				if (distance <= 0 || distance > 500) {
					alert("Distance must be between 0 and 500.");
					return false;
				}
				if (isNaN(distance)) {
					alert("Distance must be a number.");
					return false;
				}
				return true;
			}

			function saveSettings() {
				var xmlhttp = new XMLHttpRequest();
				var inputs = "window="+(document.getElementById("window").value)+"&"+"distance="
				+(document.getElementById("distance").value)
				xmlhttp.onreadystatechange = function() {
						alert("Settings saved succesfully.");
					}
				xmlhttp.open("POST", "../php/save_settings.php", true);
				xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				console.log(inputs);
				xmlhttp.send(inputs)
		}
		</script>
	</head>
	<body>
		<img class="background" src="../img/covid.png" width="550px">
		<h1 class="title">COVID-19 Contact Tracing</h1>
		<ul class="menu">
			<li><a href="homepage.php">Home</a></li>
			<li><a href="overview.php">Overview</a></li>
			<li><a href="add_visit.html">Add Visit</a></li>
			<li><a href="report.html">Report</a></li>
			<li><a class="current">Settings</a></li>
			<li><a href="../php/logout.php" class="logout">Logout</a></li>
		</ul>
		<h2 class="page-title">Alert Settings</h2>
		<hr class="underline">
		<div class="text">
			<p>Here you may change the alert distance and the time span for which
				the contact tracing will be performed.</p>
		</div>
		<form class="report" onsubmit="checkForm()" action="../php/save_settings.php" method="post">
			<label for="window">Window</label>
			<select name="window" id="window">
				<option disabled selected value></option>
			  <option value="One week">One week</option>
			  <option value="Two weeks">Two weeks</option>
			  <option value="Three weeks">Three weeks</option>
				<option value="Four weeks">Four weeks</option>
			</select>
			<label for="distance">Distance</label>
			<input class="distance" type="text" id="distance" name="distance" value=<?php echo $_COOKIE["distance"] ?>>
			<input class="reportbutton" type="submit" name="report" value="Report">
			<input class="cancelbutton" type="submit" name="cancel" value="Cancel">
		</form>
	</body>
</html>
