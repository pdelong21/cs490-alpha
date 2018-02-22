<?php
	session_start();
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
