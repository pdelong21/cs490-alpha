<?php
  session_start();
	$Username=$_POST['name'];
	$Password=$_POST['pass'];
  $field=array('Username'=>$Username, 'Password'=>$Password);
  $send=json_encode($field);
  
  $curl=curl_init();
  
  $url="https://web.njit.edu/~sdp53/cs490/login.php";
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => 1,
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POSTFIELDS => $send
  ));
$resp = curl_exec($curl);
$response=json_decode($resp,true);
echo $resp;
?>
