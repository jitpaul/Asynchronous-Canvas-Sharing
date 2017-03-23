<?php
session_start(); 

   $time = time();
   $id = $_GET['id'];
   $name=$_SESSION['name'];  
   $sessionid=$_SESSION['sessionid'];
session_write_close();   
  while((time() - $time) < 30) 
  {
    $connection = mysql_connect("localhost","root","") or die('unable to connect');   
    mysql_select_db("chat", $connection) or die('unable to select database');
    mysql_query("UPDATE users SET lastacttime=NOW() WHERE name='$name' AND sessionid='$sessionid' ");
    $ltime=mysql_query("SELECT tstamp FROM `$sessionid` WHERE name='$name' AND text='login'");
    $logintime=mysql_fetch_row($ltime); 
    $result=mysql_query("SELECT * FROM`$sessionid` AS p WHERE p.tstamp= ( SELECT MIN(tstamp) FROM `$sessionid` WHERE textid>'$id' AND tstamp > '$logintime[0]')"); 
    
    $row=mysql_fetch_row($result);
   
   
    if(!empty($row)) 
    {
        echo json_encode($row);
        
        break;
    }
    else if((time()-$time)==29)
    {
       $res=mysql_query("SELECT MAX(tstamp) FROM `$sessionid` WHERE tstamp>'$logintime[0]' AND texttype='2'");
       $lastsent=mysql_fetch_row($res);
       echo json_encode($lastsent);
       break;
       
    
    }

}
?>
