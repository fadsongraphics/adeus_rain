<?php   


ob_start();
session_start(); 


function redirectd($e='login.php'){
	header("Location:".$e);
	exit();
}

// if (isset($_SESSION['user_id']) and !empty($_SESSION['user_id'])) {
// 	return true;
// }else{

// 	if($user_json = json_decode(file_get_contents("user_info.json"))){
// 		if (isset($user_json->email)) {
// 			$_SESSION['user_id'] = $user_json->email;
// 		}else{redirectd();}
// 	}else{redirectd('register.php');}

// }


?>