<?php

$db_server = 'localhost';
$db_username = '';
$db_password = '';
$db_name = 'car_racing';

$conn = new mysqli($db_server,$db_username, $db_password);
if($conn->connect_error){
	die("Connect server failed: " . $conn->connect_error);
}

$conn->query('CREATE DATABASE '.$db_name);

$conn = new mysqli($db_server, $db_username, $db_password, $db_name);
if($conn->connect_error){
	die("Connect dabase failed: " . $conn->connect_error);
}

$sql = 'CREATE TABLE users (
			id int(10) unsigned auto_increment primary key,
			fname varchar(20) not null,
			lname varchar(20) not null,
			username varchar(20) not null unique,
			password varchar(40) not null,
			status varchar(10) not null,
			online char(4) not null,
			score int(5) not null
		)';

if($conn->query($sql) === false){
	die("Create table users failed: ".$conn->error);
}

$conn->close();

?>