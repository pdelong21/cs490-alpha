<?php
$dbserver = "sql1.njit.edu";
$user     = "sdp53";
$password = "oEnFrxKN";
$database = "sdp53";

$response   = file_get_contents('php://input');
$decoder    = json_decode($response, true);
$questionID   = $decoder['QuestionID'];

$conn     = mysqli_connect($dbserver, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$ouput   = array();
$sql     = "SELECT * FROM Tests";
$result  = $conn->query($sql);
$tid     = $result->num_rows - 1;
$sql2    = "SELECT * FROM TestCases WHERE QuestionID = $questionID";
$result2 = $conn->query($sql2);
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $output[] = array(
            'Testcase' => $row['Testcase'],
            'Answer' => $row['Answer'],

        );
    }
} else {
    echo "0 results";
}
echo json_encode($output, true);
mysqli_close($conn);
?>