<?php 
	require_once "../inc/conn.php";

	$energy_generated = $db->query("SELECT SUM(last_power) FROM meter_power_graph WHERE meter='O'")->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'];
	$energy_consumed = $db->query("SELECT SUM(last_power) FROM meter_power_graph WHERE meter='I'")->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'];

	$gen_O = $db->query("SELECT last_power, last_update FROM meter_power_graph WHERE meter='O' ORDER BY day DESC LIMIT 0,1")->fetchArray(SQLITE3_ASSOC);
	$power_gen = $gen_O['last_power'];
	$last_meter_update_gen = $gen_O['last_update'];


	$gen_I = $db->query("SELECT last_power, last_update FROM meter_power_graph WHERE meter='I' ORDER BY day DESC LIMIT 0,1")->fetchArray(SQLITE3_ASSOC);
	$power_con = $gen_I['last_power'];
	$last_meter_update_con = $gen_I['last_update'];

	$data_array = array(
		"randomizer"=>rand(9,9999),
		"hub_id"=>"hub1",
		"energy_generated"=> $energy_generated,
		"energy_consumed"=> $energy_consumed,
		"power_gen"=>$power_gen,
		"power_con"=>$power_con,
		"last_meter_update_gen"=>$last_meter_update_gen,
		"last_meter_update_con"=>$last_meter_update_con,
	);

	$data_serial = json_encode($data_array);


	$method = "aes128";
	$iv_length = openssl_cipher_iv_length($method);
	$iv = openssl_random_pseudo_bytes($iv_length);
	$data_enc = openssl_encrypt($data_serial, $method, "secret_key", 0, $iv);


	file_get_contents($server_url."api.php/?data=$date_enc");

 ?>