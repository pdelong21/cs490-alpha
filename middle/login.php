<?php
/*
    Author: Patrick Delong
    Resources used: php.net/manual
*/
    // This is where we want to post to and get our response back from
    $url = 'https://www6.njit.edu/cp/login.php';
    $db = 'https://web.njit.edu/~sdp53/cs490/login.php';

    # Accept the json data from the front & decode, we are passing an array
    $data = file_get_contents(json_decode('php://input'));
    #$data = array('Username' => 'sdp53', 'Password' => 'password');

    # Pass the data to a json object
    $data_obj = json_encode($data, true);

    # Create curl session $ set options
    $ch = curl_init($db);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_obj);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    # Execute curl request
    $response = curl_exec($ch);

    # Decode the response
    $data_res = json_decode($response, true);

    # Echo the json object back to the front if it was valid
    if($data_res['Response'] == 'VALID'){
        echo json_encode(array('Response' => "Logged into the database!"), true);
        #print_r($data_res);
    }
    # Try to log into NJIT instead
    else if($data_res['Response'] == 'INVALID'){
        echo json_encode(array('Response' => "Failed to login to the database"), true);
    }
    else {
        // Should never get here
        echo "Something didn't work right\n";
    }
    # Close previous session
    curl_close($ch);

    # Create new session
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_obj);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    $data_res = json_decode($response, true);

    if(is_null($data_res)){
        echo json_encode(array('Response' => "Failed to login to NJIT"));
    }
    else{
        echo json_encode(array('Response' => 'You logged into NJIT!'));
    }
#print_r($data_res);

    // Free up resources
    curl_close($ch);


