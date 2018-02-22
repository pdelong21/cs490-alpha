<!DOCTYPE html>
<html>
<head>
	<h1>Instructor</h1>
<style>
	.split {
		height: 100%;
    		width: 50%;
    		position: fixed;
    		z-index: 1;
    		top: 0;
    		overflow-x: hidden;
    		padding-top: 20px;
	}

	.left {
    		left: 0;
    		background-color: white;
	}

	.right {
    		right: 0;
    		background-color: white;
	}

	.centered {
    		position: absolute;
    		top: 50%;
    		left: 50%;
    		transform: translate(-50%, -50%);
    		text-align: center;
	}
	#exam{display:none;}
</style>
</head>
<body>
	<p><button onclick="createExam()">Make an Exam</button></p>
	<p><button onclick-"pubScore()">Publish Score(s)</button></p>
	<button onclick="logOut()">Log Out</button>
	<div id="exam">
		<div class ="split left">
			<p>Shit</p>
			<button onclick="createExam()">Create Exam</button>
		</div>
		<div class="split right">
			<p>Fuck</p>
		</div>
	</div>
</body>
</html>

<script>
	function createExam(){
		var vs=document.getElementById("exam");
		if(vs.style.display === "none"){
			vs.style.display = "inline";
		}
		else{
			vs.style.display = "none";
		}
	}
</script>
<script>
	function createExam(){
		var vs2=document.GetElementById"exam");
		vs2.style.display="none";
	}
</script>
<script>
	function logOut(){
		var win=window.open("login.php","_self");
	}
</script>
