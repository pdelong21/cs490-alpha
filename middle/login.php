<?php
// This is where we want to post to
#$url = 'https://www6.njit.edu/cp/login.php';
$db = 'http://web.njit.edu/~sdp53/cs490/login.php';

$data = array('sdp53', 's');
// User name and password should be passed as an array
#$data = json_decode(file_get_contents('php://input'), true));

$ch = curl_init($db);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec ($ch);
    echo $response;

?>
