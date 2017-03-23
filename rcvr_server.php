<?php
	
	session_start();
    $name=$_SESSION['name'];  
    $sessionid=$_SESSION['sessionid']; 
    session_write_close(); 
 
    
    
	set_time_limit (1000);
	
	$data1 = $_POST['var1']; 
	$caller=$_POST['var2'];
	$shape=$_POST['var3'];
    $number=$_POST['var4'];
    $file=$sessionid.'_file';


	
    $connection = mysql_connect("localhost","root","") or die('unable to connect');   
    mysql_select_db("chat", $connection) or die('unable to select database');
	mysql_query("DELETE FROM redotable WHERE sessionid='$sessionid' "); 
    	
	if($data1 != '')
	{
	  switch($caller)
	  {	
		case "create":
				mysql_query("INSERT INTO `$file` (name,data,shape,number,flag) VALUES ('$name', '$data1','$shape',$number,1)");
				break;
		
		case "finish":		
		case "modify":
                mysql_query("DELETE FROM `$file` WHERE name='$name' AND shape='$shape' AND number='$number'"); 
				mysql_query("INSERT INTO `$file` (name,data,shape,number,flag) VALUES ('$name', '$data1','$shape',$number,1)");
				break;
       				
	  }

	
   }
   else
   {
		echo "1";
   }
	
	
	flush();
?>
