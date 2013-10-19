<?php
	class DataValidate{
		
		private $_connect;

		/*==================================
	   		@constructor
	   	==================================*/
		function __construct() {
        	
        	require_once(__DIR__.'/../connect.php');
        	
        	// connecting to database
        	$this -> _connect = new DtbConnect();
        	$this -> _connect -> connect();
	    }

	    /*==================================
    		@destructor
    	==================================*/
    	function __destruct() {
            
    	}

        /*===============================================
            @return true if user already exist
            @if not return false
        ==============================================*/
        public function validateUserInfo($email, $password = null){

            if(is_null($password)){
                $query = sprintf("SELECT COUNT(*) AS COUNT FROM ".USER_INFORMATION_TABLE." WHERE ".USER_INFO_EMAIL_COL." = '%s'",
                         mysql_real_escape_string($email));
            }
            else{
                $query = sprintf("SELECT COUNT(*) AS COUNT FROM ".USER_INFORMATION_TABLE." WHERE ".USER_INFO_EMAIL_COL." = '%s' AND ".USER_INFO_PASS_COL." = '%s'",
                         mysql_real_escape_string($email),
                         mysql_real_escape_string($password));
            }

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)          
                die();
            else{

                $row = mysql_fetch_assoc($executeQuery);
                if($row['COUNT'] == MAXIMUM_USER_ACCOUNT){

                    return true;
                }
                else{

                    return false;
                }
            }
        }

        public function validateRoomTypeAvailability($hotelID,
                            $arr_of_date,
                            $no_of_room_type_1, $no_of_room_type_2,
                            $no_of_room_type_3, $no_of_room_type_4) {
            $no_day = count($arr_of_date);

            $min1 = 9999999; //dummy value
            $min2 = 9999999; //dummy value
            $min3 = 9999999; //dummy value
            $min4 = 9999999; //dummy value     
            
            // check if no of room type is 0 or not
            // if true then we don't need to check for availability
            
            if ($no_of_room_type_1 !=0) {
                $query1 = mysql_query("SELECT r.numberOfRoom FROM "
                                                            .ROOM_TYPE_TABLE." r WHERE r."
                                                            .HOTEL_ID_COL." = ".$hotelID." AND r."
                                                            .ROOM_TYPE_NAME_COL." = 'Superior Single'");
                $row1 = mysql_fetch_array($query1);
                $type1_total_room = $row1[0];
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    
                    $query2 = mysql_query("SELECT SUM(b.numberOfRoom) FROM "
                                                            .BOOKING_TABLE." b WHERE b."
                                                            .HOTEL_ID_COL." =".$hotelID." AND b."
                                                            .ROOM_TYPE_NAME_COL." = 'Superior Single' AND b."
                                                            .START_DATE_COL." <= '".$arr_of_date[$i]."' AND b."
                                                            .END_DATE_COL." >= '".$arr_of_date[$i]."' AND b."
                                                            .STATUS_COL." = 1");

                    
                    $row2 = mysql_fetch_array($query2);
                    $type1_booked = $row2[0];
                    if(is_null($type1_booked))
                        $type1_booked = 0;
                    /*$no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."'
                                                            AND r.name = 'Superior Single'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");*/
                    $no_of_room_avail1 = $type1_total_room - $type1_booked;
                    $min1 = ($min1 < $no_of_room_avail1 ? $min1 : $no_of_room_avail1);      
                }
            }

            if ($no_of_room_type_2 !=0) {
                $query3 = mysql_query("SELECT r.numberOfRoom FROM "
                                                            .ROOM_TYPE_TABLE." r WHERE r."
                                                            .HOTEL_ID_COL." = ".$hotelID." AND r."
                                                            .ROOM_TYPE_NAME_COL." = 'Superior Double'");
                $row3 = mysql_fetch_array($query3);
                $type2_total_room = $row3[0]; 
                if(is_null($type2_booked))
                        $type2_booked = 0;           
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $query4 = mysql_query("SELECT SUM(b.numberOfRoom) FROM "
                                                            .BOOKING_TABLE." b WHERE b."
                                                            .HOTEL_ID_COL." =".$hotelID." AND b."
                                                            .ROOM_TYPE_NAME_COL." = 'Superior Double' AND b."
                                                            .START_DATE_COL." <= '".$arr_of_date[$i]."' AND b."
                                                            .END_DATE_COL." >= '".$arr_of_date[$i]."' AND b."
                                                            .STATUS_COL." = 1");

                    $row4 = mysql_fetch_array($query4);
                    $type2_booked = $row4[0];
                    /*$no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Superior Double'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");*/
                    $no_of_room_avail2 = $type2_total_room - $type2_booked;
                    $min2 = ($min2 < $no_of_room_avail2 ? $min2 : $no_of_room_avail2);      
                }
            }

            if ($no_of_room_type_3 !=0) {
                $query5 = mysql_query("SELECT r.numberOfRoom FROM "
                                                            .ROOM_TYPE_TABLE." r WHERE r."
                                                            .HOTEL_ID_COL." = ".$hotelID." AND r."
                                                            .ROOM_TYPE_NAME_COL." = 'Standard Single'");
                $row5 = mysql_fetch_array($query5);
                $type3_total_room = $row5[0];
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $query6 = mysql_query("SELECT SUM(b.numberOfRoom) FROM "
                                                            .BOOKING_TABLE." b WHERE b."
                                                            .HOTEL_ID_COL." =".$hotelID." AND b."
                                                            .ROOM_TYPE_NAME_COL." = 'Standard Single' AND b."
                                                            .START_DATE_COL." <= '".$arr_of_date[$i]."' AND b."
                                                            .END_DATE_COL." >= '".$arr_of_date[$i]."' AND b."
                                                            .STATUS_COL." = 1");    

                    $row6 = mysql_fetch_array($query6);
                    $type3_booked = $row6[0];
                    if(is_null($type3_booked))
                        $type3_booked = 0;
                    /*$no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Standard Single'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");*/
                    $no_of_room_avail3 = $type3_total_room - $type3_booked;
                    $min3 = ($min3 < $no_of_room_avail3 ? $min3 : $no_of_room_avail3);      
                }
            }

            if ($no_of_room_type_4 !=0) {
                $query7 = mysql_query("SELECT r.numberOfRoom FROM "
                                                            .ROOM_TYPE_TABLE." r WHERE r."
                                                            .HOTEL_ID_COL." = ".$hotelID." AND r."
                                                            .ROOM_TYPE_NAME_COL." = 'Standard Double'");
                $row7 = mysql_fetch_array($query7);
                $type4_total_room = $row7[0];
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $query8 = mysql_query("SELECT SUM(b.numberOfRoom) FROM "
                                                            .BOOKING_TABLE." b WHERE b."
                                                            .HOTEL_ID_COL." =".$hotelID." AND b."
                                                            .BOOKING_ROOM_TYPE_NAME_COL." = 'Standard Double' AND b."
                                                            .START_DATE_COL." <= '".$arr_of_date[$i]."' AND b."
                                                            .END_DATE_COL." >= '".$arr_of_date[$i]."' AND b."
                                                            .STATUS_COL." = 1");

                    $row8 = mysql_fetch_array($query8);
                    file_put_contents('vcl.txt', "SELECT SUM(b.numberOfRoom) FROM "
                                                            .BOOKING_TABLE." b WHERE b."
                                                            .HOTEL_ID_COL." =".$hotelID." AND b."
                                                            .BOOKING_ROOM_TYPE_NAME_COL." = 'Standard Double' AND b."
                                                            .START_DATE_COL." <= '".$arr_of_date[$i]."' AND b."
                                                            .END_DATE_COL." >= '".$arr_of_date[$i]."' AND b."
                                                            .STATUS_COL." = 1");
                    $type4_booked = $row8[0];
                    if(is_null($type4_booked))
                        $type4_booked = 0;
                    /*$no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Standard Double'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");*/
                    $no_of_room_avail4 = $type4_total_room - $type4_booked;
                    $min4 = ($min4 < $no_of_room_avail4 ? $min4 : $no_of_room_avail4);      
                }
            }

            if ($min1 < $no_of_room_type_1 || $min2 < $no_of_room_type_2 || $min3 < $no_of_room_type_3 || $min4 < $no_of_room_type_4) {
                return false;
            } else 
                return true;
        }
    }

?>