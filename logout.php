<?php 
session_start(); 
 ob_start();




           
            
            setcookie("user", "", time()-3600);
			$name=$_SESSION['name'];
			$sessionid=$_SESSION['sessionid'];
			
			
		    $connection = mysql_connect("localhost","root","") or die('unable to connect');   
            mysql_select_db("chat", $connection) or die('unable to select database'); 
            mysql_query("DELETE FROM users  WHERE name='$name' AND sessionid='$sessionid' "); 
            mysql_query("INSERT INTO `$sessionid` (name,text,tstamp,texttype) VALUES ('$name','logout',NOW(),0) "); 
            $result=mysql_query("SELECT * FROM users WHERE sessionid= '$sessionid' ");
            if(mysql_num_rows($result) == 0)
            {
                 mysql_query("DROP TABLE `$sessionid` "); 
                 $file=$sessionid.'_file';
                 mysql_query("DROP TABLE `$file` "); 
				 mysql_query("DELETE FROM redotable WHERE sessionid='$sessionid' "); 

                 
            }
			session_destroy();
			header("Location: main.php?logout=1");
?>

