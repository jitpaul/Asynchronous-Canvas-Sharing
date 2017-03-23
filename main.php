<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Box</title>

<link href="login-box.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />


<script type="text/javascript">
window.history.forward();
function noback()
{
    window.history.forward();
}
	
</script>
</head>

<body onload="noback();" onpageshow="if(event.persisted) noback();">

<?php

if (isset($_COOKIE["user"]))
{
 
 header("Location: sessionprogress.html");
 
  
}
?>

<table>
<tr>
<th>



<div id="ss1" style="padding: 90px 0 0 100px;">
<div id="login-box">
<div id="ex1">
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<input type="button" style=" font-style:italic; background: url(img/login-box-backg.png); font-size: 40px; font-weight: bold;" onclick="javascript:step3();" value="Begin Session"/>
</div>
</div>
</div>

<div id="ss2" style="padding: 90px 0 0 100px; display: none;">
<div id="login-box">
<H2>Start Session</H2>
<br />
<br />        
    
<form id="loginForm" method="post" action="IndexStartSession.php">      
<div id="login-box-name" style="margin-top:20px;">Session ID:</div><div id="login-box-field" style="margin-top:20px;"><input name="id" id="id" class="form-login" title="id" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Username:</div><div id="login-box-field"><input name="name" id="name"  class="form-login" title="name" value="" size="30" maxlength="2048" /></div>
<br />
<br />
<input type="submit" class="lbutton" value="Login" />


</form>
</div>
</div>



</th>
<th>


<div id="js1" style="padding: 90px 0 0 100px;">
<div id="login-box">
<br/>
<br/>
<br />
<br />
<br />
<br />
<br />
<input type="button" style=" font-style:italic; background: url(img/login-box-backg.png); font-size: 40px; font-weight: bold;" onclick="javascript:step2();" value="Join Session"/>
</div>
</div>

<div id="js2" style="padding: 90px 0 0 100px; display: none;">
<div id="login-box">
<H2>Join Session</H2>
<br />
<br />

<form id="loginForm" method="post" action="IndexJoinSession.php">  
<div id="login-box-name" style="margin-top:20px;">Session ID:</div><div id="login-box-field" style="margin-top:20px;"><input name="id" id="id" class="form-login" title="id" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Username:</div><div id="login-box-field"><input name="name" id="name" class="form-login" title="name" value="" size="30" maxlength="2048" /></div>
<br />
<br />
<input type="submit" class="lbutton" value="Login" />

<?php 
	 
	  
 


      
      
      
      $valid=$_GET['valid'];
      if(isset($valid))
      {
	    echo '<p style="color:black"></p>'; 
      }
     
      ?>
</form>
</div>
</div>



</th>
</tr>
</table>




<script type="text/javascript">


function checkSession()
{
 if (sessionExists=="true")
 {
 window.location="loggedin.php";
 }
 
}


function step2() {
        document.getElementById('js1').style.display = 'none';
        document.getElementById('js2').style.display = 'block';
        document.getElementById('ss1').style.display = 'block';
        document.getElementById('ss2').style.display = 'none';
}

function step3() {
        document.getElementById('ss1').style.display = 'none';
        document.getElementById('ss2').style.display = 'block';
        document.getElementById('js1').style.display = 'block';
        document.getElementById('js2').style.display = 'none';
}
</script>

<?php 
	 
	  $valid = $_GET['valid'];
      if($valid==1)
      {
       echo '<p style="color:black; font-size:30px;text-align:center;">Fields cannot be left blank.</p>';      
      }
      else if($valid==2)
      {
	    echo '<p style="color:black; font-size:30px;text-align:center;">Username already exists.Try a new username.</p>'; 
      }
      else if($valid==3)
      {
       echo '<p style="color:black; font-size:30px;text-align:center;">The entered Session-ID is not available.Try a new one.</p>'; 
      }
      else if($valid==4)
      {
           echo '<p style="color:black; font-size:30px;text-align:center;">The entered Session-ID does not exist.</p>'; 
       }
      
     
      
      
      ?>


</body>
</html>
