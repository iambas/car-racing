<?php

if(!isset($_SESSION['register'])){
	exit();
}

$fullname = $_SESSION['fullname'];

?>

<div class="container-fluid">

	<div id="content-user" style="margin: 10px 20px 0 0; font-size: 16px; font-weight: bold; width: 100%">
		<div style="float: center;">
			<div id="screen"></div>
			<div id="randomScreen"></div>
		</div>
		<div style="position: absolute; right: 10px; top: 10px;">
			<form>
				Welcome <?php echo $_SESSION['register']; ?>
				<button class='btn btn-info' id="logout" type='submit' name='logout'>Log Out</button>
			</form>
		</div>
	</div>

	<div id="car-on-user"></div>
</div>


<script type="text/javascript">
	var n = 1;

	function sendMe(x, y) {

		//document.getElementById('test').innerHTML = n++;

		document.getElementById('bnRace').disabled = true;

		var xhttp;

		if (window.XMLHttpRequest) {
			// code for modern browsers
		    xhttp = new XMLHttpRequest();
	    } else {
	    	// code for old IE browsers
	    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xhttp.open("GET", "take-score.php?u="+x+"&p="+y, true);
		xhttp.send();
	}

	function getCar() {
		var xhttp;

		if (window.XMLHttpRequest) {
			// code for modern browsers
		    xhttp = new XMLHttpRequest();
	    } else {
	    	// code for old IE browsers
	    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xhttp.onreadystatechange = function (){
			if (this.readyState == 4 && this.status == 200){
				var data = xhttp.responseText;
				document.getElementById('car-on-user').innerHTML = data;
			}
		}

		xhttp.open("GET", "car.php", true);
		xhttp.send();

		setTimeout("getCar()", 1000);
	}

	function getData() {
		var xhttp;

		if (window.XMLHttpRequest) {
			// code for modern browsers
		    xhttp = new XMLHttpRequest();
	    } else {
	    	// code for old IE browsers
	    	xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xhttp.onreadystatechange = function (){
			if (this.readyState == 4 && this.status == 200){
				var data = xhttp.responseText;
				document.getElementById('screen').innerHTML = data;
			}
		}

		xhttp.open("GET", "user-get-data.php", true);
		xhttp.send();

		setTimeout("getData()", 1000);
	}

	getData();
	getCar();
	//getScreen();
	

</script>