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
$ouput = array();
$sql = "SELECT * FROM Tests";

$result = $conn->query($sql);
$tid=$result->num_rows-1;

$sql2="SELECT * FROM Questions,TestQuestionRelation WHERE TestQuestionRelation.QuestionId=Questions.Id AND TestQuestionRelation.TestId='$tid'";
$result2 = $conn->query($sql2);

if ($result2->num_rows > 0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {
        $output[]=array(
          'QuestionId' =>$row['QuestionId'],
          'Question' =>$row['Question'],
          'Difficulty' =>$row['Difficulty'],
          'Points' =>$row['Points'],
          'TestCases' =>$row['TestCases'],
          'TestQuestionRelationId' =>$row['Id'],
          'TestID' =>$row['TestId'],
        );
    }
} else {
    echo "0 results";
}
echo json_encode($output,true);
mysqli_close($conn);

?>
