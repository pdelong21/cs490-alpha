<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53"; 

// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM Tests";

$result = $conn->query($sql);
$id=$result->num_rows-1;

$sql2 = "UPDATE Tests SET Release = 1 WHERE Id= '$id'";

$result2 = $conn->query($sql2);

if($result2){
  $log = array("Response"=>"Released");
  echo json_encode($log,true);
}else{
  $log = array("Response"=>"Not Released");

  echo json_encode($log,true);
  }
mysqli_close($conn);

?>
