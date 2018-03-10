<?php session_start(); ?>

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

	
	#genExam{display:none;}
</style>
</head>
<body>
	<!-- Make Buttons to make an exam, publish score(s), and log out respectively -->
	<p><button onclick="makeQuestion()">Make a Question</button></p>
	<p><button onclick="makeExam()">Make an exam</button></p>
	<p><button onclick="pubScore()">Publish Score(s)</button></p>
	<button onclick="logOut()">Log Out</button>
	
	<!-- Make Question -->
	<!-- Split Screen to make a question on the left side of the screen, and view similar questions on the right -->
	<div id="sScreen" style="display:none;">
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
      
			<!-- Type a Question/answer to the question to POST to mid -->
			<p>Enter a Question:</p>
			<textarea rows="10" cols="50" name="pqtn" id="qtn" onkeyup="testFunc(this.value)"></textarea><br>
			<p>Enter the function name:</p>
			<textarea rows="1" cols="25" name="pfunc" id="func" onkeyup="testFunc(this.value)"></textarea><br>
      <p>Enter the test case(s) and the answer(s):</p>
      <p></p>
      <!-- <input type="button" value="Add Test Case" onclick="addTestCase()"> -->
      <input type="text" id="T1" name="TestCase" placeholder="Test Case(s)">
      <input type="text" id="EA1" name="TCAns" placeholder="Expected Answer">
      <p></p>
      <input type="text" id="T2" name="TestCase" placeholder="Test Case(s)">
      <input type="text" id="EA2" name="TCAns" placeholder="Expected Answer">
      <p></p>
      <input type="text" id="T3" name="TestCase" placeholder="Test Case(s)">
      <input type="text" id="EA3" name="TCAns" placeholder="Expected Answer">
      <p></p>
      <input type="text" id="T4" name="TestCase" placeholder="Test Case(s)">
      <input type="text" id="EA4" name="TCAns" placeholder="Expected Answer">
      <p></p>
      <input type="text" id="T5" name="TestCase" placeholder="Test Case(s)">
      <input type="text" id="EA5" name="TCAns" placeholder="Expected Answer">
      <p></p>
      <!-- <div id="TCA"></div> -->
      <p></p>
			<p><button onclick="createQuestion()">Create Question</button>
	                <button onclick="goBack()">Back</button></p>
      <p id="DBStat"></p>
		</div>
		
		<!-- Split Screen Right side -->
		<div class="split right">
			<h2><b>Question Bank</b></h2>
			<p>WIP</p>
			<p><span id="cpyq"></span></p>
			<p><span id="cpya"></span></p>
		</div>
	</div>

	<div id="genExam" style="display:none;">
		<h2>Select Questions:</h2>
		<div id="examQuestions"></div>
    <p id="exQ"></p>
	</div>

	<!-- Publish the Score -->
	<div id="pScore" style="display:none;">
		<p id="pubStat"></p>
	</div>
	<p id="status"></p>
 
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
    var DBStatus=document.getElementById("DBStat");
    
    var tcaArr1=[];
    var tcaArr2=[];
    var tcaArr3=[];
    var tcaArr4=[];
    var tcaArr5=[];
    var pArr=[];

		//make variables to send to PHP
		var Difficulty=document.getElementById("diff").value;
		var Question=document.getElementById("qtn").value;
		var Signature=document.getElementById("func").value;
		//var foo=document.getElementById("TestCase").value;
    //var bar=document.getElementById("TCAns").value;
    
    //it's early in the morning, and my brain's not really working right now
    var TC1=document.getElementById("T1").value;
    var ExA1=document.getElementById("EA1").value;
    tcaArr1.push(TC1);
    tcaArr1.push(ExA1);
    
    var TC2=document.getElementById("T2").value;
    var ExA2=document.getElementById("EA2").value;
    tcaArr2.push(TC2);
    tcaArr2.push(ExA2);
    
    var TC3=document.getElementById("T3").value;
    var ExA3=document.getElementById("EA3").value;
    tcaArr3.push(TC3);
    tcaArr3.push(ExA3);
    
    var TC4=document.getElementById("T4").value;
    var ExA4=document.getElementById("EA4").value;
    tcaArr4.push(TC4);
    tcaArr4.push(ExA4);
    
    var TC5=document.getElementById("T5").value;
    var ExA5=document.getElementById("EA5").value;
    tcaArr5.push(TC5);
    tcaArr5.push(ExA5);
    
    console.log(tcaArr1);
    console.log(tcaArr2);
    console.log(tcaArr3);
    console.log(tcaArr4);
    console.log(tcaArr5);
    
    pArr.push(tcaArr1);
    pArr.push(tcaArr2);
    pArr.push(tcaArr3);
    pArr.push(tcaArr4);
    pArr.push(tcaArr5);
    
    console.log(pArr);
