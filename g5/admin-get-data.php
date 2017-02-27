<?php

session_start();

$server = $_SESSION['index'];

if(!isset($_SESSION['register']) or $_SESSION['status'] != 'admin'){
	exit();
}

$bn = "";

// clear and start
if(isset($_REQUEST['start'])){

	$timenow = time() + 3*60;
	file_put_contents('start', $timenow);

	include 'connect.php';
	$sql = "UPDATE users set score=0";
	$conn->query($sql);

	header("Location: $server");    
	exit();
}

// click stop
if (isset($_REQUEST['stop'])){
	unlink('start');
	header("Location: $server");    
	exit(); 
}

// logout
if (isset($_REQUEST['logout'])){
	$user = $_SESSION['register'];
	unset($_SESSION['register'], $_SESSION['fullname']);

	include 'connect.php';
	$sql = "UPDATE users set online='no' where username='$user'";
	$conn->query($sql);

	// refresh this page
	header("Location: index.php");    
	exit(); 
}


$loginname = $_SESSION['register'];
$str = '';

# Score
include 'connect.php';
$sql = "SELECT max(score) as mx, min(score) as mn from users where status='user'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$smax = $row['mx'];
$smin = $row['mn'];

$tm = '';

// clear expired start
unset($time_left);
if(file_exists('start')){
	$timenow = time();
	$end = file_get_contents('start');

	if($timenow > $end)	unlink('start');
	if($end > $timenow) $time_left = $end - $timenow;

	// display time left
	if(isset($time_left)){
		$tm .= "<div style='font-size: 20px; font-weight: bold; display: inline;'>
					[ Time left = <div style='color: #f44336; display: inline;'>$time_left</div> ]
				</div>";
	}

	// stop button
	$bn .= "<form action='admin-get-data.php'>
				<button class='btn btn-danger' id='stop' type='submit' name='stop'>Stop</button>
			</form>";
}else{
	// start button
	$bn .= "<form action='admin-get-data.php'>
				<button class='btn btn-success' id='start' type='submit' name='start'>Start</button>
			</form>";
}

// score max, min, time left and button
$str .= "<div id='score' style='font-size: 20px; font-weight: bold;'>
			Max : <div style='color: #4CAF50; display: inline'>$smax</div>, 
			Min : <div style='color: #f44336; display: inline'>$smin</div>
			$tm
		</div>".$bn;


# Count online users
include 'connect.php';
$sql = "SELECT * from users where online='yes' and status='user'";
$result = $conn->query($sql);
$cnt = $result->num_rows;

$pos = "position: absolute; top: 5px; left: 5px;";
$str .= "<a href='user-online.php'>
			<div style='font-size: 16px; font-weight: bold; $pos width: 200px; background-color: #ddd;'>
				User online are : 
				<div style='color: #4CAF50; display: inline;'>$cnt</div>
			</div></a>";

# display	
echo "$str";

?>