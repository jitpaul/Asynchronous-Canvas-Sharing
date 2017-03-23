<!DOCTYPE html>
<?php 

    
    session_start();
    
    $name=$_SESSION['name'];  
    $sessionid=$_SESSION['sessionid'];
    if (!(isset($_COOKIE["user"])))
    {   
       setcookie("user", "a", 0);
    } 
    
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Box</title>


<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />

<script type="text/javascript"  src="js/jquery.min.js"></script>
<script type="text/javascript"  src="js/jquery.tinyscrollbar.min.js"></script>

<script src="jquery-1.3.js" type="text/javascript"></script>
<script src="fnctns.js" type="text/javascript"></script>
<script src="base64.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="ajaj.css" />


</head>

<body >

<span id="dummy"></span>

<div id="chatTopBar" class="rounded"><?php echo "<p style=\"font-size:25px;text-indent:1150px;\"><b>Welcome   ".$_SESSION['name']."</b>";?><a id="logout" href="logout.php" onClick=DeleteCookie("IsRefresh"); title="logout" ><img src="img/logout.png" align="bottom" width="28" height="28" /></a></p></div>

<table>
<tr>
<td>
<div id="draw">
<table width="70%" style="border-collapse:collapse;">
<tr>
<td width="10%">

<div id="toolpanel">

<button id="undoer">undo</button>
<button id="redoer">redo</button><br />
<button id="clearer">Reset</button><br /><br />

Stroke Color:
<div id="colorpanel" style="cursor: pointer;">
<table>
<tr>
<td><div class="boxed" title="black" style="background-color: black">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
<td><div class="boxed" title="red" style="background-color: red">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
<td><div class="boxed" title="green" style="background-color: green;">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
<td><div class="boxed" title="blue" style="background-color: blue">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
</tr>
<tr>
<td><div class="boxed" title="grey" style="background-color: grey">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
<td><div class="boxed" title="magenta" style="background-color: magenta">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
<td><div class="boxed" title="yellow" style="background-color: yellow;">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
<td><div class="boxed" title="cyan" style="background-color: cyan">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
</tr>
</table>
</div>

Stroke Width: <select onChange="width_stroke(this.options[this.selectedIndex].value )" id="strokewidth">
      <option value="1px">1px</option>
      <option value="2px">2px</option>
      <option value="3px">3px</option>
      <option value="5px">5px</option>
      <option value="10px">10px</option>
</select><br /><br />
<table>
<tr><td>
<button id="path" class="select_tool">Pencil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#10000;</button><br />
</td></tr>
 <tr><td>
<button id="line" class="select_tool">Line&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#9644;</button><br />
</td></tr>
 <tr><td>
<button id="rect" class="select_tool">Rectangle&nbsp;&#9645;</button><br />
</td></tr>
 <tr><td>
<button id="ellipse" class="select_tool">Circle&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#9711;</button><br />
</td></tr>
 <tr><td>
<button id="freehandcircle" class="select_tool">Ellipse&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button><br /><br />
</td></tr>
 <tr><td>
<button id="whitener" class="select_tool">Whitener</button><br /><br />
</td></tr>
 <tr><td>
<button id="dler">Download</button><br />
</td></tr>
</table>
</div>
</td>

<td id="main-td" width="60%"><!--style="border-top: thin solid black; border-bottom: thin solid black; border-left: thin solid black; border-right: thin solid black;"-->

<div id="main_thingy">
<embed src="plainboard.svg" type="image/svg+xml" width="757px" height="500px"/>
</div>

</td>
<!-- waste space the cell below -->
</tr></table>
<span id="curr_tool">Current tool: Pencil</span>&nbsp;&nbsp;&nbsp;&nbsp;
<span id="tool_track"></span>

</div>

</td>
<td>
<div id="chatContainer">



    

    <div id="chatLineHolder" class="scroll-pane">
    <input type="checkbox" id="isSound" /> sound...
     
    </div>

    
    <div id="chatBottomBar" class="rounded">
        <div class="tip"></div>

        

        <form id="submitForm" method="post" action="" onSubmit="JavaScript:disableRefreshDetection()">
            <input id="chatText" size="40" name="chatText" class="rounded" maxlength="150" />
            <input type="submit" id="submitmsg" class="blueButton" value="Submit" />
        </form>

    </div>

</div>






</td>
<td>
<div id="chatUsers" class="rounded"></div>
</td>
</tr>
</table>



<script type="text/javascript">


//document.cookie="user";

