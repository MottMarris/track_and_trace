<?php
session_start();
 ?>
<html>
	<head>
		<title>COVID-CT: Overview</title>
		<link rel="stylesheet" href="../stylesheets/background_and_title.css">
		<style>
			table.visits {
				position: absolute;
				top: 7cm;
				left: 12.5cm;
				width: 19.3cm;
				height: 9.2cm;
				display:inline-block;
			}
			table.visits thead tr{
				font-family: Arial;
				font-size: 20;
				font-weight: bold;
			}
			table.visits thead tr th{
				padding-right: 54px;
				padding-left: 54px;
			}
			table.visits tbody tr td{
				text-align: center;
				font-family: "Times New Roman";
				font-size: 20;
				padding-top: 15px;
				padding-right: 30px;
				padding-left: 30px;
			}
			.remove {
				background: url("../img/cross.png");
				background-size: 30px 30px;
		    height: 30px;
		    width: 30px;
				border: none;
			}
		</style>
		<script>
			function removeRow(button) {
        button.parentNode.parentNode.remove();
				var xmlhttp = new XMLHttpRequest();
				var input = "id="+button.id;
				xmlhttp.open("POST", "../php/delete_row.php", true);
				xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xmlhttp.send(input);
			}
		</script>
	</head>
	<body>
		<img class="background" src="../img/covid.png" width="550px">
		<h1 class="title">COVID-19 Contact Tracing</h1>
		<ul class="menu">
			<li><a href="homepage.php">Home</a></li>
			<li><a class="current">Overview</a></li>
			<li><a href="add_visit.html">Add Visit</a></li>
			<li><a href="report.html">Report</a></li>
			<li><a href="settings.php">Settings</a></li>
			<li><a href="../php/logout.php" class="logout">Logout</a></li>
		</ul>
	  <table class="visits" id="visits">
			<thead>
				<tr>
					<th>Date</th>
					<th>Time</th>
					<th>Duration</th>
					<th>X</th>
					<th>Y</th>
				</tr>
			</thead>
			<tbody>
				<?php
				  $servername = 'localhost';
				  $sql_username = "Mottmarris";
				  $sql_password = "password";
				  $dbname = "webdev";

				  $conn = new mysqli($servername, $sql_username, $sql_password, $dbname);

				  $sql = "SELECT * FROM visits";
				  $result = $conn->query($sql);

				  if ($result->num_rows > 0) {
				    while($row = $result->fetch_assoc()) {
							if ($row["uname"] == $_SESSION["uname"]) {
								?>
					      <tr>
					        <td><?php echo strval(date("d/m/Y", strtotime($row['date']))) ?></td>
					        <td><?php echo substr($row['time'], 0, 5) ?></td>
					        <td><?php echo $row['duration'] ?></td>
					        <td><?php echo $row['X'] ?></td>
					        <td><?php echo $row['Y'] ?></td>
									<td><button class="remove" onclick="removeRow(this)" id=<?php echo $row['id']?>></button<></td>
					      </tr>
					<?php
								}
				      }
				    }
					?>
			</tbody>
	  </table>
	</body>
</html>
