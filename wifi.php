
<?php 	


require_once "inc/session.php";
require_once "inc/conn.php";

	$wifi_dongle = $hub_config->wifi_dongle;

	$wifi_text = shell_exec("iwlist $wifi_dongle scan | grep ESSID");

	$wt1 = explode(' ', trim($wifi_text));
	foreach($wt1 as $wt2){
		$wt3 = explode("ESSID:", trim($wt2));
		if (isset($wt3[1])) {
			$wt = $wt3[1];
			$wt = ltrim($wt, '"');
			$wt = rtrim($wt, '"');
			$wifis[] = $wt;
		}
	}


	// $iwconfig = shell_exec("/sbin/iwconfig");


 ?>	

<div class="row">
	<br>
	<h2 style="color: #fff;">Connect to Wifi</h2>

    <div class="col-5">

        <div class="br-20 p-3 gradient-back">



	                <div class="main-card-custom shadow-sm p-3 mt-0">

	                    <div class="row">

				                <div class="form-group">

				                <h6 class="font-weight-bold">Wifi Name</h6>				                	
				            	<select id="ssid" class="form-control">
				            		<?php foreach ($wifis as $w) {?>
				            		<option value="<?php echo $w;?>"><?php echo $w; ?></option>
				            		<?php } ?>
				            	</select>

				                </div>

				                <div class="w-100"></div>

					            <br>

					            <div class="form-group">
					            		
				                <h6 class="font-weight-bold">Password</h6>				                	
				            	<input type="" id="wifi_key" class="form-control" placeholder="Leave blank if empty">

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

    <div class="col-5">
    	<?php // echo file_get_contents("/var/www/wpa_supplicant.conf"); ?>
    </div>
</div>


<!-- end #page div -->
</div>
<!-- end .page-content div -->
</div>


<div class="clearfix"></div>

<script type="text/javascript">
    var postLink = "inc/post.php";

    function submitWifi(){
    	var ssid = $("#ssid").val();
    	var wifi_key = $("#wifi_key").val();

        $.post(postLink, {submitWifi: 1, ssid: ssid, wifi_key: wifi_key}, function(res){
            console.log(res);
        });
    }

</script>
