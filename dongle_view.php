<?php 

session_start();

require_once "inc/conn.php";
require_once "cron/cron.php";


$db->exec("UPDATE meta_data SET value='false' WHERE meta='trigger'");

#$total_energy_consumed = energy_format(($db->query("SELECT SUM(last_power) FROM device_power_graph"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2);

$meter_power = energy_format(($db->query("SELECT SUM(total_power) FROM meter_summary WHERE meter_type='G'"))->fetchArray(SQLITE3_ASSOC)['SUM(total_power)'], 2);
$meter_power_2 = energy_format(($db->query("SELECT SUM(total_power) FROM meter_summary WHERE meter_type='C'"))->fetchArray(SQLITE3_ASSOC)['SUM(total_power)'], 2);


if (isset($_SESSION['exec']) and !empty($_SESSION['exec'])) {
	if (get('sess')==$_SESSION['exec']) {

		if (get('shutdown')) {
			exec("sudo shutdown now");
		}

		if (get('restart')) {
			exec("sudo reboot");
		}

		if (get('update')) {
			echo ("Updating... <br>...<br>...<br>");

			echo ("Getting files from server...<br>");
			if(exec("git reset --hard")){

				if(exec("git pull")){

					echo ("Successful. Rebooting in 5 seconds...<br>");

					echo "<meta http-equiv='refresh'  content='5,url=?restart=1'>";
					exit();

				}else{
					echo "<meta http-equiv='refresh' content='10, ?=null'> ";
					die("Could not retrieve files");
				}
			}else{
				  echo "<meta http-equiv='refresh' content='10, ?=null'> ";
				die("Could not reset git <br> Reloading page...");
			}
		}

	}
}



$_SESSION['exec'] = uniqid();



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
 		background: #000 url('assets/images/banner.png') center no-repeat;
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
		background: rgb(2,198,172);
		background: linear-gradient(135deg, rgba(2,198,172,1) 58%, rgba(2,255,0,1) 100%);
 		padding: 30px;
 		text-align: center;
 		border-radius: 30px;
 		overflow: hidden;
 		padding-top: 30px;
 		font-size: 22px !important;
 		margin: auto;
 		transition: 1s;
 	}.circle:hover{
		background: rgb(2,198,172);
		background: linear-gradient(135deg, rgba(2,198,172,1) 10%, rgba(2,255,0,1) 100%);
 	}

 /*	.bg-circle{
 		font-weight: 600;
 		font-size: 1.8em !important;
		background:#fff;
		color: #000;
		font-weight: bolder;
		line-height:150px;
		border-radius:10px;
		box-shadow: 0 0 10px 0 rgb(0,0,0,0.2);
		margin-bottom: 20px;
 	}*/

 	.big-icon{
 		width: 60px;
 		height: 60px;
 		background: url(assets/images/energy_icon.png) center no-repeat;
 		background-size: cover;
 		margin: auto;
		margin-top: 30px;
 	}.devices-icon{
 		background: url(assets/images/devices_icon.png) center no-repeat;
 		background-size: cover;
 	}

 	.units{
 		font-weight: bolder;
 		color: #fff;
 		text-transform: uppercase;
 		font-size: 30px;
		margin-top: 20px;
 	}

	.title{
		font-size: 1em !important;
		color: #fff;
		text-transform: uppercase;
		text-align: center;
		font-weight: 500;
		margin-bottom: 20px;
	}

	.bg-footer{
		text-align: center;
		color: #fff;
		line-height: 1.3em;
		font-weight: 100;
		margin-top: 30px;
		font-size: 14px !important;
		text-transform: uppercase;
	}

	.customnav{
		margin: 10px 20px 10px 60px;
		width: calc(100% - 80px);
	}

	.nav1{
		padding-right: 30px;
		border-top-right-radius: 100px;
		border-bottom-right-radius: 100px;
		display: inline-block;
	}

	.navtime{
		font-size: 24px;
		font-weight: 500;
		color: #fff;
		margin-left: 10px;
		float:  left;
		line-height: 40px;
	}


	.chatbx{
		width: 400px;
		height: 50px;
		margin: auto;
		/*background: url(assets/images/dc.png) center no-repeat;*/
		/*background-size: contain;*/
		color: #fff;
		font-weight: 600;
		text-transform: uppercase;
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
		background: url(assets/images/power_icon.png) center no-repeat;
		background-size: cover;
		border-radius: 100%;
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
		background: url(assets/images/reboot_icon.png) center no-repeat;
		background-size: cover;
		float: right;
		color: green;
		line-height: 40px;
		font-size: 30px;
		text-align: center;
	}

	.update{
		color: #418bca;
		background: url(assets/images/update_icon.png) center no-repeat;
		background-size: cover;
	}

 </style>
 <body id="body">

 	<div class="greyness" id="greyness"></div>

 	<div class="customnav">
 		<div class="nav1">
 			<div class="navtime" id="time">
 				<?php echo date("h:i") ?> <span style="font-weight:lighter"><?php echo date("A") ?></span>

 				&nbsp;&nbsp;&nbsp;
 				<?php echo date("d:m:Y") ?>
 			</div>
 		</div>	

 		<div class="nav2">
 			<a href="?shutdown=1&sess=<?php echo $_SESSION['exec'];?>"><div class="shutdown"></div></a>
 			<a href="?restart=1&sess=<?php echo $_SESSION['exec'];?>"><div class="restart"></div></a>
 			<a href="?update=1&sess=<?php echo $_SESSION['exec'];?>" onclick="document.getElementById('body').innerHTML =''; "><div class="update"></div></a>
 			<div style="clear: both"></div>
 		</div>

 	</div>



 	<div class="vivian"></div>
 	<div class="chatbx" id='chatbx'>Say Hello Vevian</div>

 	<br>

 	<div class="container">
 	<div class="row">

 		<div class="col">
 			<a href="index.php?page=dashboard">
 			<div class="circle">
			<div class="title">Consumption Balance</div>
 				<div class="big-icon"></div>
 				<div class="units" id="device_energy"></div>
 				<div class="bg-footer">From Smart Meters</div>
 			</div>
	 		</a>
 		</div>

 		<div class="col">
 			<a href="index.php?page=dashboard">
 			<div class="circle">
			<div class="title">Production Sale</div>
 				<div class="big-icon"></div>
 				<div class="units" id="meter"></div>
 				<div class="bg-footer">Total Energy</div>
 			</div>
	 		</a>
 		</div>

 		<div class="col">
 			<a href="index.php?page=devices">
 			<div class="circle">
			<div class="title">Devices</div>
 				<div class="big-icon devices-icon"></div>
 				<div class="units" id="devices">
 					<?php echo $db->query("SELECT COUNT(*) AS count FROM device_active WHERE off_time>$time_buffer")->fetchArray()['count']; ?>
 					/
 					<?php echo $db->query("SELECT COUNT(*) AS count FROM device_summary")->fetchArray()['count']; ?></div>
 				<div class="bg-footer">Connected Devices</div>
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
						document.getElementById('chatbx').innerHTML = "Say Hello Vevian";
					}
					if(trigger=='true'){
						console.log('dfdfd');
						$('#greyness').fadeIn();
						document.getElementById('chatbx').innerHTML = "<i>Listening...</i>";
					}
					new_trigger = trigger;
				}

				setTimeout(function(){
					updatePage();
				}, 1000);
			}

        });
	}

	updatePage();
</script>

<?php 

include "cron/cron.php";

$db->close();
unset($db);
 ?>
