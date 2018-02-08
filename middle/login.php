<?php
// This is where we want to post to
#$url = 'https://www6.njit.edu/cp/login.php';


$data = json_encode(array('Username' => "sdp53", 'Password' => "password"),true);
// User name and password should be passed as an array
#$data = json_decode(file_get_contents('php://input'), true));

/*
$ch = curl_init($db);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
*/
    $curl=curl_init();
    $db = 'http://web.njit.edu/~sdp53/cs490/login.php';

    curl_setopt_array($curl,array(
        CURLOPT_URL => $db,
        CURLOPT_POST => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POSTFIELDS => $data

    ));
    $response = curl_exec($curl);
    $array = json_decode($response, true);
    echo $array["Response"];

?>
