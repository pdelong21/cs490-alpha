<?php
$dbserver = "sql1.njit.edu";
$user     = "sdp53";
$password = "oEnFrxKN";
$database = "sdp53";
$conn     = mysqli_connect($dbserver, $user, $password, $database);
if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
}
$output = array();
$sql    = "SELECT * FROM Users WHERE Permission='Student'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                                $output[] = array(
                                                'Username' => $row['Username']
                                );
                }
} else {
                echo "0 results";
}
echo json_encode($output, true);
mysqli_close($conn);
?>