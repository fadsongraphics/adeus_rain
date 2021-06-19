<?php

 //$db=new SQLite3('C:/xampp/htdocs/inc/adeus.db');
$db=new SQLite3('/var/www/html/inc/adeus.db');

$db->exec("CREATE TABLE IF NOT EXISTS `device_active` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `device_id` TEXT NOT NULL,
  `on_time` int(11) NOT NULL,
  `off_time` int(11) NOT NULL
)");


$db->exec("CREATE TABLE IF NOT EXISTS `device_power_history` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `day` date NOT NULL,
  `last_power` TEXT DEFAULT '0',
  `device_id` TEXT NOT NULL,
  `24hr_log` TEXT DEFAULT NULL
)");

$db->exec("CREATE TABLE IF NOT EXISTS `meter_power_history` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `day` date NOT NULL,
  `last_power` TEXT DEFAULT '0',
  `24hr_log` TEXT DEFAULT NULL
)");


$db->exec("CREATE TABLE IF NOT EXISTS `device_summary` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `device_id` TEXT UNIQUE NOT NULL,
  `device_name` TEXT DEFAULT NULL,
  `registered_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `power` TEXT DEFAULT '0',
  `total_price` TEXT DEFAULT '0',
  `state` TEXT NOT NULL DEFAULT '0'
)");




$db->exec("CREATE TABLE IF NOT EXISTS  `meta_data` (
  `meta` text NOT NULL,
  `value` text NOT NULL
)");


//$db->exec("INSERT INTO contacts (first_name) VALUES ('rwew32224')");

// $res = $db->query("SELECT * FROM device_power_history");

// while ($x=$res->fetchArray(SQLITE3_ASSOC)){
//   print_r($x);
// }



?>
