<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');     

// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Tests;";

$result = $conn->query($sql);

$id=$result->num_rows;

$sql = "INSERT INTO Tests (Id) VALUES
			('$id')";
			
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
