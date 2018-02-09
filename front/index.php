<html>
<head>
	<h1>LOGIN</h1>
</head>
<body>
	<form method="post">
    Username:  <input type="text" name="username" /><br />
    Password: <input type="password" name="password" /><br />
    <input type="submit" name="submit" value="Submit" />
  </form>
 
 
 
</body>
</html>


<?php
  session_start();
  $Username=$_POST['username'];
	$Password=$_POST['password'];
#	$url'=https://web.njit.edu/~pgd22/middle/login.php';
  	$field=array('Username'=>$Username, 'Password'=>$Password);
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
$response=json_decode($resp,true);
echo $resp;
?>
