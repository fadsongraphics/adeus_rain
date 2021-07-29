
<?php 	


require_once "inc/session.php";
require_once "inc/conn.php";

	$wifi_dongle = $hub_config->wifi_dongle;

	$wifis = shell_exec("sudo iwlist $wifi_dongle scan | grep ESSID");

	$iwconfig = shell_exec("/sbin/iwconfig");


 ?>

<div class="row">
	<br>
	<h2>Connect to Wifi</h2>

    <div class="col-5">

        <div class="glass br-20 p-3">



	                <div class="main-card-custom shadow-sm p-3 mt-0">

	                    <div class="row">
wifis : <br>
<?php 	print_r($wifis);?>
<br>
iwconfig : <br>
<?php 	print_r($iwconfig);?>
				                <div class="form-group">

				                <h6 class="font-weight-bold">Wifi Name</h6>				                	
				            	<select class="form-control">
				            		<option value="a">a</option>
				            	</select>

				                </div>

				                <div class="w-100"></div>

					            <br>

					            <div class="form-group">
					            		
				                <h6 class="font-weight-bold">Password</h6>				                	
				            	<input type="" class="form-control" placeholder="Leave Empty if blank">

					            </div>

				                <div class="w-100"></div>


					            <br>
					            <br>

					            <button onclick="submitWifi()" class="btn btn-primary">CONNECT</button>

					            <br>
					            <br>
	                    </div>

	                </div>

        </div>

    </div>

</div>


<!-- end #page div -->
</div>
<!-- end .page-content div -->
</div>


<div class="clearfix"></div>
