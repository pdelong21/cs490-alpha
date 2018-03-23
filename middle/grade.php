<?php
/**
 * Created by PhpStorm.
 * User: pdelong
 * Date: 3/2/18
 * Time: 10:41 AM
 */
$handIn_url = 'https://web.njit.edu/~sdp53/cs490/insertGrade.php' /* sunnys database that will store the grades*/ ;
$test_url = 'https://web.njit.edu/~sdp53/cs490/getTest.php';
$cases_url = 'https://web.njit.edu/~sdp53/cs490/getTestCases.php';
$max_points = 0;
$points_recieved_arr = array();


/*
$test_obj [] = array(
        'User' => 'someonesmart',
        'Answer' => "x=10 \ny=12 \nz=x+y \nprint(str(z))",
        'Question' => 'write a function "func"',
        'Cases' => 'f(2,2)',
        'Points' => 10,
        'TestID' => 13,
        'TestCases' => "sub(3,2) 1 | sub(10,5) 5 | sub(7,3) 4"

);
*/


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

function gradeMe($case, $std_ans, $func_case){
    $points = 0.0;
    $feedback = '';
    /*str_replace(' ', '', $std_ans)*/
    writeFile('python.py',$std_ans);
    $output = compileMe('python.py');
    switch ($case){
        case 0:
            #check to see if it compiled or not -- 1 point or zero for whole problem
            if(end($output) == 0 && $std_ans != null){
                $points ++;
                $feedback = $feedback.'Your program compiled! ';
            } else return $points;
        case 1:
            #check to see if the function name matches -- 1 point
            if (strpos($std_ans, $func_case) == FALSE) {
                continue;
            } else{
                $points+=1;
                $feedback = $feedback.'The function name matches. ';
            }
        case 2:
            #check to see if output is correct or not -- 3 points -- check in progress
            $points+=3;
            $feedback = $feedback."And the rest is tbc so for now you got test case 3... so proud :')";
    }
    $points = $points/5.0;
    $array = ['Points' => $points, 'Feedback' => $feedback];
    return $array;
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
$ans_obj = file_get_contents('php://input');
$ans_decoded = json_decode($ans_obj, true);

#$ans_decoded [] = "pgd22";

$username = $ans_decoded['User'];
$std_test ['Username'] = $username;
$std_test ['Question'] = array();

#$ans_decoded[]= "def func():\n\tx=1";
#$ans_decoded[] = "asdasd";

# Retrieve the exam for grading

$test_obj = getTest($test_url); # contains an array of arrays - format [nth Ques] -> Ass. Array()
//print_r($test_obj);
#echo $test_obj[0]['Points'];
# Start grading process -- returns double
for ($i=0; $i < count($ans_decoded['Answers']); $i++){
    $max_points += $test_obj[$i]['Points']; # points possible on test
    //preg_match('/"([a-zA-Z]+)"/', $test_obj[$i-1]['Question'], $m); #get func name from question
    //$func_name = end($m);
    #preg_match_all('/([0-9]+)\s|[0-9]$/',$test_obj[$i-1]['TestCases'],$c);
    #print_r($c);
    $grade_res = gradeMe(0, $ans_decoded['Answers'][$i],$test_obj[$i]['Signature']); # returns array of points and feedback
    $points_recieved_arr [] = $grade_res['Points']*$test_obj[$i]['Points']; # tally of points recieved
    $std_test ['Question'][$i] = array('Response' => $ans_decoded['Answers'][$i], 'Points' => $points_recieved_arr[$i],
        'Feedback' => $grade_res['Feedback']);
}

# get the percentage of the test grade
$std_test ['Grade'] = percentGrade($points_recieved_arr, $max_points);
$echo_back_json = json_encode($std_test);
#$var = handIn($echo_back_json, $handIn_url);
echo json_encode($std_test, true);
