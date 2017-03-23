<?php
     session_start();
     $name=$_SESSION['name'];
     $sessionid=$_SESSION['sessionid'];
     session_write_close();

 $connection = mysql_connect("localhost","root","") or die('unable to connect');   
 mysql_select_db("chat", $connection) or die('unable to select database');
 
 $file=$sessionid.'_file'; 
 
 $r=mysql_query("DELETE FROM `$file` ");
 $r=mysql_query("INSERT INTO `$file` (name,data) VALUES ('$name','<reset/>')");
 
 
 
 ?>
