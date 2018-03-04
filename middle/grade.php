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
        'Answer' => "x=10 \n y=12 \n z=x+y \n print(str(z))",
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

function writeFile($python_file, $student_res){
    $handle = fopen($python_file, 'w') or die("Can't open...");
    fwrite($handle, $student_res);
    fclose($handle);
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
    writeFile('python.py',str_replace(' ', '', $std_ans));
    $output = compileMe('python.py');
    switch ($case){
        case 0:
            #check to see if it compiled or not -- 1 point
            if(end($output) == 0 && $std_ans != null){
                $points ++;
            } else return $points;
        case 1:
            #check to see if the function name matches -- 1 point
        case 2:
            #check to see if output is correct or not -- 3 points
    }
    return $points;
}



/*  this is the students input to test, should be in the form of an array:
    array[user, questionID,
*/
#$std_res_obj = file_get_contents('php://input');
/*
 * 1) Accept user input
 * 2) Write file only once, lets not waste writes!
 * 3) For each test case, compile the code
 * 4) Match the function name
 * 5) Confirm the answer
 */
# Accept the user input
$grade_obj = file_get_contents('php://input');
$grade_decoded = json_decode($grade_obj, true);

# Start grading process -- returns an integer
$grade_res = gradeMe(0, $grade_decoded['Response']);
#$grade_res = gradeMe(0, $ans['Id']['Answer']);
$response_obj = json_encode($grade_res, true);
echo $grade_res;