<?php
	
#	$send=array();
	$send=array('Id'=>1);
#	$response=file_get_contents('php://input');
#	$jDec=json_decode($response,true);
#	$jEnc=json_encode($jDec,true);
	$curl=curl_init();

	$url="https://web.njit.edu/~sdp53/cs490/createTest.php";
#	$url="https://web.njit.edu/~pgd22/middle/createTest.php";

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POSTFIELDS => $send
	  ));
	$resp = curl_exec($curl);
	echo $resp;
?>