//		var Points=parseInt(strPoints);
		
//		var vars=[Question,Difficulty,Points,Answer];
//		var vars = "Questions="+Question+"Difficulty="+Difficulty+"Points="+Points+"Cases="+Answer;

// add signature, which is function name and paramaters and an array containing the test cases and answers
		var vars={"Question":Question,"Difficulty":Difficulty,"Signature":Signature, "Cases":pArr};
		
		//checking variables and variable types (var, var type) in console
		//console.log(Question + ', ' + typeof Question);
		//console.log(Answer + ', ' + typeof Answer);
		//console.log(Difficulty + ', ' + typeof Difficulty);
    //console.log(foo);
    //console.log(bar);
		req.open("POST",url,true);

		//checking what vars is
		console.log(vars);

		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		if(Question === "" || Signature === ""){
			window.alert("One or more fields are empty, please fill them out!");
		}
		//else if(Points ===0){
		//	window.alert("Points cannot be 0.");
		//}
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
               		        		DBStatus.innerHTML="Question Added to DB!";
					}
					else if(data['Response']=="INVALID"){
						DBStatus.innerHTML="invalid question. Please try again.";
					}
					else{
						DBStatus.innerHTML="Everything is wrong, what are you doing";
					}
           console.log(data);
   		  }
			}
      
			//resetting display back to teacher landing page
      /*
			if(cq.style.display === "none"){
				cq.style.display = "inline";
			}
			else{
				cq.style.display = "none";
			}
      
      */
			//checking and resetting variables
//			document.getElementById("check").innerHTML =Difficulty+"<br>"+Question+"<br>"+Answer+"<br>"+Points;
			document.getElementById("qtn").value = "";
			document.getElementById("func").value ="";
			document.getElementById("diff").value = "Easy";
		//closing else loop
		}
	}
</script>

<script>
  function addTestCase(){
    var div=document.createElement('div');
    
    div.className='row';
    
    div.innerHTML=
    '<input type="text" id="TestCase" name="TestCase" placeholder="Test Case(s)">\
    <input type="text" id="TCAns" name="TCAns" placeholder="Expected Answer">\
    <input type="button" value="Remove" onclick="removeTestCase(this)">\
    <p></p>';
    
    document.getElementById('TCA').appendChild(div);
    
  }
  
  function removeTestCase(input){
    document.getElementById("TCA").removeChild(input.parentNode);
  }
</script>

<script>
	function testFunc(str){
		var testq=document.getElementById("qtn").value;
		var testa=document.getElementById("func").value;
		document.getElementById("cpyq").innerHTML=testq;
		document.getElementById("cpya").innerHTML=testa;
	}
</script>

<script type="text/javascript">
  //var temp;
  var questHTML;
  var questArray=[];
  var len;
  var qIDArr=[];
  var tempIDArr=[];
  
	function makeExam(){
 
    //TESTING SESSION
    var testing="<?php echo $_SESSION['username']; ?>";
    console.log(testing);
    //TESTING SESSION
 
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
		questHTML="<div>";
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
      chkOutput.innerHTML = "Selected question(s) added to exam!";
        chkbox.checked=false;
        //qIDArr.push({Id:j});
        qIDArr.push(j);
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
    var rel=document.getElementById("pubStat");
    var PSUrl="pubScore.php";
    
    var ajReq = new XMLHttpRequest();
    
    ajReq.onreadystatechange=function(){
      if(ajReq.readyState==4){
        var ajRes=ajReq.responseText;
        var ajResData=JSON.parse(ajRes);
        
        console.log(ajResData);
        
        if(ajResData['Response']=="Released"){
          window.alert("Scores Released!");
        }
        else if(ajResData['Response']=="Not Released"){
          window.alert("Something went wrong, please refresh the page and try again!");
        }
        else{
          //hopefully never get here
          window.alert("Everything is wrong, why are you like this?");
        }
      }
    }
    
		var ps=document.getElementById("pScore");
		if(ps.style.display ==="none"){
			ps.style.display = "inline";
//      var pEx=document.getElementById("pubStat").innerHTML="Scores Released!";
		}
		else{
			ps.style.display = "none";
		}
   
   ajReq.open("POST",PSUrl,true);
   ajReq.send(null);
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

