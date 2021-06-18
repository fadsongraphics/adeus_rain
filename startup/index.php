<?php 
	require_once "../inc/conn.php";

	if(post('scan')){


		// exec("sudo iwlist wlan0 scan");

		echo "
		<ul>
		</ul>
		";

	}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="../assets/js/jquery-3.6.0.min.js"></script>

</head>
<body>

 <div id="1" class="view">
 <h2>Welcome to your smart energy hub</h2>
	 This wizard will guide you through the registration process.
	 <br>
	 <br>
	 Please note that you need an adeus account before you can continue.
	 <br>
	 Log on to adeus.rainprojects.dev to create your adeus account.

	 <button onclick="showView(2)">Next</button>

</div>

 <div id="2" class="view">
 <h2>Connect to wifi</h2>

 	<ul>
 		<li onclick="select_ssid('dfd1')">dfd1</li>
 		<li onclick="select_ssid('dfd2')">dfd2</li>
 		<li onclick="select_ssid('dfd3')">dfd3</li>
 	</ul>

 	<input type="hidden" id="ssid">
	 <button onclick="showView(1)">Prev</button>

</div>


 <script type="text/javascript">
 	function showView(e){
 		$(".view").hide();

 		$("#"+e).fadeIn('fast');


 	}

 	function scanNetworks(){
 		$.post("index.php", {scan:1}, function(res){

 		})
 	}

 	function select_ssid(e){
 		$("#ssid").val(e);
 		console.log($("#ssid").val());
 	}

 	showView(1);
 </script>



</body>
</html>