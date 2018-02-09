<!DOCTYPE HTML>
<?php
if(isset($_POST['submit'])){
    $user = $_POST['Username'];
    $pwd = $_POST['Password'];
    $url = 'https://web.njit.edu/~sdp53/cs490/login.php';

    # Pass the data to a json object
    $data_obj = json_encode(array('Username' => $user, 'Password' => $pwd), true);

    # Create curl session $ set options
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_obj);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Execute curl request
    $response = curl_exec($ch);
    # Decode the response
    $data_res = json_decode($response, true);
    curl_close($ch);

}
?>
<html>
    <body>
        <h1><center>LOGIN</center></h1>
        <!-- Login Form -->
        <center>

            <form action="" method="post">
                Username:<br>
                <input type="text" name="Username"><br>
                Password:<br>
                <input type="password" name="Password"><br>
                <input type="submit" name='submit' value="submit">
                <input type="reset"> <br>
                Output: <?php echo $data_res ?>
            </form>

        </center>

    </body>
</html>
