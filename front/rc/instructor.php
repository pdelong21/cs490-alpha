<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
<style>
  body{
     background-color: lightblue;   
   }
   h1{
     text-align: center;   
   }
   h2{
     text-align: center;   
   }
   
   p{
     text-align: center;   
   }
   
   table{
     text-align; center;
   }
   div{
     text-align: center;
   }
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
    		background-color: lightblue;
	}

	.right {
    		right: 0;
    		background-color: lightblue;
	}

	.centered {
    		position: absolute;
    		top: 50%;
    		left: 50%;
    		transform: translate(-50%, -50%);
    		text-align: center;
	}
 ul{
   list-style-type: none;
   margin: 0;
   padding: 0;
   overflow: hidden;
   text-align: center;
   
   background-color: #f2f2f2;
   
 }
 li {
   display:inline-block;
   
    border-right: 1px solid #bbb;
  }
  li:last-child{
    border-right:none;
  }
  li a {
    display: block;
    color: #111;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  li a:hover:not(.active) {
    background-color: #ddd;
  }
 
</style>
</head>
<body>
	<!-- Make Buttons to make an exam, publish score(s), and log out respectively -->
  <!-- <div class"topnav"> -->
  <ul>
    
    <li><a href="#" onclick="makeQuestion();showQB()">Make a Question</a></li>
    <li><a href="#" onclick="makeExam()">Make an Exam</a></li>
    <li><a href="#" onclick="evalEx()">Evaluate Exam</a></li>
    <li><a href="#" onclick="logOut()">Log Out</a></li>
  </ul>
  <!-- </div> -->
  
  <h1>Welcome Professor</h1>  
	
	<!-- Make Question -->
	<!-- Split Screen to make a question on the left side of the screen, and view similar questions on the right -->
	<div id="sScreen" style="display:none;">
		<!-- Split Screen Left side -->
		<div id="l" class ="split left">
			<h2><b>Create a question</b></h2>
			
			<!-- Difficulty Settings for Easy/Medium/Hard -->	
			
			<p>Select Difficulty:</p>
			<p><select name="pdiff" id="diff">
				<option value="Easy">Easy</option>
				<option value="Medium">Medium</option>
				<option value="Hard">Hard</option>
			</select></p>
      
			<!-- Type a Question/answer to the question to POST to mid -->
			<p>Enter a Question:</p>
			<p><textarea rows="10" cols="50" name="pqtn" id="qtn"></textarea></p><br>
			<p>Enter the function name:</p>
			<p><textarea rows="1" cols="25" name="pfunc" id="func"></textarea></p><br>
      <p>Select the amount of test case(s) and answer(s):</p>
      <p></p>
      <p><select id="mySel" onchange="myFunc()">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select></p>
      <p></p>
      <div>
        <div id="f1">
          <p><input type="text" id="T1" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA1" name="TCAns" placeholder="Expected Answer"></p>
          <p></p>
        </div>
        <div id="f2" style="display:none">
          <p><input type="text" id="T2" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA2" name="TCAns" placeholder="Expected Answer"></p>
          <p></p>
        </div>
        <div id="f3" style="display:none">
          <p><input type="text" id="T3" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA3" name="TCAns" placeholder="Expected Answer"></p>
          <p></p>
        </div>
        <div id="f4" style="display:none">
          <p><input type="text" id="T4" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA4" name="TCAns" placeholder="Expected Answer"></p>
          <p></p>
        </div>
        <div id="f5" style="display:none">
          <p><input type="text" id="T5" name="TestCase" placeholder="Test Case(s)">
          <input type="text" id="EA5" name="TCAns" placeholder="Expected Answer"></p>
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
			<p><button onclick="createQuestion();showQB()">Create Question</button>
	                <button onclick="goBack()">Back</button></p>
      <p id="stat"></p>
      <p id="DBStat"></p>
		</div>
		
		<!-- Split Screen Right side -->
		<div id="r" class="split right">
			<h2><b>Question Bank</b></h2>
			<p>This is still a work in progress (WIP)</p>
      <button onclick="showQB()">Update Question Bank</button>
      <p></p>
      <div id="qBank"></div>
			<!-- <p><span id="cpyq"></span></p> -->
			<!-- <p><span id="cpya"></span></p> -->
		</div>
	</div>

	<div id="genExam" style="display:none;">
		<h2>Select Questions:</h2>
		<div id="examQuestions"></div>
    <p id="exQ"></p>
    <p id="tempResp"></p>
    <p id="DBResp"></p>
	</div>
 
 <!-- Evaluate -->
 <div id="EE" style="display:none">
   <!-- <table align='center' >
     <tr>
       <th>Student</th>
       <th>Evaluate</th>
     </tr>
     <tbody id="evStat"></tbody>
   </table> -->
   <p id="evStat"></p>
   <p id="evTest"></p>
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

