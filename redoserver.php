<?php
     session_start();
     $name=$_SESSION['name'];
     $sessionid=$_SESSION['sessionid'];
     session_write_close();
     
     $connection = mysql_connect("localhost","root","") or die('unable to connect');   
     mysql_select_db("chat", $connection) or die('unable to select database');
    $file=$sessionid.'_file';
                 
			$res=mysql_query("SELECT MAX(dataid) FROM redotable WHERE sessionid='$sessionid'");
			$a=mysql_fetch_row($res);		
			$b=mysql_query("SELECT name,data,shape,number FROM redotable WHERE dataid = $a[0]");
			$bb=mysql_fetch_row($b);
			if($bb)
			{
			  mysql_query("INSERT INTO `$file` (name,data,shape,number,flag) VALUES ('$bb[0]','$bb[1]','$bb[2]',$bb[3],0) ");
				  
				  

		      $r=mysql_query("SELECT name,data FROM redotable WHERE dataid = $a[0]");
			  $ab=mysql_fetch_row($r);
              mysql_query("DELETE FROM redotable WHERE dataid = $a[0]");
			  if($name==$ab[0])
			   echo $ab[1];
			  else
			  echo 1;
			  }
			 else
			   echo 1;
     
?>
