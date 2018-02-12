<?php
/*
    Author: Patrick Delong
    Resources used: php.net/manual
*/
    // This is where we want to post to and get our response back from
    $url = 'https://cp4.njit.edu/cp/home/login';
    $db = 'https://web.njit.edu/~sdp53/cs490/login.php';

    # This array goes to front
    $to_front = array();

    # Accept the json data from the front & decode, we are passing an array
    $getdata = file_get_contents('php://input');
    $data = json_decode($getdata, true);

    # Pass the data to a json object
    $data_obj = json_encode($data, true);

    # Create curl session to login to the database
    $ch = curl_init($db);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_obj);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    # Execute curl request
    $response = curl_exec($ch);
    $data_res = json_decode($response, true);
    curl_close($ch);

    # Throw response into array
    if($data_res['Response'] == 'VALID'){
        $to_front += ['db' => 'VALID'];
        #print_r($data_res);
    }
    # Try to log into NJIT instead
    else if($data_res['Response'] == 'INVALID'){
        $to_front += ['db' => 'INVALID'];
    }
    else {
        // Should never get here
        echo "Something didn't work right\n";
    }

    # Create new session for logging into NJIT
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'user='.$data['Username'].'&pass='.$data['Password'].'&uuid=0xACA021');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    # Execute curl request
    $response = curl_exec($ch);
    curl_close($ch);
    # throw response into array
    if(strpos($response,"Failed Login") != FALSE){
        $to_front += ['njit' => 'INVALID'];
    }
    else if(strpos($response, "Login Successful") != FALSE){
        $to_front += ['njit' => 'VALID'];
    }

    # json array back to front
    echo json_encode($to_front, true);


