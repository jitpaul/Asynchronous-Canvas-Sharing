
 
<?php
set_time_limit (1000);
session_start(); 

    $name=$_SESSION['name'];  
    $sessionid=$_SESSION['sessionid'];
    session_write_close();   
    
  
    $noofusers=$_GET['noof'];
    $connection = mysql_connect("localhost","root","") or die('unable to connect');   
    mysql_select_db("chat", $connection) or die('unable to select database'); 
    $r=mysql_query("SELECT COUNT('name') FROM  users");
    $no_users=mysql_fetch_row($r);
    while($no_users[0]==$noofusers) 
    {
      $r=mysql_query("SELECT COUNT('name') FROM  users");
      $no_users=mysql_fetch_row($r);
    } 
      
      $result=mysql_query("SELECT name FROM users WHERE sessionid='$sessionid' "); 
      $temp=array();
      while($row=mysql_fetch_row($result))
      {
        $temp[]=$row[0];

      }
      $reply=array();
      $reply['user']=$temp;
      $reply['noof']=$no_users[0];
      echo json_encode($reply);

      

?>
