<?php 

require "../inc/conn.php";




if (get('trigger')) {
    $trig = get('trigger');

    if($trig=='true'){
        $db->exec("UPDATE meta_data SET value='true' WHERE meta='trigger'");
    }

    if($trig=='false'){
        $db->exec("UPDATE meta_data SET value='false' WHERE meta='trigger'");
    }

}


if (get('key')) {

	$device=urldecode(get('device'));
	$answer = array("status"=>1, 'response'=>'');
	
	if (get('turn_off')) {
		$db->exec("UPDATE device_summary SET state=0 WHERE device_name='$device'");
	}

	if (get('turn_on')) {
		$db->exec("UPDATE device_summary SET state=1 WHERE device_name='$device'");
	}

	if (get('get_state')) {
	$curr_query = $db->query("SELECT state FROM device_summary WHERE device_name='$device'");
		if ($curr_assoc=$curr_query->fetchArray(SQLITE3_ASSOC)) {
			$curr_state=$curr_assoc['state'];
			if ($curr_state==1) {
				$answer['response'] = "on";
			}else if($curr_state==0){
				$answer['response'] = "off";
			}

		}else{
		
			$answer['status'] = 0;
			$answer['response']=' not available';
		}


	}


	if (get('get_energy')) {

		if (get('period')) {
			$period = get('period');
		}else{
			$period = "today";
		}

		if (get('device')) {

			if (@$device_id=$db->query("SELECT device_id FROM device_summary WHERE device_name='$device'")->fetchArray(SQLITE3_ASSOC)['device_id']) {

				$sql = "SELECT SUM(last_power) FROM device_power_graph WHERE day>'".date('Y-m-d', strtotime($period))."' AND device_id='$device_id'";
				
				$energy = $db->query($sql)->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'];

				$answer['response'] = $energy/100;
				
			}else{
				$answer['status']=0;
				$answer['response']=' not found';
			}

		}else{
			$sql = "SELECT SUM(last_power) FROM device_power_graph WHERE day>'".date('Y-m-d', strtotime($period))."'";

				$energy = $db->query($sql)->fetchArray(SQLITE3_ASSOC)['SUM(last_power)'];

				$answer['response'] = $energy/1000;
		}


	}

	if (get('get_balance')) {
		$answer['status'] = 0;
		// $answer['response'] = " unable to be retrieved right now";
		$answer['response'] = $db->query("SELECT SUM(total_power) FROM meter_summary WHERE meter_type='C'")->fetchArray(SQLITE3_ASSOC)['SUM(total_power)'];
		if($answer['response']=='' or $answer['response']==null){
			$answer['response']="0";
		}
	}


	header('Content-Type: application/json');
	echo json_encode($answer);
	exit();
}





 ?>
