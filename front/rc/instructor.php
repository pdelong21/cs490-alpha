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
		<div id="l" class ="split left">
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
      <p>Select the amount of test case(s) and answer(s):</p>
      <p></p>
      <select id="mySel" onchange="myFunc()">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <p></p>
      <div>
        <div id="f1">
          <input type="text" id="T1" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA1" name="TCAns" placeholder="Expected Answer">
          <p></p>
        </div>
        <div id="f2" style="display:none">
          <input type="text" id="T2" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA2" name="TCAns" placeholder="Expected Answer">
          <p></p>
        </div>
        <div id="f3" style="display:none">
          <input type="text" id="T3" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA3" name="TCAns" placeholder="Expected Answer">
          <p></p>
        </div>
        <div id="f4" style="display:none">
          <input type="text" id="T4" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA4" name="TCAns" placeholder="Expected Answer">
          <p></p>
        </div>
        <div id="f5" style="display:none">
          <input type="text" id="T5" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA5" name="TCAns" placeholder="Expected Answer">
          <p></p>
        </div>
      </div>
      
      <!--
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
      -->
      <p></p>
      <!-- <div id="TCA"></div> -->
      <p id="tempRes"></p>
      <p id="tempResText"></p>
      <p></p>
			<p><button onclick="createQuestion()">Create Question</button>
	                <button onclick="goBack()">Back</button></p>
      <p id="stat"></p>
      <p id="DBStat"></p>
		</div>
		
		<!-- Split Screen Right side -->
		<div id="r" class="split right">
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
 
 <p id="tempResp"></p>
 
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
    
    DBStatus.innerHTML="";
    
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
        
    var sel=document.getElementById("mySel").value;
    /*
    var TC1=document.getElementById("TC1").value;
    var ExA1=document.getElementById("ExA1").value;
    var TC2=document.getElementById("TC2").value;
    var ExA2=document.getElementById("ExA2").value;
    var TC3=document.getElementById("TC3").value;
    var ExA3=document.getElementById("ExA3").value;
    var TC4=document.getElementById("TC4").value;
    var ExA4=document.getElementById("ExA4").value;
    var TC5=document.getElementById("TC5").value;
    var ExA5=document.getElementById("ExA5").value;
    */
    
    //it's early in the morning, and my brain's not really working right now
//    if(TC1==""&&ExA1==""||TC2==""&&ExA2==""||TC3==""&&ExA3==""||TC4==""&&ExA4==""||TC5==""&&ExA5=="")
//    {
//      document.getElementById("stat").innerHTML="Please enter at least one test case and answer!";
//    }
//    else{
//      if(TC1==""||ExA1==""){
//        document.getElementById("stat").innerHTML="One or more fields are empty, please fill them out!";
//      }
//      else{
      var TC1=document.getElementById("T1").value;
      var ExA1=document.getElementById("EA1").value;
      tcaArr1.push(TC1);
      tcaArr1.push(ExA1);
//      }

//      if(TC2==""||ExA2==""){
//        document.getElementById("stat").innerHTML="One or more fields are empty, please fill them out!";
//      }
//      else{
        var TC2=document.getElementById("T2").value;
        var ExA2=document.getElementById("EA2").value;
        tcaArr2.push(TC2);
        tcaArr2.push(ExA2);
//      }
    
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
//    }
    
    //console.log(tcaArr1);
    //console.log(tcaArr2);
    //console.log(tcaArr3);
    //console.log(tcaArr4);
    //console.log(tcaArr5);
    
    if(sel==="1")
    {
    pArr.push(tcaArr1);
    }
    else if(sel==="2")
    {
    pArr.push(tcaArr1);
    pArr.push(tcaArr2);
    }
    else if(sel==="3")
    {
    pArr.push(tcaArr1);
    pArr.push(tcaArr2);
    pArr.push(tcaArr3);
    
    }
    else if(sel==="4")
    {
    pArr.push(tcaArr1);
    pArr.push(tcaArr2);
    pArr.push(tcaArr3);
    pArr.push(tcaArr4);
    }
    else if(sel==="5")
    {
    pArr.push(tcaArr1);
    pArr.push(tcaArr2);
    pArr.push(tcaArr3);
    pArr.push(tcaArr4);
    pArr.push(tcaArr5);
    }
    
    
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
			document.getElementById("stat").innerHTML="One or more fields are empty, please fill them out!";
		}
