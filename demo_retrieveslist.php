<?php
/*

Script : Huawei Web Api 
Device : Huawei E5377s-32
WebUi : 17.100.02.00.1056
Source : https://github.com/Anyon3/huaweiwebapi

Demo - Retrieve the sms list

*/

require(__DIR__.'/functions.php');

//Gateway
$device_ip 	 = "192.168.8.1"; 

//Username
$device_username = "admin";

//Password
$device_password = "password";

//Get the verification token
$token = get_token($device_ip);

//Set the session login
$session = login($device_username, $device_password, $device_ip, $token);

	//If the login to the web interface did work
	if($session) {

	  //Retrieve the sms list of Inbox
		$sms = get_sms($device_ip, $session);

		var_dump($sms);
	
	}

	else
		echo "Could not connect to the web interface\n";

?>
