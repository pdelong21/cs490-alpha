<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');
$decoder = json_decode($response,true); 

$question=$decoder['Question'];
$category =$decoder['Category'];
$difficulty=$decoder['Difficulty'];
$points =$decoder['Points'];      
$cases =$decoder['Cases']; 


// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO Questions (Question, Category, Difficulty, Points, Cases) VALUES
			('$question', '$category', '$difficulty', '$points', '$cases')";
			
			$result = $conn->query($sql);
			
			  if($result){
				  $log = array("Response"=>"Successfully Inserted");
				  echo json_encode($log,true);
        }
        else{
          $log = array("Response"=>"INVALID");
				  echo json_encode($log,true);
        }
mysqli_close($conn);

?>
