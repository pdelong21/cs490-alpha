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
$sql    = "SELECT TestQuestionRelation.Points as TotalPoints, Question, UserAnswer,Feedback,QuestionStudentRelation.Points FROM TestQuestionRelation, StudentTestRelation, Questions, QuestionStudentRelation WHERE TestQuestionRelation.TestId = StudentTestRelation.TestId AND StudentTestRelation.TestID = QuestionStudentRelation.TestID AND TestQuestionRelation.QuestionId=Questions.Id AND TestId='$testId' AND Username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                                $output[] = array(
                                                'Points' => $row['Points'],
                                                'Question' => $row['Question'],
                                                'UserAnswer' => $row['Question'],
                                                'Feedback' => $row['Question'],
                                                'TotalPoints' => $row['TotalPoints'],
                                              
                                           
                                );
                }
} else {
                echo "0 results";
}
echo json_encode($output, true);
mysqli_close($conn);
?>