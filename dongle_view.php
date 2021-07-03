<?php 



require_once "inc/session.php";
require_once "inc/conn.php";


$db->exec("UPDATE meta_data SET value='false' WHERE meta='trigger'");

$total_energy_consumed = energy_format(($db->query("SELECT SUM(last_power) FROM device_power_graph"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2);

$meter_power = energy_format(($db->query("SELECT SUM(last_power) FROM meter_power_graph WHERE meter='I'"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2);


if (get('shutdown')) {
	exec("sudo shutdown now");
}

if (get('restart')) {
	exec("sudo reboot");
}

if (get('update')) {
	echo ("Updating... <br>...<br>...<br>");

	echo ("Getting files from server...<br>");
	if(exec("sudo git reset --hard")){

		if(exec("sudo git pull")){
		echo ("Running bash script...<br>");

			exec("sudo installer/update.sh");

			// echo "<meta http-equiv='refresh'  content='5,url=http://localhost/dongle_view.php?restart=1'>";
			// exit();

		}else{
			echo "<meta http-equiv='refresh' content='10, http://localhost/dongle_view.php'> ";
			die("Could not retrieve files");
		}
	}else{
		  echo "<meta http-equiv='refresh' content='10, http://localhost/dongle_view.php'> ";
		die("Could not reset git <br> Reloading page...");
	}
}


?>

 <!DOCTYPE html>
 <html>
 <head>

 	<meta name="viewport" content="width=device-width, inital-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery-3.6.0.min.js"></script>

 	<title></title>


	<!-- Icons -->
	<link href='assets/css/boxicons.min.css' rel='stylesheet'/>
 </head>
 <style type="text/css">
 	body{
 		margin: auto;
 		background: url('assets/images/dongle_view_bg.png') center no-repeat;
 		background-size: cover;
		background-attachment:fixed;
		overflow: hidden;
 	}
 	a{
 		text-decoration: none;
 		color: inherit;
 	}

 	.circle{
 		max-width: 380px;
		background: rgb(255,255,255,0.8);
 		padding: 30px;
 		text-align: center;
 		border-radius: 30px;
 		overflow: hidden;
 		padding-top: 30px;
 		font-size: 22px !important;
 		margin: auto;
 	}

 	.bg-circle{
 		font-weight: 600;
 		font-size: 1.8em !important;
		background:#fff;
		color: #000;
		font-weight: bolder;
		line-height:150px;
		border-radius:10px;
		box-shadow: 0 0 10px 0 rgb(0,0,0,0.2);
		margin-bottom: 20px;
 	}

	.title{
		font-size: 1em !important;
		color: black;
		text-align: center;
		font-weight: 500;
		margin-bottom: 20px;
	}

	.bg-footer{
		text-align: left;
		line-height: 1.3em;
		font-weight: 500;
		font-size: 18px !important;
	}

	.customnav{
		margin: 10px 20px 10px 60px;
		width: calc(100% - 80px);
	}

	.nav1{
		background: #fff;
		padding-right: 30px;
		border-top-right-radius: 100px;
		border-bottom-right-radius: 100px;
		display: inline-block;
	}

	.dp{
		width: 40px;
		height: 40px;
		border-radius: 100px;
		background: #fff url(assets/images/male_avatar.png) center;
		background-size: cover;
		float:  left;
		margin-left: -25px;
	}
	.navtime{
		font-size: 24px;
		font-weight: bolder;
		color: black;
		margin-left: 10px;
		float:  left;
		line-height: 40px;
	}

	.dp2{
		width: 40px;
		height: 40px;
		background: #fff url(assets/images/weather-rain.png) center no-repeat;
		background-size: contain;
		margin-left: 20px;
		float: left;
	}

	.chatbx{
		width: 400px;
		height: 50px;
		margin: auto;
		background: url(assets/images/dc.png) center no-repeat;
		background-size: contain;
		text-align: center;
		line-height: 1.8em;
		transform: scale(1.3);
		margin-bottom: 20px;
		font-size: 1.2em;
		position: relative;
		z-index: 3;
	}

	.vivian{
		width: 100px;
		height: 100px;
		border-radius: 1000px;
		margin: auto;
		background: url(assets/images/df.png) center no-repeat;
		background-size: cover;
		position: relative;
		border: 5px solid black;
		z-index: 3;

	}

	.greyness{
		width: 100vw;
		height: 100vh;
		background: rgb(0, 0, 0, 0.5);
		position: absolute;
		z-index: 2;
		left: 0;
		top: 0;
		display:none;
		transform: scale(1.5);
	}

	.nav2{float: right;display: inline-block;}

	.shutdown{
		width: 40px;
		height: 40px;
		border-radius: 100%;
		background: #fff;
		float: right;
		color: red;
		line-height: 40px;
		font-size: 30px;
		text-align: center;
	}

	.restart, .update{
		width: 40px;
		height: 40px;
		margin-right: 20px;
		border-radius: 100%;
		background: #fff;
		float: right;
		color: green;
		line-height: 40px;
		font-size: 30px;
		text-align: center;
	}

	.update{
		color: #418bca;
	}

 </style>
 <body>

 	<div class="greyness" id="greyness"></div>

 	<div class="customnav">
 		<div class="nav1">
 			<div class="dp"></div>
 			<div class="navtime" id="time"><?php echo date("h:i") ?> <span style="font-weight:lighter"><?php echo date("A") ?></span></div>
 			<!-- <div class="dp2"></div> -->
 			<!-- <div class="navtime">22<span style="font-weight:lighter">°C</span></div> -->
 			<div class="navtime" style="font-weight:lighter;font-size: 12px;"><i class="bx bx-copyright"></i>ROBOTICS AND ARTIFICIAL INTELLIGENCE NIGERIA</div>
 			<div style="clear:both"></div>
 		</div>	

 		<div class="nav2">
 			<a href="?shutdown=1"><div class="shutdown"><i class='bx bx-power-off'></i></div></a>
 			<a href="?restart=1"><div class="restart"><i class='bx bx-refresh' ></i></div></a>
 			<a href="?update=1"><div class="update"><i class='bx bx-download'></i></div></a>
 			<div style="clear: both"></div>
 		</div>

 	</div>



 	<div class="chatbx" id='chatbx'>"Say Hello Vivien"</div>
 	<div class="vivian"></div>

 	<br>

 	<div class="container">
 	<div class="row">

 		<div class="col">
 			<a href="index.php">
 			<div class="circle">
			<div class="title">Device Consumed</div>
 				<div class="bg-circle" style="color: #3960fd">
                    <img src="assets/svgs/energy1.svg" style="width: 30px; height: 30px;margin-right: -10px;"/>
 					<span id='device_energy'><?php echo $total_energy_consumed;?></span>
				</div>
 				<div class="bg-footer">From Smart <br><span style='color: #3960fd;'>Devices</span></div>
 			</div>
	 		</a>
 		</div>

 		<div class="col">
 			<a href="index.php">
 			<div class="circle">
			<div class="title">Energy Generated</div>
 				<div class="bg-circle" style="color: #b76f14">
                    <img src="assets/svgs/energy1.svg" style="width: 30px; height: 30px;margin-right: -10px;"/>
 					<span id='meter'><?php echo $meter_power;?></span>
 				</div>
 				<div class="bg-footer">Total <br> <span style='color: #b76f14;'>Energy</span></div>
 			</div>
	 		</a>
 		</div>

 		<div class="col">
 			<a href="index.php?page=devices">
 			<div class="circle">
			<div class="title">Devices</div>
 				<div class="bg-circle" id="devices" style="color: brown">
 					<?php $active_time = time() - 60; ?>
 					<?php echo $db->query("SELECT COUNT(*) AS count FROM device_active WHERE off_time>$active_time")->fetchArray()['count']; ?>
 					/
 					<?php echo $db->query("SELECT COUNT(*) AS count FROM device_summary")->fetchArray()['count']; ?></div>
 				<div class="bg-footer">Connected<br>Devices</div>
 			</div>
	 		</a>
 		</div>


 	</div>
 	</div>

 </body>
 </html>


<script>
    var postLink = "inc/post.php";
	var nlp;
	var new_trigger = 0;

	$('#greyness').fadeOut();
	
	function updatePage(){
		$.post(postLink, {update_page:  'dongle_view'}, function(res){
			console.log(res);
            if (nlp = JSON.parse(res)){
				var trigger = nlp.trigger;
				// document.getElementById('nlp_q').innerHTML = nlp.nlp_q;
				// document.getElementById('nlp_r').innerHTML = nlp.nlp_r;
				document.getElementById('devices').innerHTML = nlp.devices;
				document.getElementById('device_energy').innerHTML = nlp.device_energy;
				document.getElementById('meter').innerHTML = nlp.meter;
				document.getElementById('time').innerHTML = nlp.time;
				if(new_trigger !== trigger){
					if(trigger=='false'){
						$('#greyness').fadeOut();
						document.getElementById('chatbx').innerHTML = "\"Say Hello Vivien\"";
					}
					if(trigger=='true'){
						$('#greyness').fadeIn();
						document.getElementById('chatbx').innerHTML = "<i>Listening...</i>";
					}
					new_trigger = trigger;
				}

				setTimeout(function(){
					updatePage();
				}, 500);
			}

        });
	}

	updatePage();
</script>

<?php 
$db->close();
unset($db);
 ?>