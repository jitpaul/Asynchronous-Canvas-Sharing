

<?php

 session_start();
 ob_start(); 
 $connection = mysql_connect("localhost","root","") or die('unable to connect'); 
  
   
    mysql_select_db("chat", $connection) or die('unable to select database'); 
	mysql_query("select * from users");
  
  
$sessionid=$_POST['id'];
$name=$_POST['name'];


if ($sessionid=='' || $name == '')
{
   header("Location: main.php?valid=1");
   exit;

}

$res=mysql_query("select * from users where sessionid='$sessionid' AND NOW()-lastacttime>5");
if(mysql_num_rows ($res)>0)
{
      mysql_query("delete from users where sessionid='$sessionid' AND NOW()-lastacttime>5");
      
      $a= mysql_query("select * from users where sessionid='$sessionid'"); 
      if(mysql_num_rows ($a)<=0)
      {
         mysql_query("DROP TABLE `$sessionid`");
      
      }

}
$sql=" SHOW TABLES LIKE '$sessionid' ";
$result = mysql_query($sql);
if (mysql_num_rows ($result)>0)
{
   header("Location: main.php?valid=3");
   exit;

}
else
{
    
     mysql_query("CREATE TABLE `$sessionid`( name varchar(19), 
                                          text varchar(150),
                                          tstamp timestamp,
                                          textid INT NOT NULL AUTO_INCREMENT, 
                                          texttype int,
                                          PRIMARY KEY(textid) )")
                                          
                                          
    or die(mysql_error()); 
    
    $file=$sessionid.'_file';
    mysql_query("DROP TABLE `$file` ");
     mysql_query("CREATE TABLE `$file`( name varchar(20), 
                                          data varchar(1000000),
                                          shape varchar(100),
                                          number INT , 
										  flag INT,
                                          dataid INT NOT NULL AUTO_INCREMENT,
                                          PRIMARY KEY(dataid) )")
    or die(mysql_error()); 
    
        
}





$q="select * from users where name='$name' and sessionid='$sessionid' ";
  $result=mysql_query($q);
  if(mysql_num_rows($result) != 0)
   {
          
        
      header("Location: main.php?valid=2");
      exit;
   }
  
   else
   {
         $_SESSION['name']=stripslashes(htmlspecialchars($name));  
         $_SESSION['sessionid']=stripslashes(htmlspecialchars($sessionid)); 
                     
         mysql_query("INSERT INTO users (name,sessionid,lastacttime) VALUES ('$name','$sessionid',NOW())"); 
         header("Location:loggedin.php?user=$name");
     
   }
   
 ob_end_flush(); 
 
 ?>

