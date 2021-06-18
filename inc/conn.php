<?php

date_default_timezone_set("Africa/Lagos");

error_reporting(E_ALL);
ini_set('display_errors', '1');


// if (@file_get_contents("../../pi")) {
// 	$conn = new mysqli('localhost', 'admin', 'your_password', 'adeus_dongle');
// }else{
// 	$conn = new mysqli('localhost', 'root', '', 'adeus');
// }

require_once "db.php";

$source = 'grid';


function post($str, $null=false){
	if (isset($_POST[$str]) and !empty($_POST[$str])) {
		return $_POST[$str];
	}elseif ($null==true) {
		return '';
	}else{
		return false;
	}
}

function get($str, $null=false){
	if (isset($_GET[$str]) and !empty($_GET[$str])) {
		return $_GET[$str];
	}elseif ($null==true) {
		return '';
	}else{
		return false;
	}
}

// TO DO!!!!!!!!!!!!!!!
function check_device_id($e){
	return true;
}


function checkpost($e){
		$ret = true;
    // print_r($e);
	foreach ($e as $a) {
		if (!post($a)){
			$ret = false;
			// echo $a;
		}
	}	
		return $ret;
 }

 

function softSan($str){
	global $conn;
	$str = SQLite3::escapeString($str);
	return filter_var($str, FILTER_SANITIZE_STRING);
	return $str;
}

function energy_format($e, $b=2, $showUnit=true){
	if ($showUnit==true) {
		if($e<1000){
			$txt = number_format($e, $b)."Wh";
		}elseif($e<1000000){
			$txt = number_format($e/1000, $b)."kWh";
		}else{
			$txt = number_format($e/1000000, $b)."mWh";
		}
	}
	return $txt;
}



$styles = array(
	'cooker'=>array('bg' => 'background-color: #abffb3; color: white; ', 'color'=>'color: #02BC47;', 'icon'=>'water-pump-g.svg'),
	'freezer'=>array('bg' => 'background-color: #0055FF; color: white;', 'color'=>'color: #fff;', 'icon'=>'air-conditioner-w.svg'),
	'water heater'=>array('bg' => 'background-color: #EDCBF9; color: white;', 'color'=>'color: #a653c9;;', 'icon'=>'cooker-p.svg'),
	'lights'=>array('bg' => 'background-color: #fff2ab; color: white;', 'color'=>'color: #FFAF47;', 'icon'=>'tg2.svg'),
	'disabled'=>array('bg' => 'background-color: #D9D8DD; color: white;', 'color'=>'color: #333;', 'icon'=>''),
)



?>