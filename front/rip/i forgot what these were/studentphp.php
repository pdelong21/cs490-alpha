<?php
	session_start();

	#creating cookies for std1
#	$cookie_name="std1";
#	$cookie_value="Student1";
#	setcookie($cookie_name, $cookie_value, time() + 86400);
	
	$Ans=$_POST['ans'];
	$send=$Ans;
	$curl=curl_init();

	$surl="https://web.njit.edu/~pgd22/middle/login.php";

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
