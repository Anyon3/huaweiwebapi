<?php
/*

Script : Huawei Web Api 
Device : Huawei E5377s-32
WebUi : 17.100.02.00.1056
Source : https://github.com/Anyon3/huaweiwebapi

Demo - Delete the sms list (Inbox)

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

		//Delete all SMS
		$xmlbody = '<?xml version="1.0" encoding="UTF-8"?><request></request>';

		//Create the xml element
		$rmxml = new SimpleXMLElement($xmlbody);
		
		//Set the Index of each sms					
		foreach ($sms->Messages->Message as $msg) {
			
			$rmxml->addChild('Index', $msg->Index);
	
		}

			//Remove any new line 
			$idx = trim(preg_replace('/\s+/', ' ', $rmxml->asXML()));

			$response = rmsms($device_ip, $session, $idx);
			
			if($response->__toString() === 'OK')

				echo "Success\n";

			else
	
				echo "Failed\n";	
	}

	else
		echo "Could not connect to the web interface\n";

?>
