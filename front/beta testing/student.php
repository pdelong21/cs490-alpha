<?php ob_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<h1>WELCOME STUDENT</h1>
	<style>
	div{display:none;}
	</style>	
</head>
<body>
	<p><button onclick="takeExam()">Take Exam</button></p>
	<p><button onclick="viewScore()">View Score</button></p>
	<p><button onclick="logOut()">Log Out</button></p>
	<div id="exam">
		<p><textarea id="ans" rows="5" cols="100"></textarea></p>
		<button id="submit" onclick="submitAns()">Submit</button>
	</div>
	<div id="vScore">
		This is where the Student will be able to view the score.
	</div>
	<p id="test"></p>
</body>
</html>

<script>
	function takeExam(){
		var ex = document.getElementById("exam");
		if(ex.style.display === "none"){
			ex.style.display = "block";
		}
		else{
			ex.style.display = "none";
		}
	}
</script>
<script>
	function viewScore(){
		var sc = document.getElementById("vScore");
		if(sc.style.display ==="none"){
			sc.style.display = "block";
		}
		else{
			sc.style.display = "none";
		}
	}
</script>
<script>
	function logOut(){
		var win=window.open("login.php","_self");
	}
</script>

<script>
	function submitAns(){
		var pr = new XMLHttpRequest();
		var surl="studentphp.php";
		var answer=document.getElementById("ans").value;
		
		document.getElementById("test").innerHTML=answer;
		pr.open("POST", surl, true);
		pr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		var ex2=document.getElementById("exam");
		ex2.style.display="none";
		pr.send(answer);
	}
</script>
