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

if($_SESSION['status'] != "admin"){
	header("location: index.php");
	exit();
}

$home = $_SESSION['index'];
$page = "manage.php";

// take new edit user data
if(isset($_REQUEST['edit-submit']) and isset($_SESSION['register']) and $_SESSION['status'] == 'admin' ){

    $loginname = trim($_REQUEST['username']);
    $fname = trim($_REQUEST['fname']);
    $lname = trim($_REQUEST['lname']);
    $status = trim($_REQUEST['status']);

    include 'connect.php';
    $sql = "UPDATE users set fname='$fname', lname='$lname', status='$status' where username='$loginname'";
    $conn->query($sql);    

	$html = "<div align='center' style='margin-top: 40px;'>
				<div style='font-size: 25px; font-weight: bold; color: #4CAF50'>
					Full name for User: $loginname is changed.
				</div><br>
				<a href='$page?list'>
					<button id='home'>Back</button></a>
			</div>";

	echo $html;
	exit();
}

// edit user data
if(isset($_REQUEST['edit']) and isset($_SESSION['register']) and $_SESSION['status'] == 'admin' ){

    $loginname = trim($_REQUEST['username']);
	include 'connect.php';
	$sql = "SELECT * from users where username='$loginname'";
	$result = $conn->query($sql);

	if($result->num_rows > 0){
		$row = $result->fetch_assoc();
		$fname = $row['fname'];
		$lname = $row['lname'];
		$status = $row['status'];

		if($status == 'admin'){
			$a = "selected=''";
			$u = "";
		}else{
			$a = "";
			$u = "selected=''";
		}

		// gen form to edit
    	include 'edit.php';
	}
	exit();
}

// clear user password
if(isset($_REQUEST['clear']) and isset($_SESSION['register']) and $_SESSION['status']=='admin' ){

    $loginname = trim($_REQUEST['username']);
    include 'connect.php';
    $sql = "UPDATE users set password='' where username='$loginname'";
    $conn->query($sql);       

	$html = "<div align='center' style='margin-top: 40px;'>
				<div style='font-size: 25px; font-weight: bold; color: #4CAF50'>
					Password for User: $loginname is clear.
				</div><br>
				<a href='$page?list'>
					<button id='home'>Back</button></a>
			</div>";

	echo $html;
	exit();
}

//delete user
if(isset($_REQUEST['delete']) and isset($_SESSION['register']) and $_SESSION['status']=='admin' ){

    $loginname = trim($_REQUEST['username']);
    include 'connect.php';
    $sql = "DELETE from users where username='$loginname'";
    $conn->query($sql);

    $html = "<div align='center' style='margin-top: 40px;'>
				<div style='font-size: 25px; font-weight: bold; color: #4CAF50'>
					User: $loginname is deleted.<br>
				</div><br>
				<a href='$page?list'>
					<button id='home'>Back</button></a>
			</div>";

	echo $html;
	exit();
}

// listing all users
if(isset($_SESSION['register']) and $_SESSION['status']=='admin' and isset($_SESSION['list'])){

	// Dispaly all user names
	$html = "<div class='container text-center'>
				<h2>All User Register</h2><br>
				<div class='row'>
				<div col-md-6>
				<table class='table table-striped table-hover'>
					<thead class='text-center'>
					<tr>
						<th>No.</th>
						<th>Username</th>
						<th>Fullname</th>
						<th>Edit</th>
						<th>Clear</th>
						<th>Delete</th>
					</tr><thead>";

	include 'connect.php';
	$sql = "SELECT * from users";
	$result = $conn->query($sql);
	$no = 1;
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$loginname = $row['username'];
			$fullname = $row['fname']." ".$row['lname'];

			$edit = "<a href='$page?edit=y&username=$loginname'>
						<button class='btn btn-info' id='logout'>Edit</button>
					</a>";
			$clear = "<a href='$page?clear=y&username=$loginname'>
						<button class='btn btn-warning' id='clear'>Clear</button>
					</a>";
			$delete = "<a href='$page?delete=y&username=$loginname'>
						<button class='btn btn-danger' id='stop'>Delete</button>
					</a>";

			$html .= "<tbody><tr>
						<td align='center'>$no</td>
						<td style='padding: 8px;'>$loginname</td>
						<td style='padding: 8px;'>$fullname</td>
						<td align='center'>$edit</td>
						<td align='center'>$clear</td>";

			if($loginname != 'admin'){
				$html .= "<td align='center'>$delete</td>";
			}else{
				$html .= "<td></td>";			
			}

			$html .= "</tr>";
			$no++;
		}
	}

	$html .= "</tbody></table><br>
				<a href='$home'><button class='btn btn-primary' id='home'>Home</button></a>	
			</div></div></div>";

	echo $html;
}

?>

</body>
</html>