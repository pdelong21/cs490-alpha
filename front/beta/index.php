
<!DOCTYPE html>
<html>
<head>
	<h1>LOGIN</h1>
</head>
<body>
	<!-- Login Form -->
	<p>UCID:</p>
	<input id="user" type="text" value=""></input>

	<p>PASSWORD:</p>
	<input id="pwd" type="password" value=""></input>

	<p></p>

	<button type="button" id="login" 
	  onclick="userIn()">Log in</button>

	<button type="button" id="reset" 
	  onclick="clearFields()">Clear Fields</button>

	<!-- Check and response -->
	<p id="test"></p>
	<p id="test2"></p>

	<!-- scripts -->
	<script>
		function userIn(){
			var req=new XMLHttpRequest();
			var url="check.php";
			var name=document.getElementById('user').value;
			var pass=document.getElementById('pwd').value;
			var cred=[name, pass];

			//Start of AJAX part I think
			req.open("POST", url, true);
			req.onreadystatechange=function(){
        		if(req.readyState==4 && req.status==200){
				var rData=req.responseText;
          			console.log(rData);
          			var obj=JSON.parse(rData);
          			console.log(obj);
//				var test="<?php echo $response ?>";
				document.getElementById('test').innerHTML=(rData);
				document.getElementById('test2').innerHTML=(obj);
         
//				$.ajax({
//				type	:	'POST',
//				url	:	'check.php',
//				data	:	{name, pass},
//				success	:	fuction(){

//				add if statements for:
//				NJIT=Yes,Database=No
//				NJIT=No,Database=Yes
//				NJIT=No,Database=No
//				then change the reponse like below to the correct output


//				if(rData=="")
//					document.getElementById('test').innerHTML=(cred);
					document.getElementById('test2').innerHTML=(obj);
//					document.getElementById('test').innerHTML=(test);
          			}
      			}
      		req.send(cred);
//			});
      
		}
	</script>

	<script>
		function clearFields(){
			document.getElementById('user').value="";
			document.getElementById('pwd').value="";
		  	document.getElementById('test').innerHTML="";
		}
	</script>
</body>
</html>

<?php
	session_start();
	$Username=$_POST['name'];
	$Password=$_POST['pass'];
#	$url'=https://web.njit.edu/~pgd22/middle/login.php';
  	$field=array('Username'=>$Username, 'Password'=>$Password);
  	$send=json_encode($field);
	echo $Username;
	echo $Password;  	

  	$curl=curl_init();
  	
#	temp url
 	$url="https://web.njit.edu/~sdp53/cs490/login.php";
#	actual URL
#	$url="https://web.njit.edu/~pgd22/middle/login.php";  
  	curl_setopt_array($curl, array(
    	 CURLOPT_URL => $url,
    	 CURLOPT_POST => 1,
    	 CURLOPT_FOLLOWLOCATION => 1,
    	 CURLOPT_RETURNTRANSFER => 1,
    	 CURLOPT_POSTFIELDS => $send
  	));
$resp = curl_exec($curl);
$response=json_decode($resp,true);
echo $resp;
?>
