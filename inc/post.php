<?php

require_once "conn.php";

	$time = time();
	$active_time = $time - 60;

if ($update_page=post('update_page')) {
	$return = array();

	if($update_page=='dongle_view'){
		
		$time_view = date('h:i')." <span style='font-weight:lighter'>".date("A")."</span>";
		$trigger = $db->query("SELECT value FROM meta_data WHERE meta='trigger'")->fetchArray(SQLITE3_ASSOC)['value'];

		$total_energy_consumed = energy_format(($db->query("SELECT SUM(last_power) FROM device_power_graph"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2);

		$meter_power = energy_format(($db->query("SELECT SUM(total_power) FROM meter_summary WHERE meter_type='C'"))->fetchArray(SQLITE3_ASSOC)['SUM(total_power)'], 2);

		$devices = $db->query("SELECT COUNT(*) AS count FROM device_active WHERE off_time>$active_time")->fetchArray()['count'].'/'.$db->query("SELECT COUNT(*) AS count FROM device_summary")->fetchArray()['count'];

		if(@$nlp_q = file_get_contents("/var/www/html/python/nlp_q.txt")){
			$nlp_r = file_get_contents("/var/www/html/python/nlp_r.txt");


			$return = array(
				"trigger"=>$trigger,
				"nlp_q"=>$nlp_q,
				"nlp_r"=>$nlp_r,
				"device_energy"=>$total_energy_consumed,
				"meter"=>$meter_power,
				"devices"=>$devices,
				"time"=> $time_view
			);

		}else{
			$return = array(
				"trigger"=>'false',
				"nlp_q"=>'',
				"nlp_r"=>'',
				"device_energy"=>$total_energy_consumed,
				"meter"=>$meter_power,
				"devices"=>$devices,
				"time"=> $time_view,
			);
		}
	}

	elseif($update_page=='dashboard'){

		$energy_period = softSan(post('energy_period'));
		$where =  "day>'".date('Y-m-d', strtotime($energy_period))."'";

		$devices_q = $db->query("SELECT device_id, state FROM device_summary ");
		$device=array();
		while($x = $devices_q->fetchArray(SQLITE3_ASSOC)){
			$device[]=$x;
		}

		$return = array(
			"dashboardTime"=>date("h:i").'<small>'.date("A").'</small>',
			"dashboardDate"=>date("l d M, Y"),
			"dashboardTEC"=>energy_format(($db->query("SELECT SUM(last_power) FROM meter_power_graph WHERE meter_type='C' AND $where"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2),

			"dashboardTEG"=>energy_format(($db->query("SELECT SUM(last_power) FROM meter_power_graph WHERE meter_type='G' AND $where"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2),
			
			"dashboardSM"=>energy_format(($db->query("SELECT SUM(last_power) FROM device_power_graph WHERE $where"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2),

			"devices"=>$device
		);
	}

	elseif($update_page=='devices'){

		$devices_q = $db->query("SELECT device_id, state FROM device_summary ");
		$device=array();
		while($x = $devices_q->fetchArray(SQLITE3_ASSOC)){
			$device[]=$x;
		}

		$return = array(
			
			"devicesSM"=>energy_format(($db->query("SELECT SUM(last_power) FROM device_power_graph"))->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'], 2),
			
			"devices"=>$device
		);
	}

	echo json_encode($return);
}


if (post('tts')) {

		$trigger = $db->query("SELECT value FROM meta_data WHERE meta='trigger'")->fetchArray(SQLITE3_ASSOC)['value'];

		if(@$nlp_q = file_get_contents("/var/www/html/python/nlp_q.txt")){
			$nlp_r = file_get_contents("/var/www/html/python/nlp_r.txt");


			$return = array(
				"trigger"=>$trigger,
				"nlp_q"=>$nlp_q,
				"nlp_r"=>$nlp_r,
			);

		}else{
			$return = array(
				"trigger"=>'false',
				"nlp_q"=>'',
				"nlp_r"=>'',
			);
		}

	echo json_encode($return);
}




if (post('add_device')) {
	$add_device_id = $_POST['socket_id'];
	$device_name = $_POST['device_name'];



	if($add_device_sql = $db->exec("UPDATE device_summary SET device_name='$device_name' WHERE device_id='$add_device_id'")){
			echo "DEVICE ADDED <br>";



	$devices = array();
	$devices_sql = $db->query("SELECT device_name FROM device_summary");
	while ($x = $devices_sql->fetchArray(SQLITE3_ASSOC)) {
		if ($x['device_name']!==null) {
			$devices[]=$x['device_name'];
		}
	}

	file_put_contents("/var/www/html/nlp/devices.txt", json_encode($devices));

		}
	// header("Location: index.php");
	// exit();

}





if (post('toggle_state')) {
	$device_id = post('toggle_state');
	$curr_state = $db->query("SELECT state FROM device_summary WHERE device_id='$device_id'")->fetchArray(SQLITE3_ASSOC)['state'];

	if ($curr_state==1) {
		$db->exec("UPDATE device_summary SET state=0 WHERE device_id='$device_id'");
	}else{
		$db->exec("UPDATE device_summary SET state=1 WHERE device_id='$device_id'");
	}

	echo "toggled";

}


if(post('energy_graph')){
	$time_r = post('energy_graph');
	$where='';

	if ($time_r=='yesterday') {
		$where = " WHERE day>'".date('Y-m-d', strtotime("yesterday"))."'";
	}

	if ($time_r=='3_days') {
		$where = " WHERE day>'".date('Y-m-d', strtotime("3 days ago"))."'";
	}

	if ($time_r=='last_week') {
		$where = " WHERE day>'".date('Y-m-d', strtotime("last week"))."'";
	}

	if ($time_r=='last_month') {
		$where = " WHERE day>'".date('Y-m-d', strtotime("last month"))."'";
	}


	$sql = "SELECT SUM(last_power) FROM device_power_graph".$where;

	$energy = energy_format($db->query($sql)->fetchArray(SQLITE3_ASSOC)['SUM(last_power)']);

	?>
	<script type="text/javascript">$("#energy_consumed_card").html("<?php echo $energy;?>");</script>
	<?php



}



if(post('device_graph')){
	$id = post('device_graph');

	if (check_device_id($id)) {

	$time = time();
	$hours = 12;


	$upper_limit = ceil($hours/24);
	$lower_limit_day = date('d')-$upper_limit;
	$lower_limit_text = date('Y-m-').$lower_limit_day;



	$dev_summ = $db->query("SELECT * FROM device_summary WHERE device_id='$id'")->fetchArray(SQLITE3_ASSOC);

	$dev_pow_q =  $db->query("SELECT * FROM device_power_graph WHERE device_id='$id' AND day>'$lower_limit_text' ORDER BY day DESC");
	$dev_pow=array();

	$graph = array();

	while ($x = $dev_pow_q->fetchArray(SQLITE3_ASSOC)) {
		$dev_pow[] = $x;
		$hours_temp = unserialize($x['24hr_log']);
		for ($j=0; $j < 24; $j++) { 
			if (!isset($hours_temp[$j])) {
				$hours_temp[$j]=0;
			}
			$graph[date("j M", strtotime($x['day'])).' '.$j.':00'] = $hours_temp[$j];
		}
	}
	?>
		<h1><?php echo $dev_summ['device_name'];?></h1>
		<h5>Socket ID: <?php echo $dev_summ['device_id']; ?></h5>

		Registered: <?php echo date('Y/m/d h:i a', strtotime($dev_summ['registered_time'])); ?>




		<?php

		$active_q = $db->query("SELECT on_time, off_time FROM device_active WHERE device_id='$id'");
		$active_total = 0;

		if( ($currently = $active_q->fetchArray(SQLITE3_ASSOC)) !==''){
			$last_on = $currently['off_time'];
			$last_off = $currently['on_time'];

			$active_total = $last_on - $last_off;
		}

		while ($x=$active_q->fetchArray(SQLITE3_ASSOC)) {
			$active_total += ($x['off_time'] - $x['on_time']); 
		}
		?>

		<br>
		Last Seen <?php echo $time - $last_on; ?> seconds ago

		<br>
		Active for <?php echo $last_on - $last_off; ?> seconds

		<br>
		<br>

		Total On duration :<?php echo $active_total; ?> seconds





		<h4><?php echo $hours; ?> hour usage (graph)</h4>

		<?php 

		// print_r($graph);

		for ($i=0; $i < $hours; $i++) { 
			$new_time = $time - (3600*$i);
			
			if((@$val =$graph[date("j M G:00", $new_time)])==''){
				$val = 0;
			}

			echo date('G A', $new_time).' - '.$val;
			echo '<br>';
		}


		?>
		<br>
		<br>
		<br>

		<button disabled class="btn btn-sm btn-danger"><i class="bx bx-trash"></i> DELETE </button>
		<?php




	}else{
		die('Device not found');
	}

}
 ?>
