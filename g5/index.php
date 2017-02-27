<?php

session_start();

$thislink = $_SERVER['PHP_SELF'];
$_SESSION['index'] = $thislink;

?>

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

if(!file_exists("image"))
	mkdir("image", 0700, true);

// request register or login
if (!isset($_SESSION['register'])){

	include 'login-register.html';

	if(isset($_SESSION['has_user'])){
		if($_SESSION['has_user'] == 1){
			unset($_SESSION['has_user']);
			alert("System has user.");
		}
	}

	if(isset($_SESSION['login_failed'])){
		if($_SESSION['login_failed'] == 1){
			unset($_SESSION['login_failed']);
			alert("Username or password invalid.");
		}
	}

}else{
	// login with admin
	if($_SESSION['status'] == 'admin'){
		include 'index_admin.php';
		
	// login with user
	}else{
		include 'index_user.php';
	}
}

// logout
if (isset($_REQUEST['logout'])){
	$user = $_SESSION['register'];
	unset($_SESSION['register'], $_SESSION['fullname']);

	include 'connect.php';
	$sql = "UPDATE users set online='no' where username='$user'";
	$conn->query($sql);

	// refresh this page
	header("Location: $thislink");    
	exit(); 
}

// for edit user 
if (isset($_REQUEST['list'])){
	$_SESSION['list'] = "list";

	// goto manager.php
	header("Location: manage.php");    
	exit(); 
}

function alert($t){
	echo "<script>window.alert('$t')</script>";
}

?>

</body>
</html>