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

$home = $_SESSION['index'];

// register 
if(isset($_REQUEST['username']) and isset($_REQUEST['password']) and isset($_REQUEST['register-submit'])){

	if(isset($_SESSION['register'])) unset($_SESSION['register']);

	// take submitted data

	/*$user = mysql_escape_string($_REQUEST['username']);
	$fname = mysql_escape_string($_REQUEST['fname']);
	$lname = mysql_escape_string($_REQUEST['lname']);
	$pass = mysql_escape_string($_REQUEST['password']);*/
	$user = $_REQUEST['username'];
	$fname = $_REQUEST['fname'];
	$lname = $_REQUEST['lname'];
	$pass = $_REQUEST['password'];

	if($user == '' or $pass == '' or $fname == '' or $lname == '') {
		//if empty do nothing
		if(isset($_SESSION['register'])) unset($_SESSION['register']);
		if(isset($_REQUEST['username'])) unset($_REQUEST['username']);
		if(isset($_REQUEST['fname'])) unset($_REQUEST['fname']);
		if(isset($_REQUEST['lname'])) unset($_REQUEST['lname']);
		if(isset($_REQUEST['password'])) unset($_REQUEST['password']);

	}else{

		include 'connect.php';
		$sql = "SELECT username from users where username = '$user'";
		$result = $conn->query($sql);

		if($result->num_rows > 0){
			$_SESSION['has_user'] = 1;
			$_SESSION['user'] = $user;
		}else{
			$pass = md5($pass);
			$sql = "INSERT INTO users (fname, lname, username, password, status, online, score) 
						values('$fname', '$lname', '$user', '$pass', 'user', 'yes', 0)";

			if($conn->query($sql) === false){
				echo "Register failed: ".$conn->error;
			}

			$_SESSION['register'] = $user;
			$_SESSION['status'] = $row['status'];
			$_SESSION['fullname'] = $fname." ".$lname;
			include 'image.php';
		}
	}
}

// login
if(isset($_REQUEST['username']) and isset($_REQUEST['password']) and isset($_REQUEST['login-submit'])){

	unset($_SESSION['register'], $_SESSION['fullname']);

	if(isset($_SESSION['login'])) unset($_SESSION['login']);

	// take submitted data
	//$user = mysql_real_escape_string($_REQUEST['username']);
	//$pass = mysql_real_escape_string($_REQUEST['password']);
	$user = $_REQUEST['username'];
	$pass = $_REQUEST['password'];

	// username or password empty
	if($user == '' or $pass == '') {

		$_SESSION['login_failed'] = 1;

		//if empty do nothing
		if(isset($_SESSION['register'])) unset($_SESSION['register']);
		if(isset($_REQUEST['username'])) unset($_REQUEST['username']);
		if(isset($_REQUEST['fullname'])) unset($_REQUEST['fullname']);
		if(isset($_REQUEST['password'])) unset($_REQUEST['password']);

	}else{

		include 'connect.php';
		$pass = md5($pass);
		$sql = "SELECT * FROM users where username = '$user' and password = '$pass'";
		$result = $conn->query($sql);

		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$_SESSION['register'] = $user;
			$_SESSION['status'] = $row['status'];
			$_SESSION['fullname'] = $row['fname']." ".$row['lname'];
			include 'image.php';


			$sql = "UPDATE users set online='yes' where username='$user'";
			$conn->query($sql);
		}else{
			$_SESSION['login_failed'] = 1;
		}
	}
}

header("Location: index.php");    
exit(); 

?>

</body>
</html>