//   else if(TC1==""&&ExA1==""||TC2==""&&ExA2==""||TC3==""&&ExA3==""||TC4==""&&ExA4==""||TC5==""&&ExA5==""){
//     document.getElementById("stat").innerHTML="one or more test cases and answers are empty, pelase fill them out!";
//   }
   else if(sel==="1" &&(TC1===""||ExA1==="")){
//     if(TC1===""||ExA1===""){
       document.getElementById("stat").innerHTML="one or more test cases and answers are empty, pelase fill them out!";
//       }
       
   }
   else if(sel==="2" && (TC1===""||ExA1===""||TC2===""||ExA2==="")){
//     if(TC1===""||ExA1===""||TC2===""||ExA2===""){
       document.getElementById("stat").innerHTML="one or more test cases and answers are empty, pelase fill them out!";
//     }
   }
   else if(sel==="3" && (TC1===""||ExA1===""||TC2===""||ExA2===""||TC3===""||ExA3==="")){
//     if(TC1===""||ExA1===""||TC2===""||ExA2===""||TC3===""||ExA3===""){
       document.getElementById("stat").innerHTML="one or more test cases and answers are empty, pelase fill them out!";
//     }
   }
   else if(sel==="4" && (TC1===""||ExA1===""||TC2===""||ExA2===""||TC3===""||ExA3===""||TC4===""||ExA4==="")){
//     if(TC1===""||ExA1===""||TC2===""||ExA2===""||TC3===""||ExA3===""||TC4===""||ExA4===""){
       document.getElementById("stat").innerHTML="one or more test cases and answers are empty, pelase fill them out!";
//     }
   }
   else if(sel==="5" && (TC1===""||ExA1===""||TC2===""||ExA2===""||TC3===""||ExA3===""||TC4===""||ExA4===""||TC5===""||ExA5==="")){
//     if(TC1===""||ExA1===""||TC2===""||ExA2===""||TC3===""||ExA3===""||TC4===""||ExA4===""||TC5===""||ExA5===""){
       document.getElementById("stat").innerHTML="one or more test cases and answers are empty, pelase fill them out!";
//     }
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
              
              var tempResp=document.getElementById("tempRes");
              var tempRespText=document.getElementById("tempResText");
	
					if(data['Response']=="Successfully Inserted"){
               		        		DBStatus.innerHTML="Question Added to Question Bank!";
					}
					else if(data['Response']=="INVALID"){
						DBStatus.innerHTML="invalid question. Please try again.";
					}
					else{
						DBStatus.innerHTML="Everything is wrong, what are you doing";
					}
           console.log(data);
           console.log(return_data);
           //tempResp.innerHTML=data;
           //tempRespText.innerHTML=return_data;
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
      
      //document.getElementById("l").reload();
//			document.getElementById("check").innerHTML =Difficulty+"<br>"+Question+"<br>"+Answer+"<br>"+Points;
			document.getElementById("qtn").value = "";
			document.getElementById("func").value ="";
			document.getElementById("diff").value = "Easy";
      
      document.getElementById("T1").value="";
      document.getElementById("EA1").value="";
      document.getElementById("T2").value="";
      document.getElementById("EA2").value="";
      document.getElementById("T3").value="";
      document.getElementById("EA3").value="";
      document.getElementById("T4").value="";
      document.getElementById("EA4").value="";
      document.getElementById("T5").value="";
      document.getElementById("EA5").value="";
		//closing else loop
		}
	}
</script>

