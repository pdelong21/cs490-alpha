<?php
/**
 * Created by PhpStorm.
 * User: pdelong
 * Date: 2/28/18
 * Time: 10:53 AM
 */
$url = 'https://web.njit.edu/~sdp53/cs490/insertQuestions.php';

function addQ($data_obj, $url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_obj);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $r_decoded = json_decode($response, true);
    curl_close($ch);
    return $r_decoded;

}

$addQ_obj = file_get_contents('php://input');

$addQ_response = addQ($addQ_obj, $url);

$response_obj = json_encode($addQ_response, true);
echo $response_obj;