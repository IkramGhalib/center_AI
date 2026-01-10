<?php
$subdivarray = array('swtwssc','mes01c1');
for($x = 0; $x<sizeof($subdivarray); $x++)
{
  $subdivid =$subdivarray[$x];
       // $subdivid = $_GET['subdivid'];
        $dbhost = "10.13.144.6";
		$dbuser = "user_".$subdivid;
		$dbpass =  "Adm1n@".$subdivid;
        $dbname =  "waterscada_".$subdivid;
		$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
 
              
              $sql = "SELECT transformer.trid, transformer.name, transformer.switch_time ,auto_switching.starttime, auto_switching.offtime, auto_switching.repeat FROM `transformer`, `auto_switching` where transformer.trid=auto_switching.trid";
              $result = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result))
		{  
                  $repeat=$row['repeat'];
				  $today = date("N");
				  $currenttime = strtotime( date('H:i:s'));
                  $trid= $row['trid'];
			      echo date('H:i:s').' ';
			      echo $row['starttime'].' ';
			      echo $row['offtime'].' ';
                  $starttime= strtotime($row['starttime']);
                  $offtime= strtotime($row['offtime']);
			      $dt = date("Y-m-d");
			      $dtoff = $dt.' '.$row['offtime'];
			      $dton =$dt.' '.$row['starttime'];
                  $timediff1 = ceil(($currenttime-$starttime)/60);
			      echo $timediff1.' ';
                  $timediff2 = ceil(($currenttime-$offtime)/60);
			      echo $timediff2.' ';
			      echo $today-$repeat;
			
				if($today-$repeat == $today or $today-$repeat == 0)
				{
					
					if($timediff1<=5 and $timediff1>=0 )
                    {
						$q = "UPDATE transformer SET  status = 'On' , status_out = '1' , `switch_time` = '$dton' , `cause` = 'Online' WHERE trid = '$trid' ";
                         $result2 = mysqli_query($db,$q);
						echo $q;
	
                     }
                     if($timediff2<=5 and $timediff2>=0)
                     {
                         $q = "UPDATE transformer SET  status = 'Off' , status_out = '0' , `switch_time` = '$dtoff' , `cause` = 'Online' WHERE trid = '$trid' ";
                          $result2 = mysqli_query($db,$q);
						 echo $q;
                     }
					
				}		  
				  

               
              }
               

            
$db->close();
}


?>

