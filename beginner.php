<?php

	
	session_start();
    $name=$_SESSION['name'];  
    $sessionid=$_SESSION['sessionid'];  
	session_write_close();
	
	$file=$sessionid.'_file';
	$connection = mysql_connect("localhost","root","") or die('unable to connect');   
    mysql_select_db("chat", $connection) or die('unable to select database');
	
	

	
	$content='';
	
	 $result=mysql_query("SELECT name,data,dataid FROM `$file`");
	  if(is_resource($result))
      {
      
      while($row=mysql_fetch_row($result))
      {
	  $content.=$row[1];
	  }
	  }
	
	
	$echoer = array();
	
	$echoer['content'] = $content;
	
	echo json_encode($echoer);
	
?>
	
	