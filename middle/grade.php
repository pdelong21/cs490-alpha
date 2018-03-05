<?php
/**
 * Created by PhpStorm.
 * User: pdelong
 * Date: 3/2/18
 * Time: 10:41 AM
 */
$handIn_url = 0 /* sunnys database that will store the grades*/ ;
$test_url = 'https://web.njit.edu/~sdp53/cs490/getTest.php';
$max_points = 0;
$points_recieved_arr = array();
$points_ratio_arr = array();


$test_obj [] = array(
        'User' => 'someonesmart',
        'Answer' => "x=10 \ny=12 \nz=x+y \nprint(str(z))",
        'Cases' => 'f(2,2)',
        'Points' => 10

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

function getTest($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
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
    $points = 0.0;
    /*str_replace(' ', '', $std_ans)*/
    writeFile('python.py',$std_ans);
    $output = compileMe('python.py');
    switch ($case){
        case 0:
            #check to see if it compiled or not -- 1 point or zero for whole problem
            if(end($output) == 0 && $std_ans != null){
                $points ++;
            } else return $points;
        case 1:
            #check to see if the function name matches -- 1 point
        case 2:
            #check to see if output is correct or not -- 3 points
    }
    $points = $points/5.0;
    return $points;
}

function percentGrade($points_array, $maxpoints){
    $sum = 0.0;
    if ($maxpoints != 0){
        for ($i=0;$i<count($points_array); $i++){
            $sum += $points_array[$i];
        }
        return ($sum/$maxpoints)*100;
    } else return 0;

}


/*  this is the students input to test, should be in the form of an array:
    array[user, questionID,
*/
/*
 * 1) Accept user input
 * 2) Write file only once, lets not waste writes!
 * 3) For each test case, compile the code
 * 4) Match the function name
 * 5) Confirm the answer
 */
# Accept the user input
#$ans_obj = file_get_contents('php://input');
#$ans_decoded = json_decode($ans_obj, true);

$ans_decoded[]= 'print("hi")';
$ans_decoded[] = "asdasd";

# Retrieve the exam for grading
#$test_obj = getTest($test_url); # contains an array of arrays - format [nth Ques] -> Ass. Array()
#echo $test_obj[0]['Points'];

# Start grading process -- returns double
for ($i=0; $i < count($ans_decoded); $i++){
    $max_points += $test_obj[$i]['Points']; # points possible on test

    $grade_res = gradeMe(0, $ans_decoded[$i]); # returns points for current question
    $points_ratio_arr [] = $grade_res; # contains a decimal for how many points they got
    $points_recieved_arr [] = $points_ratio_arr[$i]*$test_obj[$i]['Points']; # tally of points recieved
}

# get the percentage of the test grade
$perc [] = percentGrade($points_recieved_arr, $max_points);
$echo_back_json = json_encode($perc);
echo $echo_back_json;

#$grade_res = gradeMe(0, $ans['Id']['Answer']);
#$response_obj = json_encode($grade_res, true);
#echo $grade_res;