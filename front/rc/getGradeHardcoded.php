<?php
    $response=file_get_contents('php://input');
    $field=array('Username'=>"std1");
    $send=json_encode($field);
    #$send=json_decode($response,true);
    $curl=curl_init();

    $url="https://web.njit.edu/~sdp53/cs490/getGrade.php";
#    $url="https://web.njit.edu/~pgd22/middle/getStudentGradeProf.php";

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_POST => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POSTFIELDS => $send
    ));
    $resp = curl_exec($curl);
    echo $resp
?>