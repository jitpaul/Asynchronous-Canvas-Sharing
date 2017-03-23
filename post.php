<?php
session_start();  
if(isset($_SESSION['name']) && isset($_SESSION['sessionid']) )
    {          

    $name=$_SESSION['name'];  
    $sessionid=$_SESSION['sessionid'];                      
    $text = $_POST['text']; 
    session_write_close(); 
    $connection = mysql_connect("localhost","root","") or die('unable to connect');   
    mysql_select_db("chat", $connection) or die('unable to select database'); 

    mysql_query("INSERT INTO `$sessionid` (name,text,tstamp,texttype) VALUES ('$name','$text',NOW(),2)"); 
    
   }
?>
