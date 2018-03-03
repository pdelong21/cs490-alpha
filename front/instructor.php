<!DOCTYPE html>
<html>
<head>
	<h1>Welcome Professor</h1>
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
	#diffSetting{display:none;}

	#pScore{display:none;}
	#genExam{display:none;}
</style>
</head>
<body>
	<!-- Make Buttons to make an exam, publish score(s), and log out respectively -->
	<p><button onclick="makeQuestion()">Make a Question</button></p>
	<p><button onclick="makeExam()">Make an exam</button></p>
	<p><button onclick="pubScore()">Publish Score(s)</button></p>
	<button onclick="logOut()">Log Out</button>
	
	<!-- exam -->
	<!-- Split Screen to make a question on the left side of the screen, and view similar questions on the right -->
	<div id="sScreen" style="display:none">
		<!-- Split Screen Left side -->
		<div class ="split left">
			<h2><b>Create a question</b></h2>
			
			<!-- Difficulty Settings for Easy/Medium/Hard -->	
			
			<p>Select Difficulty:</p>
			<select name="pdiff" id="diff">
				<option value="Easy">Easy</option>
				<option value="Medium">Medium</option>
				<option value="Hard">Hard</option>
			</select>
      

			<p>Points:</p>
			<input type="number" name="ppts" id="pts"><br>
			<!-- Type a Question/answer to the question to POST to mid -->
			<p>Enter a Question:</p>
			<textarea rows="10" cols="50" name="pqtn" id="qtn" onkeyup="testFunc(this.value)"></textarea><br>
			<p>Enter the Answer:</p>
			<textarea rows="10" cols="50" name="pans" id="ans"onkeyup="testFunc(this.value)"></textarea><br>
			<p><button onclick="createQuestion()">Create Question</button>
	                <button onclick="goBack()">Back</button></p>
		</div>
		
		<!-- Split Screen Right side -->
		<div class="split right">
			<h2><b>Related Questions</b></h2>
			<p>WIP</p>
			<p><span id="cpyq"></span></p>
			<p><span id="cpya"></span></p>
		</div>
	</div>

	<div id="genExam">
		<h2>Select Questions:</h2>
		<div id="examQuestions"></div>
    <p id="exQ"></p>
	</div>

	<!-- Publish the Score -->
	<div id="pScore">
		<p>Publish the scores here</p>
	</div>
 
</body>
</html>

<script>
	function makeQuestion(){
		var mq=document.getElementById("sScreen");
		if(mq.style.display ==="none"){
			mq.style.display = "inline";
		}
		else{
			mq.style.display = "none";
		}
	}
</script>

<script>
	function createQuestion(){
		var req = new XMLHttpRequest();
		var url="insertQuestions.php";
		var cq=document.getElementById("sScreen");

		//make variables to send to PHP
		var Difficulty=document.getElementById("diff").value;
		var Question=document.getElementById("qtn").value;
		var Answer=document.getElementById("ans").value;
		var strPoints=document.getElementById("pts").value;
//		var Points=parseInt(strPoints);
		var Points=Number(strPoints);
//		var vars=[Question,Difficulty,Points,Answer];
//		var vars = "Questions="+Question+"Difficulty="+Difficulty+"Points="+Points+"Cases="+Answer;
		var vars={"Question":Question,"Difficulty":Difficulty,"Points":Points,"Cases":Answer};
		
		//checking variables and variable types (var, var type) in console
		console.log(Question + ', ' + typeof Question);
		console.log(Answer + ', ' + typeof Answer);
		console.log(Points + ', ' + typeof Points);
		console.log(Difficulty + ', ' + typeof Difficulty);

		req.open("POST",url,true);

		//checking what vars is
		console.log(vars);

		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		if(Question === "" || Answer === "" || Points === ""){
			window.alert("One or more fields are empty, please fill them out!");
		}
		else if(Points ===0){
			window.alert("Points cannot be 0.");
		}
		else{
//			req.send(vars);
//			console.log(vars);

			req.send(JSON.stringify(vars));
			console.log(JSON.stringify(vars));
	
			req.onreadystatechange = function(){
				if(req.readyState==4 && req.status==200){
	        	                return_data=req.responseText;
					var data=JSON.parse(return_data);
	
					if(data['Response']=="Successfully Inserted"){
               		        		window.alert("Question Added to DB!");
					}
					else if(data['Response']=="INVALID"){
						window.alert("invalid question");
					}
					else{
						window.alert("Everything is wrong, what are you doing");
					}
   		  }
			}
		
			//resetting display back to teacher landing page
			if(cq.style.display === "none"){
				cq.style.display = "inline";
			}
			else{
				cq.style.display = "none";
			}
			//checking and resetting variables
//			document.getElementById("check").innerHTML =Difficulty+"<br>"+Question+"<br>"+Answer+"<br>"+Points;
			document.getElementById("pts").value = "";
			document.getElementById("qtn").value = "";
			document.getElementById("ans").value ="";
			document.getElementById("diff").value = "Easy";
		//closing else loop
		}
	}
