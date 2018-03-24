<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');
$decoder = json_decode($response,true); 

$username=$decoder['Username'];

// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT Tests.Id,TestQuestionRelation.Grade FROM Tests, StudentTestRelation Where Test.Release=1 AND StudentTestRelation.Username='$username' AND Tests.Id=StudentTestRelation.TestId";
$output = array();
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $output[]=array(
          'TestId' =>$row['Id'],
          'Grade' =>$row['Grade']
        );
    }
}
echo json_encode($output,true);
mysqli_close($conn);


?>