<script>
  function myFunc(){
    var xyz=document.getElementById("mySel").value;
    if(xyz==="1")
    {
      document.getElementById("f1").style.display="inline";
      document.getElementById("f2").style.display="none";
      document.getElementById("f3").style.display="none";
      document.getElementById("f4").style.display="none";
      document.getElementById("f5").style.display="none";
      
      document.getElementById("T2").value="";
      document.getElementById("EA2").value="";
      document.getElementById("T3").value="";
      document.getElementById("EA3").value="";
      document.getElementById("T4").value="";
      document.getElementById("EA4").value="";
      document.getElementById("T5").value="";
      document.getElementById("EA5").value="";
      
      /*
      document.getElementById("TA1").reset();
      document.getElementById("EA1").reset();
      document.getElementById("TA2").reset();
      document.getElementById("EA2").reset();
      document.getElementById("TA3").reset();
      document.getElementById("EA3").reset();
      document.getElementById("TA4").reset();
      document.getElementById("EA4").reset();
      document.getElementById("TA5").reset();
      document.getElementById("EA5").reset();
      */
    }
    if(xyz==="2")
    {
      document.getElementById("f1").style.display="inline";
      document.getElementById("f2").style.display="inline";
      document.getElementById("f3").style.display="none";
      document.getElementById("f4").style.display="none";
      document.getElementById("f5").style.display="none";
      
      document.getElementById("T3").value="";
      document.getElementById("EA3").value="";
      document.getElementById("T4").value="";
      document.getElementById("EA4").value="";
      document.getElementById("T5").value="";
      document.getElementById("EA5").value="";
    }
    if(xyz==="3")
    {
      document.getElementById("f1").style.display="inline";
      document.getElementById("f2").style.display="inline";
      document.getElementById("f3").style.display="inline";
      document.getElementById("f4").style.display="none";
      document.getElementById("f5").style.display="none";
      
      document.getElementById("T4").value="";
      document.getElementById("EA4").value="";
      document.getElementById("T5").value="";
      document.getElementById("EA5").value="";
    }
    if(xyz==="4")
    {
      document.getElementById("f1").style.display="inline";
      document.getElementById("f2").style.display="inline";
      document.getElementById("f3").style.display="inline";
      document.getElementById("f4").style.display="inline";
      document.getElementById("f5").style.display="none";

      document.getElementById("T5").value="";
      document.getElementById("EA5").value="";
    }
    if(xyz==="5")
    {
      document.getElementById("f1").style.display="inline";
      document.getElementById("f2").style.display="inline";
      document.getElementById("f3").style.display="inline";
      document.getElementById("f4").style.display="inline";
      document.getElementById("f5").style.display="inline";
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
  var toSendArr=[];
  
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
      questHTML+='<td><input type="number" id="qPts'+i;
      questHTML+='"></td>';
			//questHTML+="<td>"+resData[i]['Points']+"</td>";
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
      //var selQuestions=document.getElementById("qPts"+j);
      //console.log(selQuestions);
      //console.log(chkbox);
      //console.log(questArray[j]);
      var chkOutput=document.getElementById("exQ");
      chkOutput.innerHTML="";
      var prefix="qPts";
    
      if(chkbox.checked){      
        //chkOutput.innerHTML = "Selected question(s) added to exam!";
        
        var selPts=document.getElementById(prefix + j).value;
        
        //console.log(selPts);
        //qIDArr.push({Id:j});
        if(selPts==null||selPts==""){
          chkOutput.innerHTML="One or more fields are missing Points!";
          break;
        }
        else{
          qIDArr.push(j);
          qIDArr.push(selPts);
        
          //console.log(qIDArr);
          toSendArr.push(qIDArr);
          //chkbox.checked=false;
          qIDArr=[];
        }
      }
//      else{
      //qIDArr[j]=0;
//        chkOutput.innerHTML = "Select at least one question to make an exam!";
//      }
      //qIDArr.push(j);
      //qIDArr.push(selPts);
      //toSendArr.push(qIDArr);
    }
    //console.log(qIDArr);
    //console.log(toSendArr);
    console.log(toSendArr);
    var sendList=toSendArr;
    var toPost=JSON.stringify(sendList);
    
    console.log(toPost);
    
    if(toPost==="[]")
    {
      chkOutput.innerHTML="Missing fields!";
      
      qIDArr=[];
      toSendArr=[];
    }
    else{
    
      aReq.open("POST", eUrl, true);
      aReq.send(toPost);
      
      aReq.onreadystatechange = function(){
				if(aReq.readyState==4 && aReq.status==200){
	        	                return_data=aReq.responseText;
					var data=JSON.parse(return_data);
              
              var tempResponse=document.getElementById("tempResp");
              tempResponse.innerHTML="";
              //var tempRespText=document.getElementById("tempResText");
	
					if(data['Response']=="Test Created"){
               		        		tempResponse.innerHTML="Test Created!";
					}
					else if(data['Response']=="INVALID"){
						tempResponse.innerHTML="Error.";
					}
					else{
						tempResponse.innerHTML="Everything is wrong, what are you doing";
					}
           console.log(data);
           console.log(return_data);
           //tempResp.innerHTML=data;
           //tempRespText.innerHTML=return_data;
   		  }
			}
      //chkOutput.innerHTML="Successfully created an exam!";
      //reset array. Lazy but works for now, i guess
      qIDArr=[];
      toSendArr=[];
    }
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

