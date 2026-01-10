<?php

date_default_timezone_set("Asia/Karachi");

$time = date('H');
$month = date('m');


$frommontharray = array(12,3,6,9);
$tomontharray = array(2,5,8,11);

$fromtimearray = array('2000-01-01 17:00:00','2000-01-01 18:00:00','2000-01-01 19:00:00','2000-01-01 18:00:00');
$totimearray = array('2000-01-01 21:00:00', '2000-01-01 22:00:00','2000-01-01 23:00:00','2000-01-01 22:00:00');

$index = 0;
while($index<4)
{
        $frommonth = $frommontharray[$index] ; 
        $tomonth = $tomontharray[$index] ;     
        $fromtime = date('H', strtotime($fromtimearray[$index])) ;   
        $totime = date('H', strtotime($totimearray[$index])) ;       
	if ($frommonth>$tomonth)
                { 
                    if($month == $frommonth)
                        $month = 0;
                        $frommonth = 0;
                        
                }

        //if ($frommonth>$tomonth)
          //      $frommonth = 0;

        if(($month==$frommonth or $month>$frommonth) and ($month==$tomonth or $month<$tomonth))
        {
                if(($time==$fromtime or $time>$fromtime) and ($time==$totime or $time<$totime))
                {
                        echo "1 ";
                }
                else
                {
                        echo "0 ";
                }
        }
    $index = $index+1;
}

?>


