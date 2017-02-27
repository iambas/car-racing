<!DOCTYPE html>
<html>
<head>
	<title>Car Racing</title>

	<link rel="stylesheet" type="text/css" href="asset/bootstrap.min.css">
	<script type="text/javascript" src="asset/bootstrap.min.js"></script>
	<script type="text/javascript" src="asset/jquery.js"></script>

	<link rel="stylesheet" href="asset/style.css">

</head>
<body>


<?php

session_start();

$home = "index.php";

if ($_SESSION['register'] != "admin"){
	header("Location: index.php"); 
	exit();	
}

$html = "<div class='container text-center'>
			<h2>All User Online</h2><br>
			<table class='table table-striped table-hover'>
				<tr>
					<th>No.</th>
					<th>Username</th>
				</tr>
		";		

# Count online users
include 'connect.php';
$sql = "SELECT fname,lname from users where online='yes' and status='user'";
$result = $conn->query($sql);

$no = 1;
if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		$d = $row['fname']." ".$row['lname'];
		$html .= "<tr>
					<td align='center'>$no</td>
					<td align='center' style='padding: 8px;'>$d</td>
				</tr>
				";	
		$no++;
	}
}

$html .= "	</table><br>
				<a href='$home'><button class='btn btn-primary' id='home'>Home</button></a>	
			";

echo $html;
?>

</body>
</html>