$("#submitmsg").click(function(){  
    var clientmsg = $("#chatText").val();  
    $.post("post.php", {text: clientmsg});  
    $("#chatText").attr("value", "");  
    return false;  
}); 


 
 $(document).ready(function()
		{
			username("<?php echo $name; ?>");
			setTimeout("beginner()",1000);
			clearit();
			undoit();
			redoit();
			toolselector();
			downloader();
			hist();
			server_query();
			colorer();
			width_stroke_init();
			hovering();
			
		});
 

 var soundfile = "chat.wav";
 function playSound() 
 {
   if (document.getElementById('isSound').checked===true) 
   {
    document.getElementById("dummy").innerHTML="<embed src=\""+soundfile+"\" hidden=\"true\" type=\"application/x-mplayer2\"  autostart=\"true\" loop=\"false\" />";
   }
 }
 
 
 function ValidURL(str) 
 {
  
   if(new RegExp("[a-zA-Z\d]+://(\w+:\w+@)?([a-zA-Z\d.-]+\.[A-Za-z]{2,4})(:\d+)?(/.*)?").test(str))
   {
     return true;
   } 
   else 
   {
     return false;
   }
 }





 
  var lastid = 0;
  var lusers=0;
  var lname="";
  var j=-1;
  function strt() 
  {
    
    $.ajax({                                      
      url: 'ajaxphp.php?id='+lastid,                         
      data: "",                                                             
      dataType: 'json',  
      error:function (xhr, ajaxOptions, thrownError){
                    //alert('Please login again');
                    //window.location="logout.php";
                }    ,             
     success: function(data)          
      {
        if(data!="")
        {
        var name = data[0];              
        var text = data[1];           
        var time = data[2];
        var id   = data[3];
        var texttype=data[4];
        var session_name = "<?php echo $name; ?>";
      
          if(texttype==2 && id>lastid)
          {
            
           
                playSound();
                if(ValidURL(text)) 
                {          
                    $('#chatLineHolder').append("<br/><table class=\"all\"><tr ><td></td><td><b>" + name + ": </b></td><td style=\"max-width:150px;font-style:italic;padding:5px;\">" + text.link(text) + "</td><td class=\"alt\">(" + time + ")</td><td></td></tr></table>");
                }
                else
                {            
                    $('#chatLineHolder').append("<br/><table class=\"all\"> <tr ><td></td><td><b>" + name + ": </b></td><td style=\"max-width:150px;font-style:italic\">" + text + "</td><td class=\"alt\">(" + time + ")</td><td></td></tr></table>");
                    // $('#chatLineHolder').append("<table class=\"all\"><tr ><td><b>" + name + ": </b></td><td style=\"max-width:150px;font-style:italic\">" + text + "</td><td class=\"alt\">(" + time + ")</td></tr></table>"); 
                }
               
                lastid=id;
                
               

           
          }
          else if(texttype==0 && name!="" && name!=session_name && id>lastid)
          {
                $('#chatLineHolder').append("<table><tr ><td style=\"max-width:150px;font-style:italic\">" + name + " <i>has logged out</i></td></tr></table>");
                lastid=id;
          }
          else if(texttype==1 && name!="" && name!=session_name && id>lastid)
          {
         
                $('#chatLineHolder').append("<table><tr ><td style=\"max-width:150px;font-style:italic\">" + name + " <i>has logged in</i></td></tr></table>");
                lastid=id;      
          }
          
          
          else if(name!=lname && texttype!=0 && texttype!=1 && texttype!=2)
          {
                var a = name.slice(10);
                $('#chatLineHolder').append("<table><tr ><td><i>Last message sent at</i>" + a + " </td></tr></table>"); 
                lname=name;
                
          }      
          else 
          {
             if(name!=lname){lastid=id;}
          } 
            
      // $('#chatLineHolder').tinyscrollbar_update();
          
       }
        
       window.setTimeout( strt, 1000 );
      
      } 
    });
  }
  $(document).ready(strt);
  
  
  
  function usrs() 
  {
    
    $.ajax({                                      
      url: 'onlineusers.php?noof='+lusers,                         
      data: "",                                                             
      dataType: 'json',                
      success: function(data)          
      { 
        var string='<table style=\"width:100%\">';
        var i=0;
        while(data.user[i])
        {
                      
                      string=string+'<tr><td><img src=\"img/chat.png\" width="18" height="18"/></td><td style=\"color:white;\">'+data.user[i]+'</td></tr>';
                      i++;
        }    
                      string=string+'</table>';   
                                  
        $('#chatUsers').html(string);  
        lusers=data.noof;
        window.setTimeout( usrs, 10 );
      
      } 
    });
  }
  $(document).ready(usrs);
  
  
  

 
  
 //$(document).ready(function(){				
//		$('#chatLineHolder').tinyscrollbar();
		
//	}); 
 

   


  </script>

</body>
</html>
