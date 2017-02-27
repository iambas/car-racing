<?php

session_start();

if(isset($_SESSION['register']) and isset($_SESSION['fullname'])){
	$loginname = $_SESSION['register'];	
	include 'connect.php';
	$sql = "SELECT * from users where username='$loginname' and online='yes'";
	$result = $conn->query($sql);

	if($result->num_rows > 0){
		$u = trim($_REQUEST['u']);
		$p = trim($_REQUEST['p']);

		if($p > 7 or $p < 1){
			header("location: index.php");
			exit();
		}

		$row = $result->fetch_assoc();
		$p += $row['score'];
		$sql = "UPDATE users set score=$p where username='$u'";
		$conn->query($sql);
	}
}

header("Location: index.php");
exit();

?>