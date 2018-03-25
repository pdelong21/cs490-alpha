<?php
	session_start();

#  $Question=$_POST['pqtn'];
#	$Case=$_POST['pans'];
#	$strPoints=$_POST['ppts'];
#	$Points=intval(strPoints);
#	$Difficulty=$_POST['pdiff'];

# 	$field=array('Question'=>$Question, 'Difficulty'=>$Difficulty, 'Points'=>$Points, 'Cases'=>$Case);
#	$field=array('Question'=>"test question", 'Difficulty'=>"Hard",'Points'=>20, 'Cases'=>"Please Ignore");

	#checking var types
#	var_dump($Question);
#	var_dump($Difficulty);
#	var_dump($strPoints);
#	var_dump($Points);
#	var_dump($Case);
#	var_dump($field);

  $response=file_get_contents('php://input');
  $dec=json_decode($response,true);

  	$send=json_encode($dec, true); 	
  	$curl=curl_init();
  	
#	temp url
# 	$url="https://web.njit.edu/~sdp53/cs490/insertQuestions.php";
#	actual URL
	$url="https://web.njit.edu/~pgd22/middle/insertQuestions.php";  
  	curl_setopt_array($curl, array(
    	 CURLOPT_URL => $url,
    	 CURLOPT_POST => 1,
    	 CURLOPT_FOLLOWLOCATION => 1,
    	 CURLOPT_RETURNTRANSFER => 1,
    	 CURLOPT_POSTFIELDS => $send
  	));
$resp = curl_exec($curl);
$res=json_decode($resp,true);
echo json_encode($res,true);
#echo $resp;

#echo $Question;
#echo $Difficulty;
#echo $strPoints;
#echo $case;

?>

