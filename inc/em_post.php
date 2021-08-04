<?php 
require_once "conn.php";


if(get('get_meter_total')){
	$meter_id = get('get_meter_total').'_energy_total';
	$gmt = $db->query("SELECT value FROM meta_data WHERE meta='$meter_id'");
	if ($value = $gmt->fetchArray(SQLITE3_ASSOC)) {
		echo $value['value'];
	}else{
		$gmt = $db->query("INSERT INTO meta_data(meta, value) VALUES ('$meter_id', 1000)");
		echo 0;
	}
}


if(get('meter_id')){

	$meter_id = softSan(get('meter_id'));
	$meter_type = softSan(get('type'));
	$total_power = softSan(get('total_power'));
	$current_power = softSan(get('current_power'));
	$total_energy = softSan(get('total_energy'));


	$meter = $db->query("SELECT * FROM meter_summary WHERE meter_id='$meter_id'")->fetchArray(SQLITE3_ASSOC);
	if ($meter=='') {
		$db->exec("INSERT INTO meter_summary (meter_id, meter_type, total_power, current_power, total_energy, last_updated) VALUES ('$meter_id', '$meter_type', '$total_power', '$current_power', '$total_energy', CURRENT_TIMESTAMP)");
	}else{
		$db->exec("UPDATE meter_summary SET total_power='$total_power', current_power='$current_power', total_energy='$total_energy', last_updated=CURRENT_TIMESTAMP WHERE meter_id='$meter_id'");
	}
	

		$check_graph_date = date("Y-m-d");
		$curr_hour = date('H');

		$last_power_q = $db->query("SELECT day, `24hr_log` FROM meter_power_graph WHERE meter_id='$meter_id' ORDER BY day DESC LIMIT 0,1");
		
		$last_power = $last_power_q->fetchArray(SQLITE3_ASSOC);

		if (@$last_power['day']!==$check_graph_date or $last_power=='') {
			$summ_array = array($curr_hour=>$current_power);
			$ser_summ_array = serialize($summ_array);
			$db->exec("INSERT INTO meter_power_graph(meter_id, meter_type day, `24hr_log`, last_power) VALUES ('$meter_id', '$meter_type', '$check_graph_date', '$ser_summ_array', '$current_power')");
		}else{

			if ($last_power['day']==$check_graph_date) {
				$summ_array = unserialize($last_power['24hr_log']);
				@$summ_array[$curr_hour]+=$current_power;
			}else{
				$summ_array = array($curr_hour=>$current_power);
			}

			$ser_summ_array = serialize($summ_array);

			$db->exec("UPDATE meter_power_graph SET `24hr_log`='$ser_summ_array', last_power=last_power+$current_power WHERE day='$check_graph_date' AND meter_id='$meter_id'");


			}

}





// %%%%%%%%%%%%%%%%%%%%%%



if (get('action')) {
	$action=get('action');
	$id = softSan(strtoupper(get('board')));



// REGISTER UNKNOWN BOARD
@$db->exec("INSERT INTO device_summary(device_id, device_name, last_change) VALUES ('$id', 'unknown', CURRENT_TIMESTAMP)");


	if (!isset($_GET['type'])) {
		$type='C';
	}else{
		$type = strtoupper(get('type'));
	}


	if($action=='update'){
		$power = get('power');
		$last_power = get('last_power', true);

		$power_query = $db->query("SELECT COUNT(*) as count FROM device_summary WHERE device_id='$id'");

		if($power_query->fetchArray(SQLITE3_ASSOC)['count']==1){
		$total_power = $db->query("SELECT total_power FROM device_summary WHERE device_id='$id'")->fetchArray(SQLITE3_ASSOC)['total_power'];

		if ($power>$total_power) {
			$sql = $db->exec("UPDATE device_summary SET total_power='$power', last_change=CURRENT_TIMESTAMP WHERE device_id='$id'");
		}

		$check_graph_date = date("Y-m-d");
		$curr_hour = date('H');

		$last_power_q = $db->query("SELECT last_power, day, `24hr_log` FROM device_power_graph WHERE device_id='$id' ORDER BY day DESC LIMIT 0,1");
		if ($last_power = $last_power_q->fetchArray(SQLITE3_ASSOC)) {
			$power_diff = $power - $total_power;
			if ($power_diff<0) {
				$power_diff=0;
			}
		}else{
			$power_diff = $power;
		}

		if ($last_power['day']!==$check_graph_date) {
			$summ_array = array($curr_hour=>$power_diff);
			$ser_summ_array = serialize($summ_array);
			$db->exec("INSERT INTO device_power_graph(day, last_power, device_id, `24hr_log`) VALUES ('$check_graph_date','$power_diff', '$id', '$ser_summ_array')");
		}else{

			if ($last_power['day']==$check_graph_date) {
				$summ_array = unserialize($last_power['24hr_log']);
				@$summ_array[$curr_hour]+=$power_diff;
			}else{
				$summ_array = array($curr_hour=>$power_diff);
			}

			$ser_summ_array = serialize($summ_array);

			$db->exec("UPDATE device_power_graph SET last_power=last_power+$power_diff, `24hr_log`='$ser_summ_array' WHERE day='$check_graph_date' AND device_id='$id'");


			}
		}else{
			die("Not registered!");
		}
	}


	if ($action=='get_state') {

			$state = $db->query("SELECT state FROM device_summary WHERE device_id='$id'")->fetchArray(SQLITE3_ASSOC)['state'];
			echo json_encode(array(2=>"$state"));
	}



$off_query = $db->query("SELECT COUNT(*) as count FROM device_active WHERE device_id='$id' AND off_time>$time_buffer");
if ($off_query->fetchArray(SQLITE3_ASSOC)['count']==0) {
	$db->exec("INSERT INTO device_active(device_id, on_time, off_time) VALUES ('$id', '$time', '$time')");
}else{
	$off_id = $db->query("SELECT id FROM device_active WHERE device_id='$id' AND off_time>$time_buffer")->fetchArray(SQLITE3_ASSOC)['id'];
	$db->exec("UPDATE device_active SET off_time='$time' WHERE id='$off_id'");
}




}

$db->close();
unset($db);