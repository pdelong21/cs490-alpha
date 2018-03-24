<?php
	$response=file_get_contents('php://input');
	#$array = json_decode($_POST['jsondata']);
 #added ", true" on line below
	$dec=json_decode($response,true);
	$enc=json_encode($dec,true);
	$curl=curl_init();
	
#	$url="https://web.njit.edu/~sdp53/cs490/createTest.php";
	$url="https://web.njit.edu/~pgd22/middle/grade.php";
	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_POST => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POSTFIELDS => $enc
	  ));
	$resp = curl_exec($curl);
  #added next two lines
  $res = json_decode($resp,true);
  echo json_encode($res,true);
  #commented out next line
	#echo $resp;
?>
