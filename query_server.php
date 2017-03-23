<?php

	set_time_limit (1000);
	
	session_start();
    $name=$_SESSION['name'];  
    $sessionid=$_SESSION['sessionid'];  
	session_write_close(); 
	
	$id = $_POST['var1'];
		set_time_limit (1000);
		$file=$sessionid.'_file';
	
	
	$connection = mysql_connect("localhost","root","") or die('unable to connect');   
    mysql_select_db("chat", $connection) or die('unable to select database');
    
    $res=mysql_query("SELECT dataid FROM `$file` WHERE dataid>'$id'");
    $rw=mysql_fetch_row($res);
    $temp=array();
    
    $max=0;
    $content='';
    while(!$rw)
    {
          usleep(1000);
          $res=mysql_query("SELECT dataid FROM `$file` WHERE dataid>'$id'");                       
           $rw=mysql_fetch_row($res);                      
    }
    $result=mysql_query("SELECT name,data,dataid,flag FROM `$file` WHERE dataid>'$id'");
    if(is_resource($result))
    {
      
      while($row=mysql_fetch_row($result))
      {
      if($row[0]!=$name || $row[3]==0)
        {
        $content.=$row[1];
        $temp['name']=$row[0];
        }
        if($row[2] > $max)
        {
        $max=$row[2];
        }
      
        
        
	  }
	 }
      
      
      
      
      $temp['content']=$content;
      $temp['id']=$max;
      
   
     
        echo json_encode($temp); 
           
    
    
    
    
    
    
    
    flush();
 
 ?>
