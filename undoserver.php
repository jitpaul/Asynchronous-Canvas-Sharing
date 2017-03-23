<?php
     session_start();
     $name=$_SESSION['name'];
     $sessionid=$_SESSION['sessionid'];
     session_write_close();
     
     $connection = mysql_connect("localhost","root","") or die('unable to connect');   
     mysql_select_db("chat", $connection) or die('unable to select database');
     
     $file=$sessionid.'_file';
     
     $id1 = $_POST['var1'];
     $id2 = '<undo id1="'.$id1.'"/>';
     
      $res=mysql_query("SELECT * FROM `$file`");    
      if(is_resource($res))
       {
      
      while($row=mysql_fetch_row($res))
      {
                 if(($row[0].'_'.$row[2].'_'.$row[3]) == $id1 )
                 {
				  mysql_query("INSERT INTO redotable (name,data,shape,number,sessionid) VALUES ('$row[0]','$row[1]','$row[2]',$row[3],'$sessionid')");
                  $r= mysql_query("DELETE FROM `$file` WHERE  name = '$row[0]' AND shape = '$row[2]' AND   number = $row[3] ");
                  $r=mysql_query("INSERT INTO `$file` (name,data)   VALUES ('$name','$id2')")  ; 
                  break;                            
                  }
     }
     }
     echo 1;
     
?>
