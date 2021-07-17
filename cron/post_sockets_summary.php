<?php 


	set_time_limit(30);

	require_once "../inc/conn.php";


	$device_summary_query = $db->query("SELECT * FROM device_summary");
	$device_summary = array();
    while ($y = $device_summary_query->fetchArray(SQLITE3_ASSOC)) {
        $device_summary[] = $y;
    }

    echo '<pre>';
    $index = 0;

    foreach ($device_summary as $d) {
    	$d_id = $d['device_id'];
		$active_time = time() - 60;
		$off_time = $db->query("SELECT off_time FROM device_active WHERE device_id='$d_id'")->fetchArray()['off_time'];
		if ($off_time>$active_time) {
			$device_summary[$index]['current_power'] = $db->query("SELECT last_power FROM device_summary WHERE device_id='$d_id'")->fetchArray()['off_time'];
		}else{
			$device_summary[$index]['current_power'] = 0;
		}

		$total_energy = $device_summary[$index]['total_energy'] =  $db->query("SELECT SUM(last_power) AS total_energy FROM device_power_graph WHERE device_id='$d_id'")->fetchArray()['total_energy'];


		$day_30 = date("Y-m-d", strtotime("30 days ago"));
		$all_energy=$db->query("SELECT * FROM device_power_graph WHERE day>'$day_30' AND device_id='$d_id'");
		$all_energies = array();
		while($x2 = $all_energy->fetchArray(SQLITE3_ASSOC)){
			@$all_energies[$x2['day']]+=$x2['last_power'];
		}

			for($i=0;$i<30;$i++){ 
				$day_index = date("Y-m-d", strtotime("$i days ago")).'';
				if (isset($all_energies[$day_index])) {
					$energies[] = $all_energies[$day_index];
				}else{
					$energies[] = 0;
				}
		}


		$device_summary[$index]['energy_graph']=$energies;
		$energies = array();
		$index++;
    }

    $json = json_encode($device_summary);
    // print_r(json_encode($device_summary, JSON_PRETTY_PRINT));


	$url = $server_url."cron/get_sockets_summary.php?hub_id=".$hub_id;



	$method = "aes128";
	$iv_length = openssl_cipher_iv_length($method);
	$iv = openssl_random_pseudo_bytes($iv_length);
	$iv = '1111111111111111';
	$payload = json_encode(base64_encode( openssl_encrypt($json, $method, $hub_key, 0, $iv) ));

	$options = array(
	  'http' => array(
	    'method'  => 'POST',
	    'content' => $payload,
	    'header'=>  "Content-Type: application/json\r\n" .
	                "Accept: application/json\r\n"
	    )
	);
	$context  = stream_context_create( $options );
	$result = file_get_contents( $url, false, $context );

	print_r($result);


	// $decrypted_message = openssl_decrypt(base64_decode($payload), $method, $hub_key, 0, $iv);
	// print_r($decrypted_message);
 ?>