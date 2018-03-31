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
$username   = $decoder['Username'];
$sql ="SELECT * FROM Tests";
			$result = $conn->query($sql);
$testId=$result->num_rows-1;

$output = array();
$sql= "SELECT QuestionStudentRelation.Id, UserAnswer,Feedback,Points,MaxPoints,Question,TestId FROM QuestionStudentRelation, Questions Where QuestionStudentRelation.QuestionId=Questions.Id AND QuestionStudentRelation.TestId=$testId AND QuestionStudentRelation.Username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                                $output[] = array(
                                                'Id' => $row['Id'],
                                                'Points' => $row['Points'],
                                                'Question' => $row['Question'],
                                                'UserAnswer' => $row['UserAnswer'],
                                                'Feedback' => $row['Feedback'],
                                                'MaxPoints' => $row['MaxPoints'],
                                              
                                           
                                );
                }
} else {
                echo "0 results";
}
echo json_encode($output, true);
mysqli_close($conn);
?>