</script>

<script>
	function testFunc(str){
		var testq=document.getElementById("qtn").value;
		var testa=document.getElementById("ans").value;
		document.getElementById("cpyq").innerHTML=testq;
		document.getElementById("cpya").innerHTML=testa;
	}
</script>

<script>
  //var temp;
  var questHTML;
  var questArray=[];
  var len;
  var qIDArr=[];
	function makeExam(){
        var dq = new XMLHttpRequest();
        var questUrl = "viewQuestion.php";
        //var questArray=[];
        var temp;
        dq.onreadystatechange=function(){
            if(dq.readyState == 4){
                var dispQuest = document.getElementById("examQuestions");
                var resText=dq.responseText;
                var resData=JSON.parse(resText);
                len=resData.length;
    //            console.log(resData);
		//console.log(len);
		questHTML="<div class='row'>";
		questHTML+="<table id='tbl'>"
		questHTML+="<tr><th>Add</th>";
		questHTML+="<th>Question</th>";
		questHTML+="<th>Difficulty</th>";
		questHTML+="<th>Points</th>";
		questHTML+="</tr>";
		
		for(var i=0;i<len;i++){
			questArray.push(resData[i]['Id']);
      temp=resData[i]['Id'];
			questHTML+="<tr>";
			questHTML+='<td><input type="checkbox" name="qList" id="'+temp;
			//questHTML+='" onclick="addToExam()"></td>';
      questHTML+='"></td>';
			questHTML+="<td>"+resData[i]['Question']+"</td>";
			questHTML+="<td>"+resData[i]['Difficulty']+"</td>";
			questHTML+="<td>"+resData[i]['Points']+"</td>";
			questHTML+="</tr>"; 
      //temp = document.getElementById("resData[i]['Id']");
      //console.log(temp);
		}
		questHTML+="</table></div>";
    questHTML+='<input type="button"onclick="addToExam()"';
    questHTML+='value="Add to Exam"></input>';
		dispQuest.innerHTML=questHTML;
            }
        }

		var ge=document.getElementById("genExam");
                if(ge.style.display ==="none"){
                        ge.style.display = "inline";
                }
                else{
                        ge.style.display = "none";
                }
	dq.open("POST",questUrl,true);
	dq.send(null);
	}

  function addToExam(){
    var aReq = new XMLHttpRequest();
    var eUrl = "addExam.php"
    
    for(var j=0;j<len;j++){
      var chkbox=document.getElementById(questArray[j]);
      //console.log(chkbox);
      //console.log(questArray[j]);
      var chkOutput=document.getElementById("exQ");
    
      if(chkbox.checked){
      //chkOutput.innerHTML = "Selected question(s) added to exam!";
        chkbox.checked=false;
        qIDArr.push({Id:j});
      
      }
      else{
      //qIDArr[j]=0;
        chkOutput.innerHTML = "Select at least one question to make an exam!";
      }
    }
    console.log(qIDArr);
    var sendList=qIDArr;
    var toPost=JSON.stringify(sendList);
    aReq.open("POST", eUrl, true);
    aReq.send(toPost);
    //reset array. Lazy but works for now
    qIDArr=[];
  }
</script>

<script>
	function pubScore(){
		var ps=document.getElementById("pScore");
		if(ps.style.display ==="none"){
			ps.style.display = "inline";
		}
		else{
			ps.style.display = "none";
		}
	}	
</script>
<script>
    function goBack(){
        var win=window.open("instructor.php","_self");
    }
</script>
<script>
	function logOut(){
		var win=window.open("login.php","_self");
	}
</script>

