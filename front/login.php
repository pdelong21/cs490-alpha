
<head>
        <h1>LOGIN</h1>
</head>

<body>
<div class="signIn">

<fieldset>
	Username:<input id="user" name="user" type="text"/><br /><br/>
	Password:<input id="pass" name="pass" type="password"/><br /><br />
	<input name="btn" type="submit" value="login" onClick="aPost(this.fieldset);">
</fieldset>  
       
<div id="status"></div>

<p id="test">test</p>

</body>

<script language="javascript">
function aPost(){
    var hr = new XMLHttpRequest();
    var url = "check2.php";
    var u = document.getElementById("user").value;
    var p = document.getElementById("pass").value;
    var vars = "ucid="+u+"&pass="+p;
      hr.open("POST", url , true);
      hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  
      hr.onreadystatechange = function() {
	      if(hr.readyState == 4 && hr.status == 200) {
		      
			  var return_data = hr.responseText;
			  console.log(return_data);
			  
			  var myobj = JSON.parse(return_data);
			  
			  console.log(myobj);
			  
			  document.getElementById('test').innerHTML=(myobj);
			   
	    }
    }
      hr.send(vars); 
	  }
</script>
