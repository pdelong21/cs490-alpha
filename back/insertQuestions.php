<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');
$decoder = json_decode($response,true); 

$question=$decoder['Question'];
$difficulty=$decoder['Difficulty'];
$points =$decoder['Points'];      
$cases =$decoder['Cases']; 

//echo $question;

// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql1 = mysqli_query($conn,"SELECT max(Id) FROM Questions");
			$row= mysqli_fetch_assoc($sql1);
      $id=$row['max(Id)']+1;
$sql2 = "INSERT INTO Questions (Id, Question, Difficulty, Points, TestCases) VALUES($id,'$question', '$difficulty', $points, '$cases')";
			
			$result2 = $conn->query($sql2);
			  if($result2){
				  $log = array("Response"=>"Successfully Inserted");
				  echo json_encode($log,true);
        }
        else{
          $log = array("Response"=>$sql2);
				  echo json_encode($log,true);
        }
mysqli_close($conn);

?>
