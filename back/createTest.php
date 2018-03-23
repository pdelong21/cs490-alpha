<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');     
$decoder = json_decode($response,true); 

// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT * FROM Tests;";
$result = $conn->query($sql);
$tid=$result->num_rows;

$sql4 = "INSERT INTO Tests (Id,Released) VALUES ($tid,0)";
			$result4 = $conn->query($sql4);
        
			  for ($x = 0; $x < count($decoder); $x++) {
          $sql2 = "SELECT * FROM TestQuestionRelation;";
          $result2 = $conn->query($sql2);
          $id=$result2->num_rows;
          $y=$decoder[$x][0];
          $z=(int)$decoder[$x][1];
          $sql3 = "INSERT INTO TestQuestionRelation (Id, TestId, QuestionId, Points) VALUES($id,$tid,$y,$z)";
          	$result3 = $conn->query($sql3);
}
if ($result3) {
                $log = array(
                                "Response" => "Test Created"
                );
                echo json_encode($log, true);
} else {
                $log = array(
                                "Response" => "Just Quit"
                );
                echo json_encode($log, true);
}
mysqli_close($conn);

?>