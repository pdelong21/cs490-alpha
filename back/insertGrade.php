<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');
$decoder = json_decode($response,true); 

$username=$decoder['Username'];
$grade=$decoder['Grade'];
$question=$decoder['Question'];
// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql ="SELECT * FROM Tests";
			$result = $conn->query($sql);
$testId=$result->num_rows-1;

$sql1 ="SELECT * FROM StudentTestRelation";
			$result1 = $conn->query($sql1);
$id=$result1->num_rows;

$sql2 = "INSERT INTO StudentTestRelation (Id, Username, Grade, TestId) VALUES($id,'$username', $grade, $testId)";
			
			$result2 = $conn->query($sql2);
      
      
      
      for ($x = 0; $x < count($decoder); $x++) {
          $sql3 ="SELECT * FROM QuestionStudentRelation";
			    $result3 = $conn->query($sql3);
          $id2=$result3->num_rows;
          $userAnswer=$question[$x]['Response'];
          $points=$question[$x]['Points'];
          $feedback=$question[$x]['Feedback'];
          $sql4 = "INSERT INTO QuestionStudentRelation (Id, UserAnswer, Feedback, Points,TestId) VALUES($id2,'$userAnswer', '$feedback', $points, $testId)";
			
			$result4 = $conn->query($sql4);
}
      
      if ($result3) {
                $log = array(
                                "Response" => "Submitted"
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