<?php
$dbserver   = "sql1.njit.edu";
$user       = "sdp53";
$password   = "oEnFrxKN";
$database   = "sdp53";
$response   = file_get_contents('php://input');
$decoder    = json_decode($response, true);
$question   = $decoder['Question'];
$difficulty = $decoder['Difficulty'];
$cases      = array();
$cases      = $decoder['Cases'];
$signature  = $decoder['Signature'];
$conn       = mysqli_connect($dbserver, $user, $password, $database);
if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
}
$sql1    = "SELECT * FROM Questions";
$result1 = $conn->query($sql1);
$id      = $result1->num_rows;
$sql2    = "INSERT INTO Questions (Id, Question, Difficulty,Signature) VALUES($id,'$question', '$difficulty','$signature')";
$result2 = $conn->query($sql2);
$c       = count($cases);
for ($x = 0; $x < $c; $x++) {
                $sql3    = "SELECT * FROM TestCases";
                $result3 = $conn->query($sql3);
                $tId     = $result3->num_rows;
                $caseT   = $cases[$x][0];
                $caseA   = $cases[$x][1];
                $sql4    = "INSERT INTO TestCases (Id, QuestionId, Testcase, Answer) VALUES($tId,$id,'$caseA','$caseT')";
                $result4 = $conn->query($sql4);
}
if ($result4) {
                $log = array(
                                "Response" => "Successfully Inserted"
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