<script>
  function showQB(){
    var qb = new XMLHttpRequest();
    var vQuestion = "viewQuestion.php";
    var qArray=[];
    
    qb.onreadystatechange=function(){
      if(qb.readyState ==4){
        var QBQ=document.getElementById("qBank");
        var resText=qb.responseText;
        var resData=JSON.parse(resText);
        var len=resData.length;
        var qbHTML="<div>";
        qbHTML+="<table id='qbQuest' align='center' border='1px solid black'>";
        qbHTML+="<tr><th>Question</th>";
        qbHTML+="<th>Difficulty</th></tr>";
        for(var q=0;q<len;q++){
          qbHTML+="<tr>";
          qbHTML+="<td>"+resData[q]['Question']+"</td>";
			    qbHTML+="<td>"+resData[q]['Difficulty']+"</td>";
          qbHTML+="</tr>";
        }
        qbHTML+="</table></div>";
        QBQ.innerHTML=qbHTML;
      }
    }
    qb.open("POST",vQuestion,true);
	  qb.send(null);
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
		questHTML+="<table id='tbl' align='center' border= '1px solid black'>";
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
    questHTML+='<p><input type="button"onclick="addToExam()"';
    questHTML+='value="Add to Exam"></input></p>';
    
    //
    //questHTML+='<p id="tempResp"></p>';
    //questHTML+='<p id="DBResp"></p>';
		//
    
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
      var tempResponse=document.getElementById("tempResp");
              //chkOutput.innerHTML="";
      tempResponse.innerHTML="";
      
      var tempRespText=document.getElementById("DBResp");
      tempRespText.innerHTML="";
      
      var prefix="qPts";
    
      if(chkbox.checked){      
        //chkOutput.innerHTML = "Selected question(s) added to exam!";
        
        var selPts=document.getElementById(prefix + j).value;
        
        //console.log(selPts);
        //qIDArr.push({Id:j});
        if(selPts==null||selPts==""){
          chkOutput.innerHTML="One or more fields are missing Points!";
          qIDArr=[];
          break;
        }
//        else{
          qIDArr.push(j);
          qIDArr.push(selPts);
        
          //console.log(qIDArr);
          toSendArr.push(qIDArr);
          //chkbox.checked=false;
          qIDArr=[];
//        }
        
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
    //console.log(toSendArr);
    var sendList=toSendArr;
    var toPost=JSON.stringify(sendList);
    
    console.log(sendList);
    
    if(toPost=="[]")
    {
      chkOutput.innerHTML="No questions selected!";
      
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
              
              //var tempResp=document.getElementById("tempRes");
              //var tempRespText=document.getElementById("DBResp");
	
					if(data['Response']=="Test Created"){
            //tempResponse.innerHTML="Test Created!";
            tempResponse.innerHTML="Test Created!";
					}
					else if(data['Response']=="INVALID"){
						//tempResponse.innerHTML="Error.";
            tempResponse.innerHTML="Error!";
					}
					else{
						//tempResponse.innerHTML="Everything is wrong, what are you doing";
            tempResp.innerHTML="Something went wrong, please try again!";
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
  var tempUsr="";
  var usrArr=[];
  var temp="";
  function evalEx(){
  
  var ee=document.getElementById("EE");
		if(ee.style.display ==="none"){
			ee.style.display = "inline";
		}
		else{
			ee.style.display = "none";
		}
   
     var ev=document.getElementById("evStat");
     var evUrl = "stdEval.php";
     var evReq = new XMLHttpRequest();
     
     
     evReq.open("POST", evUrl, true);
     evReq.send();
     
     evReq.onreadystatechange=function(){
       if(evReq.readyState==4){
         var evRes=evReq.responseText;
         var evResData=JSON.parse(evRes);
         
         //console.log(evRes);
         //console.log(evResData);
         
         var evHTML="<div>";
         evHTML+="<table id='tbl' align='center' border= '1px solid black'>";
         evHTML+="<tr><th>Evaluate</th>";
         evHTML+="<th>Name</th>";
         evHTML+="</tr>";
         for(var i=0;i<evResData.length;i++){
           var stdUsrName=evResData[i].Username;
           tempUsr=stdUsrName;
         
           evHTML+="<tr>";
           //evHTML+="<td>"+stdUsrName+"</td>";
           evHTML+='<td><input type="checkbox" name="stds" id="std'+i;
           evHTML+='"></td>';
           evHTML+='<td id="cStd" name="names">'+stdUsrName+'</td>';
           //console.log(document.getElementById("cStd"));
           evHTML+="</tr>";
           //console.log(document.getElementById("cStd"));
         }
         evHTML+="</table></div>";
         evHTML+='<p><input type="button" onclick="getEx()"';
         evHTML+='value="Evaluate Student"></input></p>';
         ev.innerHTML=evHTML;
       }
     }
     //evReq.open("POST", evUrl, true);
     //evReq.send(null);
     //console.log(document.getElementById("cStd"));
  }
  
  function getEx(){
    var exReq = new XMLHttpRequest();
    var exUrl="getExam.php";
    //var exUrl="getExHardcode.php";
    var test=document.getElementById("evTest");
    test.innerHTML="";
    var arr=[];
    
    var pref="cStd";
    //console.log(document.getElementById(pref).innerHTML);
    
    exReq.onreadystatechange=function(){
      if(exReq.readyState==4){
        var exData=exReq.responseText;
        var exRes=JSON.parse(JSON.stringify(exData));
        
        console.log(exData);
        console.log(exRes);
        test.innerHTML+=JSON.stringify(exData);
      }     
    }
    
        //var arr=[];
        var cb=document.getElementsByName("stds");
        var nms=document.getElementsByName("names");
        
        //var cs=document.getElementById("cStd").innerHTML;
        //console.log(cs);
        //console.log(cb);
        for (var j=0;j<cb.length;j++){
          if(cb[j].checked){
          var qwe=nms[j].innerHTML;
          console.log(qwe);
          var cs=document.getElementById(pref).innerHTML;
          //console.log(cs);
            
            var stdName=cb[j].id;
            temp=stdName;
            
            //console.log(temp);
            //var stdName=cb[j].value;
            //console.log(stdName);
            //arr.push({"Username":stdName});
            arr.push({"Username":qwe});
            //arr.push(stdName);
            
          }
        }
      
    //  }
    //}
      
      exReq.open("POST", exUrl, true);
      
      //displays just "{\"Username\":\"std1\"}"
      //exReq.send(JSON.stringify({'Username':document.getElementById(pref).innerHTML}));
      //console.log(JSON.stringify({'Username':document.getElementById(pref).innerHTML}));
      
      //doesn't work
      //exReq.send(arr);
      //console.log(arr);
      
      /*displays "0 results[{\"Username\":\"std1\"}]", "0 results[{\"Username\":\"std2\"}]"
      or "0 results[{\"Username\":\"std1\"},{\"Username\":\"std2\"}]"
      depending on which student was clicked, or both
      */
      exReq.send(JSON.stringify(arr));
      console.log(arr);
      console.log(JSON.stringify(arr));
      
      //exReq.send(temp);
      //console.log(temp);
    
    //test.innerHTML=JSON.stringify(arr);
    //test.innerHTML=tempUsr;
    //test.innerHTML=x.cellIndex;
  }

	function pubScore(){
    var rel=document.getElementById("pubStat");
    var PSUrl="pubScore.php";
    var ajReq = new XMLHttpRequest();
  
    ajReq.onreadystatechange=function(){
      if(ajReq.readyState==4){
        var ajRes=ajReq.responseText;
        var ajResData=JSON.parse(ajRes);
        
        console.log(ajRes);
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

