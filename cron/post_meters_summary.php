<?php 


	set_time_limit(30);

	require_once "../inc/conn.php";


	$meter_summary_query = $db->query("SELECT * FROM meter_summary");
	$meter_summary = array();
    while ($y = $meter_summary_query->fetchArray(SQLITE3_ASSOC)) {
        $meter_summary[] = $y;
    }

    echo '<pre>';
    $index = 0;

    foreach ($meter_summary as $d) {
    	$d_id = $d['meter_id'];


		$day_30 = date("Y-m-d", strtotime("30 days ago"));
		$all_energy=$db->query("SELECT * FROM meter_power_graph WHERE day>'$day_30' AND meter_id='$d_id'");
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


		$meter_summary[$index]['energy_graph']=$energies;
		$energies = array();
		$index++;
    }

    $json = json_encode($meter_summary);
    print_r(json_encode($meter_summary, JSON_PRETTY_PRINT));

	$url = $server_url."cron/get_meters_summary.php?hub_id=".$hub_id;



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