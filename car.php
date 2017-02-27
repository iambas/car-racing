<?php

session_start();

$code = '';

include 'connect.php';
$sql = "SELECT * from users where online='yes' and status='user'";
$result = $conn->query($sql);

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		$user = $row['username'];
		$s = $row['score'];
		$l = $s."px";
		$t = "0px";
		$code .= "<div style='left: $l; top: $t; position: relative; font-weight: bold; font-size: 20px'>
					<img src='image/$user.png' id='image'/>$s</div>";
	}
}

echo $code;

?>