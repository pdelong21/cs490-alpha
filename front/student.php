<?php ob_start(); ?>



<!DOCTYPE html>
<html>
<head>
	<h1>WELCOME STUDENT</h1>
	<style>
	#exam{display:none;}
  #vScore{display:none;}
	</style>	
</head>
<body>
	<p><button onclick="takeExam()">Take Exam</button></p>
	<p><button onclick="viewScore()">View Score</button></p>
	<p><button onclick="logOut()">Log Out</button></p>
	<div id="exam">
		<div id="dispExam">
      
		</div>
	</div>
	<p id="exStatus"></p>
	<div id="vScore">
		This is where the Student will be able to view the score.
	</div>
</body>
</html>

<script>
  var ansArr=[];
  var exHTML;
	function takeExam(){
    var rStatusDisp=document.getElementById("exStatus");
    rStatusDisp.innerHTML="";
    var rScoreDisp=document.getElementById("vScore");
    rScoreDisp.style.display="none";
    //var ansArr=[];
		var aReq = new XMLHttpRequest();
		var exUrl = "viewExam.php";
		
		aReq.onreadystatechange=function(){
			if(aReq.readyState==4){
				var exDisp=document.getElementById("dispExam");
				var resText=aReq.responseText;
				console.log(resText);
        
        var resData=JSON.parse(resText);
        var len=resData.length;
        console.log(len);
        console.log(resData);
        
        exHTML ="<p>Exam</p>";
        for(var i=0;i<len;i++){
          ansArr.push(resData[i]['QuestionId']);
          
          var qID=resData[i]['QuestionId'];
          var qtn=resData[i]['Question'];
          var pts=resData[i]['Points'];
          
          exHTML+='<p>Question '+(i+1)+':</p>';
          exHTML+='<p>'+qtn+'</p>';
          exHTML+='<p>Points: '+pts+'</p>';
          exHTML+='<p>Enter your answer:</p>';
          exHTML+='<textarea rows="10" cols="80" name="'+qID+'" id="'+qID+'">';
          exHTML+='</textarea>';
        }
        
        exHTML+='<p>';
        exHTML+='<input type="button" value="Submit" onclick="submitEx();"></input>';
        exHTML+='</p>';
        console.log(exHTML);
        exDisp.innerHTML=exHTML;
			}
		}
   
   var ex = document.getElementById("exam");
		if(ex.style.display === "none"){
			ex.style.display = "inline";
		}
		else{
			ex.style.display = "none";
		}
   
   aReq.open("POST",exUrl,true);
   aReq.send(null);
	}
</script>

<script>
  function submitEx(){
    var se = document.getElementById("exam");
    var status=document.getElementById("exStatus");
    console.log(se);
    console.log(status);
		se.style.display="none";
   
   status.innerHTML="exam sent! (not really, this is just a dummy button for now)";
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
