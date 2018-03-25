<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<h1>WELCOME STUDENT</h1>	
</head>
<body>
	<p><button onclick="takeExam()">Take Exam</button></p>
	<p><button onclick="viewScore()">View Score</button></p>
	<p><button onclick="logOut()">Log Out</button></p>
	<div id="exam" style="display:none;">
		<div id="dispExam">
      
		</div>
	</div>
	<p id="exStatus"></p>
	<div id="vScore" style="display:none;">
		<p id="showGrade"></p>
	</div>
</body>
</html>

<script type="text/javascript">
  var ansArr=[];
  var tempArr=[];
  var exHTML="";
  var maxPts="";
  var ansStr="";
  var tCaseStr="";
  var toSend=[];
  var currAns=[];
  var usr="<?php echo $_SESSION['username']; ?>";
  
  
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
      
        //TESTING SESSIONS
         var testing="<?php echo $_SESSION['username']; ?>";
         //console.log(testing);
         //TESTING SESSIONS\
      
				var exDisp=document.getElementById("dispExam");
				var resText=aReq.responseText;
				//console.log(resText);
        
        var resData=JSON.parse(resText);
        var len=resData.length;
        //console.log(len);
        //console.log(resData);
        
        var stdName=testing;
        tempArr.push(stdName);
        
        var IDStr="";
        var ptStr="";
        
        var asdf=[];
        var fdsa="";
        
        exHTML ="<p>Exam</p>";
        for(var i=0;i<len;i++){
          ansArr.push(resData[i]['QuestionId']);
          //tempArr.push(resData[i]['QuestionId']);
          
          var qID=resData[i]['QuestionId'];
          var qtn=resData[i]['Question'];
          var pts=resData[i]['Points'];
          var tCases=resData[i]['TestCases'];
//          console.log(qID);
//          console.log(qtn);
//          console.log(pts);
//          console.log(tCases);
          
          if(typeof qID !== "undefined"){
            IDStr+=qID+"| ";
          }
          if(typeof pts !== "undefined"){
            ptStr+=pts+"| ";
          }
          if(typeof tCases !== "undefined"){
            tCaseStr+="Test Cases: "+tCases+"// ";
          }
          
          exHTML+='<p>Question '+(i+1)+':</p>';
          exHTML+='<p>'+qtn+'</p>';
          exHTML+='<p>Points: '+pts+'</p>';
          exHTML+='<p>Enter your answer:</p>';
          exHTML+='<textarea rows="10" cols="80" name="'+qID+'" id="'+qID+'">';
          exHTML+='</textarea>';
          
          //asdf[i]=document.getElementById(qID).value;          
        }
        
        //console.log(asdf);
        //console.log(IDStr);
        //console.log(ptStr);
        
        //console.log(resData);
        tempArr.push(IDStr);
        maxPts=ptStr;
        //console.log(maxPts);
        exHTML+='<p>';
        exHTML+='<input type="button" value="Submit" onclick="submitEx();"></input>';
        exHTML+='</p>';
        //console.log(exHTML);
        exDisp.innerHTML=exHTML;
        
        //tempArr.push(ansStr);
        tempArr.push(maxPts);
        tempArr.push(tCaseStr);
        
			}
		}
   
   //var posting=["asdas","asdfaesf"];
       
   var ex = document.getElementById("exam");
		if(ex.style.display === "none"){
			ex.style.display = "inline";
		}
		else{
			ex.style.display = "none";
		}
   
   //console.log(ansArr);
   
   aReq.open("POST",exUrl,true);
   
   //aReq.send(JSON.stringify(posting));
   //aReq.send(currAns);
   //aReq.send(null);
   aReq.send(JSON.stringify(currAns));
   //console.log(currAns);
	}

  function submitEx(){
    var bReq=new XMLHttpRequest();
    var stdAns=[];
    var grUrl="gradeEx.php";
    //var currAns=[];
    
    var len2=ansArr.length;
    
    bReq.onreadystatechange=function(){
      if(bReq.readyState==4){
        var getEx=document.getElementById("exam");
        var bRes=bReq.responseText;
        
        console.log(bRes);
        //console.log(getEx);
        
        //var curAns="";
        //var currAns=[];
        
        /*
        
        var len2=ansArr.length;
        //console.log(len2);
        
        
        for(var i=0;i<len2;i++){
          //currAns=document.getElementById(ansArr[i]).value;
          currAns[i]=document.getElementById(ansArr[i]).value;
          
          //if(typeof currAns !== "undefined"){
          //  ansStr+=currAns+"| ";
          //}
          //console.log(currAns);
          //stdAns.push(currAns);
          //console.log(stdAns[i]);
        }
        //console.log(ansStr);
        //stdAns.push(currAns);
        
        
        console.log(currAns);
        
        */
        //console.log(ansStr);
        //console.log(maxPts);
        //console.log(tCaseStr);
        
        //tempArr.push(ansStr);
        //tempArr.push(maxPts);
        //tempArr.push(tCaseStr);
        
        
      }
    }
    //console.log(tempArr.length);
    //console.log(ansArr);
    //console.log(stdAns);
    
    var sad="";
    currAns.push(usr);
    for(var q=0;q<len2;q++){
      var Ans=document.getElementById(ansArr[q]).value;
      
      currAns.push(Ans);
      
      sad+=Ans+"| ";
    }
    tempArr.push(sad);
    
    var se = document.getElementById("exam");
    var status=document.getElementById("exStatus");
    //console.log(se);
    //console.log(status);
		se.style.display="none";
   
   console.log(tempArr);
   
   //var a0=tempArr[0];
   //var a1=tempArr[1];
   //var a2=tempArr[2];
   //var a3=tempArr[3];
   //var a4=tempArr[4];
   //console.log(a0);
   //console.log(a1);
   //console.log(a2);
   //console.log(a3);
   //console.log(a4);
   
   //toSend.push({User:a0,qID:a1,Response:a2,Points:a3,Cases:a4});
   //console.log(toSend);
   
   var toSend=currAns;
   var sendThis=JSON.stringify(toSend);
   console.log(usr);
   
   bReq.open("POST",grUrl,true);
   
   //var qwer=JSON.stringify(currAns);
   //bReq.send(qwer);
   //bReq.send(currAns);
   bReq.send(JSON.stringify(currAns));
   console.log(currAns);
   //console.log(currAns);
   
   status.innerHTML="Exam Sent!";
  }
</script>

<script>
	function viewScore(){
   ajaReq = new XMLHttpRequest();
   var gGrade="getGrade.php";
   
   ajaReq.onreadystatechange=function(){
     if(ajaReq.readyState==4){
       var sGrade=document.getElementById("showGrade");
       var text=ajaReq.responseText;
       var prse=JSON.parse(text);
       var gLen=prse.length;
       console.log(prse);
       for(var i=0;i<gLen;i++){
         //gArr
       }
     }
   }
 
		var sc = document.getElementById("vScore");
		if(sc.style.display ==="none"){
			sc.style.display = "block";
		}
		else{
			sc.style.display = "none";
		}
   ajaReq.open("POST",gGrade,true);
   ajaReq.send(null);
	}
</script>

<script>
	function logOut(){
		var win=window.open("login.php","_self");
	}
</script>
