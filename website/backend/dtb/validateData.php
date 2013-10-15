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
            $no_day = $arr_of_date.count();
            $min1 = 9999999; //dummy value
            $min2 = 9999999; //dummy value
            $min3 = 9999999; //dummy value
            $min4 = 9999999; //dummy value     
            
            // check if no of room type is 0 or not
            // if true then we don't need to check for availability
            if ($no_of_room_type_1 !=0) {
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Superior Single'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");
                    $min1 = ($min < $no_of_room_avail ? $min : $no_of_room_avail);      
                }
            }

            if ($no_of_room_type_2 !=0) {
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Superior Double'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");
                    $min1 = ($min < $no_of_room_avail ? $min : $no_of_room_avail);      
                }
            }

            if ($no_of_room_type_3 !=0) {
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Standard Single'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");
                    $min1 = ($min < $no_of_room_avail ? $min : $no_of_room_avail);      
                }
            }

            if ($no_of_room_type_4 !=0) {
                // count mininum number of room available each day within booking time range
                for ($i=0; $i<$no_day; $i++) {
                    $no_of_room_avail = mysql_query("SELECT (r.numberOfRoom - COUNT(*))
                                                        FROM ".BOOKING_TABLE." b 
                                                        JOIN ".ROOM_TYPE_TABLE." r ON r.name = b.roomTypeName
                                                        JOIN ".HOTEL_INFORMATION_TABLE." h ON h.hotelID = b.hotelID
                                                        WHERE (
                                                            h.hotelID = '".$hotelID."''
                                                            AND r.name = 'Standard Double'
                                                            AND b.startDate <= '".$arr_of_date[$i]."''
                                                            AND b.endDate >= '".$arr_of_date[$i]."'
                                                        ) ");
                    $min1 = ($min < $no_of_room_avail ? $min : $no_of_room_avail);      
                }
            }

            if ($min1 == 0 || $min2 == 0 || $min3 == 0 || $min4 == 0) {
                return false;
            } else return true;
        }
    }

?>