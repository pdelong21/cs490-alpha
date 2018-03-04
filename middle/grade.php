<?php
/**
 * Created by PhpStorm.
 * User: pdelong
 * Date: 3/2/18
 * Time: 10:41 AM
 */
$url = 0 /* sunnys database that will store the grades*/ ;
$ans= array(
    'Id' => array(
        'User' => 'someonesmart',
        'Answer' => 'a smart answer',
        'Cases' => 'f(2,2)',
        'Points' => 10
    )
);

function handIn($data_obj, $url){
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

function compileMe($py_file){
    #$file ;
    $cmd = 'python ./'.$py_file;
    $output = array();
    exec($cmd, $output,$return_status);
    $output[] = $return_status;
    return $output;

}

function gradeMe($case, $std_ans){
    $points = 0;
    switch ($case){
        case 0:
            #check to see if it compiled or not -- 1 point
        case 1:
            #check to see if the function name matches -- 1 point
        case 2:
            #check to see if output is correct or not -- 3 points
    }
}



/*  this is the students input to test, should be in the form of an array:
    array[user, questionID,
*/
#$std_res_obj = file_get_contents('php://input');

echo $return_status;
print_r($output);