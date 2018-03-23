<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');
$decoder = json_decode($response,true); 
$username= $decoder['Username'];
$userPass =$decoder['Password'];     

// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Users WHERE Username='$username'";

$result = $conn->query($sql);

if ($result->num_rows == 1) {
    
    $row = mysqli_fetch_assoc($result);
    
    //hash verify
    if (password_verify($userPass, $row["Password"])) {
         $log = array("Response"=>$row["Permission"]);
        
        echo json_encode($log,true);           
    } else {
         $log = array("Response"=>"INVALID");
        
        echo json_encode($log,true);           
    } 
} else {
        $log = array("Response"=>"INVALID");
        
        echo json_encode($log,true);           
    } 
    
mysqli_close($conn);

?>