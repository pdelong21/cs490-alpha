<?php
	session_start();

  	$Question=$_POST['qtn'];
	$Case=$_POST['ans'];
	$strPoints=$_POST['pts'];
	$Points=intval(strPoints);
	$Difficulty=$_POST['diff'];

  	$field=array('Question'=>$Question, 'Difficulty'=>$Difficulty, 'Points'=>$Points, 'Cases'=>$Case);
#	$field=array('Question'=>"Testing", 'Difficulty'=>"Hard",'Points'=>20, 'Cases'=>"Ans");

	#checking var types
	var_dump($Question);
	var_dump($Difficulty);
	var_dump($strPoints);
	var_dump($Points);
	var_dump($Case);
	var_dump($field);

  	$send=json_encode($field); 	
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
echo $resp;

echo $Question;
echo $Difficulty;
echo $strPoints;
echo $case;

?>

