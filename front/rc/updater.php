<?php
	session_start();

  $response=file_get_contents('php://input');
  $dec=json_decode($response,true);

  	$send=json_encode($dec, true); 	
  	$curl=curl_init();
  	
#	temp url
 	$url="https://web.njit.edu/~sdp53/cs490/updateGrade.php";
#	actual URL
#	$url="https://web.njit.edu/~pgd22/middle/insertQuestions.php";  
  	curl_setopt_array($curl, array(
    	 CURLOPT_URL => $url,
    	 CURLOPT_POST => 1,
    	 CURLOPT_FOLLOWLOCATION => 1,
    	 CURLOPT_RETURNTRANSFER => 1,
    	 CURLOPT_POSTFIELDS => $send
  	));
$resp = curl_exec($curl);
$res=json_decode($resp,true);
#echo json_encode($res,true);
echo $resp;
?>

