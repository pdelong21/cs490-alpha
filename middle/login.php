<?php
/**
 * Created by PhpStorm.
 * User: pdelong
 * Date: 2/22/18
 * Time: 8:33 PM
 */
// Login Database
$loginUrl= 'https://web.njit.edu/~sdp53/cs490/login.php';

// Curl func
function Login($data_obj, $url){
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

# Get input from front to forward
$login_obj = file_get_contents('php//input');
//$login_data = json_encode(['Username' => 'std2', 'Password' => 'passstud2'], true);

# Retrieve response from backend
$loginType = Login($login_obj,$loginUrl);
//$loginType = Login($login_data, $loginUrl);

$loginType_obj = json_encode($loginType, true);
echo $loginType_obj;

# Redirect to appropiate page
if($loginType['Response'] == 'Student'){
    header('Location: https://web.njit.edu/~jp484/490/student.php');
}
else{
    #bleh
}
