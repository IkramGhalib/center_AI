<?php

    include("opendb.php");

    $con = new DBCon();

    $out = array();

        if($con->Open())
        {
            $q = "SELECT trid , name , longitude , latitude FROM transformer";
            $result = $con->db->query($q);
            
                while($row = mysqli_fetch_array($result))
                {
                    if($row[2] != "" && $row[3] != "")
                    {
                        $q2 = "SELECT B1L , B1M , B1U FROM tr_current_logs WHERE trid = '$row[0]' AND id = (SELECT MAX(id) FROM tr_current_logs WHERE trid = '$row[0]')";
                        
                        $result2 = $con->db->query($q2);
                        
                            while($row2 = mysqli_fetch_array($result2))
                            {
                                $q3 = "SELECT COUNT(id) FROM faults WHERE status = 'Pending' AND trid = '$row[0]'";
                                $result3 = $con->db->query($q3);
                                
                                    while($row3 = mysqli_fetch_array($result3))
                                    {
                                        if(($row2[0] > 0.1 && $row2[1] > 0.1 && $row2[2] > 0) && $row3[0] != 0)
                                        {
                                            array_push($out , array("longitude" => $row[2] , "latitude" => $row[3] , "isfaultdetected" => "no" , "istransformeron" => "yes"));
                                        }
                                        else if(($row2[0] > 0.1 && $row2[1] > 0.1 && $row2[2] > 0) && $row3[0] == 0)
                                        {
                                            array_push($out , array("longitude" => $row[2] , "latitude" => $row[3] , "isfaultdetected" => "yes" , "istransformeron" => "yes"));
                                        }
                                        else if(($row2[0] < 0.1 && $row2[1] < 0.1 && $row2[2] < 0) && $row3[0] != 0)
                                        {
                                            array_push($out , array("longitude" => $row[2] , "latitude" => $row[3] , "isfaultdetected" => "no" , "istransformeron" => "no"));
                                        }
                                        else
                                        {
                                            array_push($out , array("longitude" => $row[2] , "latitude" => $row[3] , "isfaultdetected" => "yes" , "istransformeron" => "no"));
                                        }
                                        
                                    }
                            }
                        
                    }
                }
            
            echo json_encode($out);
            
        }
     

    $con->db->close();

?>