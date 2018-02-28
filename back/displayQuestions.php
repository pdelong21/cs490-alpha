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
$sql = "SELECT * FROM Questions";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $output[]=array(
          'Id' =>$row['Id'],
          'Question' =>$row['Question'],
          'Difficulty' =>$row['Difficulty'],
          'Points' =>$row['Points'],
        );
    }
} else {
    echo "0 results";
}
echo json_encode($output,true);
mysqli_close($conn);

?>
