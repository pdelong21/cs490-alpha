<?php ob_start(); ?>

<html>
<head>
	<h1>LOGIN</h1>
</head>
<body>
    	Username:  <input type="text" name="username" id="username"/><br />
	Password: <input type="password" name="password" id="password" /><br />
	<input type="submit" name="enter" value="Submit" onClick="aj();" />
 
	<p id="test"></p>
	<p id="rData"></p>
</body>
</html>

<script>
var return_data;
function aj(){
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "loginphp.php";
    var sUrl = "student.php";
    var iUrl = "instructor.php";
    var u = document.getElementById("username").value;
    var p = document.getElementById("password").value;
    var vars = "username="+u+"&password="+p;
    hr.open("POST", url, true);

    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	if(hr.readyState == 4 && hr.status == 200) {
		return_data = hr.responseText;
        	var data=JSON.parse(return_data);
		 document.getElementById("rData").innerHTML = data['Response'];
		//if(data['Response']
        	if(data['Response']=="Student"){
          		// document.getElementById("test").innerHTML = "change to Student Landing Page instead of this message";
			var win=window.open("student.php","_self");
        	}else if(data['Response']=="Instructor"){
          		// document.getElementById("test").innerHTML = "change to Instructor landing page instead of this message";
			var win=window.open("instructor.php","_self");
        	} 
		else{
			document.getElementById("test").innerHTML = "Invalid Credentials";
		}
	}
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
}
</script>
