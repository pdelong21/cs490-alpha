<?php
	session_start();
  	$Question=$_POST['qtn'];
	$Case=$_POST['ans'];
	$Points=$_POST['pts'];
	$Difficulty=$_POST['diff'];
  	$field=array('Question'=>$Question, 'Difficulty'=>$Difficulty, 'Points'=>$Points, 'Cases'=>$Case);
  	$send=json_encode($field); 	
  	$curl=curl_init();
  	
#	temp url
 	$url="https://web.njit.edu/~sdp53/cs490/login.php";
#	actual URL
#	$url="https://web.njit.edu/~pgd22/middle/login.php";  
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

