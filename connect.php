<?php

$db_server = 'localhost';
$db_username = '';
$db_password = '';
$db_name = 'car_racing';

$conn = new mysqli($db_server, $db_username, $db_password, $db_name);
if($conn->connect_error){
	die("Connect dabase failed: " . $conn->connect_error);
}

?>