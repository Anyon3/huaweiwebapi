<?php

/*
Script : Huawei Web Api 
Device : Huawei E5377s-32
WebUi : 17.100.02.00.1056
Source : https://github.com/Anyon3/huaweiwebapi

*/

		//Return the connection token
		function get_token($ip) {

			$xml = file_get_contents("http://$ip/api/webserver/token");
			$token = simplexml_load_string($xml);

			return $token->token->__toString();

		}


		//Login to the web interface 
		function login($username, $password, $ip, $token) {

				//Post data
				$data = '<?xml version="1.0" encoding="UTF-8"?><request><Username>'.$username.'</Username><Password>'.base64_encode($password).'</Password></request>';

				$curl = curl_init();
			
								curl_setopt($curl, CURLOPT_HTTPHEADER, ['Host: '.$ip,
																												'User-Agent: proot',
																												'Accept: */*',
																												'Accept-Language: en-us,en;q=0.5',
        																								'Accept-Encoding: gzip, deflate',
																												'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
																												'__RequestVerificationToken: '.$token,
																												'X-Requested-With: XMLHttpRequest']);	
           		  curl_setopt($curl, CURLOPT_URL, "http://$ip/api/user/login");
								curl_setopt($curl, CURLOPT_POST, 1);
								curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					 		  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

				 $response = curl_exec($curl);
										 curl_close($curl);
				 $result = simplexml_load_string($response);
		
				 if($result->__toString() === 'OK')

					return $token;

				else

					return false;
			
		}

		//Get the list of SMS (Inbox)
		function get_sms($ip, $token) {

				//Post data 
				$data = '<?xml version="1.0" encoding="UTF-8"?><request><PageIndex>1</PageIndex><ReadCount>20</ReadCount><BoxType>1</BoxType><SortType>0</SortType><Ascending>0</Ascending><UnreadPreferred>0</UnreadPreferred></request>';

				$curl = curl_init();
								curl_setopt($curl, CURLOPT_HTTPHEADER, ['Host: '.$ip,
																											'User-Agent: proot',
																											'Accept: */*',
																											'Accept-Language: en-us,en;q=0.5',
        																							'Accept-Encoding: gzip, deflate',
																											'Referer: http://'.$ip.'/html/smsinbox.html',
																											'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
																											'__RequestVerificationToken: '.$token,
																											'X-Requested-With: XMLHttpRequest']);
			 			 	 curl_setopt($curl, CURLOPT_URL, "http://$ip/api/sms/sms-list");
							 curl_setopt($curl, CURLOPT_POST, 1);
							 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
							 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
				$response = curl_exec($curl);
										curl_close($curl);
			
				$result = simplexml_load_string($response);

				return $result;
			
		}

		//Delete all SMS (Inbox)		
		function rmsms($ip, $token, $rmxml) {

				$data = (string)$rmxml;				 

				$curl = curl_init();
								curl_setopt($curl, CURLOPT_HTTPHEADER, ['Host: '.$ip,
																											'User-Agent: proot',
																											'Accept: */*',
																											'Accept-Language: en-us,en;q=0.5',
        																							'Accept-Encoding: gzip, deflate',
																											'Referer: http://'.$ip.'/html/smsinbox.html',
																											'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
																											'__RequestVerificationToken: '.$token,
																											'X-Requested-With: XMLHttpRequest']);			
			 			 	 curl_setopt($curl, CURLOPT_URL, "http://$ip/api/sms/delete-sms");
							 curl_setopt($curl, CURLOPT_POST, 1);
							 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
							 curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
				$response = curl_exec($curl);
				$result = simplexml_load_string($response);

				return $result;
		}

?>
