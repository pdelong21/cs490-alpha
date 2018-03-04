<?php
/**
 * Created by PhpStorm.
 * User: pdelong
 * Date: 3/3/18
 * Time: 11:08 PM
 */

$url = 'https://web.njit.edu/~sdp53/cs490/getTest.php';

function getTest($data_obj, $url){
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

$test_obj = file_get_contents('php://input');

$test_res = getTest($test_obj, $url); # pass to sunny & retrieve response

$response_obj = json_encode($test_res, true); # encode the response from sunny
echo $response_obj; # echo back to front
#print_r($displayQ_res) ;
