<?php
$dbserver = "sql1.njit.edu";
$user     = "sdp53";
$password = "oEnFrxKN";
$database = "sdp53";
$conn     = mysqli_connect($dbserver, $user, $password, $database);
if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
}
$response   = file_get_contents('php://input');
$decoder    = json_decode($response, true);

 for ($x = 0; $x < count($decoder); $x++) {
          $id=(int)$decoder[$x]['Id'];
          $feedback=$decoder[$x]['Feedback'];
          $points=(int)$decoder[$x]['Points'];
          $sql = "UPDATE QuestionStudentRelation SET Feedback='$feedback', Points='$points' WHERE Id=$id";
			
			$result = $conn->query($sql);
}

if ($result) {
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