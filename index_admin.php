<?php

// will allow only admin
if($_SESSION['status'] != 'admin'){
	header("Location: index.php"); 
	exit();	
}

?>

<!-- section right -->
<div id="content-admin" style="margin: 10px 20px 0 0; font-size: 16px; font-weight: bold; width: 100%">
	<div style="float: center;">
		<div id="get-data"></div>
	</div>
	<div style="position: absolute; right: 10px; top: 10px;">
		<form action="index.php">
			Welcome <?php echo $_SESSION['register']; ?>
			<button class='btn btn-warning' id="edit" type='submit' name='list'>Edit</button>
			<button class='btn btn-info' id="logout" type='submit' name='logout'>Log Out</button>
		</form>
	</div>
</div>

<div id="carScreen"></div>

<script type="text/javascript">

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
				document.getElementById('get-data').innerHTML = data;
			}
		}

		xhttp.open("GET", "admin-get-data.php", true);
		xhttp.send();

		setTimeout("getData()", 1000);
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
				document.getElementById('carScreen').innerHTML = data;
			}
		}

		xhttp.open("GET", "car.php", true);
		xhttp.send();

		setTimeout("getCar()", 1000);
	}

	getData();
	getCar();

</script>