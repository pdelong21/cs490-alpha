<?php

$dbserver = "sql1.njit.edu"; 
$user = "sdp53"; 
$password = "oEnFrxKN";
$database = "sdp53";

$response = file_get_contents('php://input');
$decoder = json_decode($response,true); 

$username=$decoder['Username'];
$output = array();
// Create connection
$conn = mysqli_connect($dbserver, $user, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql1 = "SELECT * FROM Tests";

$result1 = $conn->query($sql1);
$testId=$result1->num_rows-1;

$sql2 = "SELECT * FROM Tests WHERE Id=$testId";

$result2 = $conn->query($sql2);

$row = mysqli_fetch_assoc($result2);
$released= (int)$row["Released"];

if($released==1){

$sql    = "SELECT QuestionStudentRelation.Id, UserAnswer,Feedback,Points,MaxPoints,Question,TestId FROM QuestionStudentRelation, Questions Where QuestionStudentRelation.QuestionId=Questions.Id AND QuestionStudentRelation.TestId=$testId AND QuestionStudentRelation.Username='$username'";
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
}


echo json_encode($output,true);

}
 

mysqli_close($conn);


?>