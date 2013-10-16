<?php
	class DataRetrieve{
		
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

    	public function retrieveHotelListUsingLocation($location){

            //the query to execute
            $query = sprintf("SELECT ".USER_INFORMATION_TABLE."(".USER_INFO_EMAIL_COL." ,".USER_INFO_PASS_COL.") VALUES('%s', '%s')",
                              mysql_real_escape_string($email),
                              mysql_real_escape_string($password));
    	}

        public function retrieveHotelListFromSearch($location, 
                            $lower_bound, $upper_bound,
                            $feature1, $feature2,
                            $room_type1, $room_type2, $room_type3, $room_type4) {

            // turn $location to lower-case word
            $location = strtolower($location);
            
            // if upper_bound is 0, change its value to infinite
            if ($upper_bound == 0) {
                $upper_bound = 9999999; 
            }

            // calculate number of features and room type ticked
            $feature_no = $feature1 + $feature2;
            $room_type_no = $room_type1 + $room_type2 + $room_type3 + $room_type4;

            // look for checkbox values of features and room types
            // change them into ID of features or name of room types if ticked
            if ($feature1 != 0) {
                $feature1 = 1;
            }
            if ($feature2 != 0) {
                $feature2 = 2;
            }

            if ($room_type1 != 0) {
                $room_type1 = "Superior Single";
            } else {
                $room_type1 = "";
            }
            
            if ($room_type2 != 0) {
                $room_type2 = "Superior Double";
            } else {
                $room_type2 = "";
            }
            
            if ($room_type3 != 0) {
                $room_type3 = "Standard Single";
            } else {
                $room_type3 = "";
            }
            
            if ($room_type4 != 0) {
                $room_type4 = "Standard Double";
            } else {
                $room_type4 = "";
            }            
            // query the hotel list based on requested info
            if ($feature_no == 0 && $room_type_no == 0) {
                $query = "SELECT h.* FROM ".HOTEL_INFORMATION_TABLE." h
                        INNER JOIN ".ROOM_TYPE_TABLE." r ON r.hotelID = h.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0
                        AND r.price BETWEEN '".$lower_bound."' AND '".$upper_bound."')";
            } elseif ($feature_no == 0) {
                $query = "SELECT h.* FROM ".HOTEL_INFORMATION_TABLE." h
                        INNER JOIN ".ROOM_TYPE_TABLE." r ON h.hotelID = r.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0 
                        AND (r.name = '".$room_type1."' OR r.name = '".$room_type2."' OR
                             r.name = '".$room_type3."' OR r.name = '".$room_type4."')
                        AND r.price BETWEEN '".$lower_bound."' AND '".$upper_bound."')";
            } elseif ($room_type_no == 0) {
                $query = "SELECT h.* FROM ".HOTEL_INFORMATION_TABLE." h
                        INNER JOIN ".HOTEL_FEATURE_TABLE." hf ON h.hotelID = hf.hotelID
                        INNER JOIN ".ROOM_TYPE_TABLE." r ON h.hotelID = r.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0 
                        AND (hf.featureID = '".$feature1."' OR hf.featureID = '".$feature2."')
                        AND r.price BETWEEN '".$lower_bound."' AND '".$upper_bound."')";
            } else {
                $query = "SELECT h.* FROM ".HOTEL_INFORMATION_TABLE." h
                        INNER JOIN ".HOTEL_FEATURE_TABLE." hf ON h.hotelID = hf.hotelID
                        INNER JOIN ".ROOM_TYPE_TABLE." r ON h.hotelID = r.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0 
                        AND (hf.featureID = '".$feature1."' OR hf.featureID = '".$feature2."')
                        AND (r.name = '".$room_type1."' OR r.name = '".$room_type2."' OR
                             r.name = '".$room_type3."' OR r.name = '".$room_type4."')
                        AND r.price BETWEEN '".$lower_bound."' AND '".$upper_bound."')";
            }
            file_put_contents('test.txt', $query);
            

             //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)

                //query failed to execute
                return false;
            
            else{

                $returnArray = array();

                while($row = mysql_fetch_array($executeQuery))
                    array_push($returnArray, $row[0]);

                return $returnArray;
            }
        }

        public function retrieveHotelInformation($hotel){
            
            $query = sprintf("SELECT h.".HOTEL_ID_COL.", 
                             h.".HOTEL_NAME_COL.", 
                             h.".HOTEL_ADDRESS_COL.", 
                             h.".HOTEL_CONTACT_COL.", 
                             h.".HOTEL_POSTAL_COL."
                             FROM ".HOTEL_INFORMATION_TABLE." h, ".
                             " WHERE h.".HOTEL_NAME_COL." =  '%s'",
                             mysql_real_escape_string($hotel));

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)
                die();
            else{
                if(mysql_num_rows($executeQuery) == 1){
                    $row = mysql_fetch_array($executeQuery);
                    return array($row[0], $row[1], $row[2], $row[3], $row[4]);
                }
                else
                    return false;
            }
        }

        public function retrieveHotelFeature($hotel){

            $query = sprintf("SELECT f.".FEATURE_ID_COL." FROM ". FEATURE_TABLE. " f, ".HOTEL_INFORMATION_TABLE." h WHERE h.".HOTEL_NAME_COL." = '%s' AND f.".HOTEL_ID_COL ."= h. ".HOTEL_ID_COL,
                            mysql_real_escape_string($hotel));

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)
                die();
            else{

                $returnArray = array(0,0);

                while($row = mysql_fetch_array($executeQuery)){
                    if($row[0] == FEATURE1)
                        $returnArray[0] = 1;
                    if($row[0] == FEATURE2)
                        $returnArray[1] = 1;
                }

                return $returnArray;
            }
        }

        public function retrieveHotelRoomType($hotel){
            
            $query = sprintf("SELECT f.".ROOM_TYPE_NAME_COL." FROM ". ROOM_TYPE_TABLE. " f, ".HOTEL_INFORMATION_TABLE." h WHERE h.".HOTEL_NAME_COL." = '%s' AND f.".HOTEL_ID_COL ."= h. ".HOTEL_ID_COL,
                            mysql_real_escape_string($hotel));

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)
                die();
            else{

                $returnArray = array(0,0,0,0);

                while($row = mysql_fetch_array($executeQuery)){
                    if($row[0] == SUPER_SINGLE)
                        $returnArray[0] = 1;
                    if($row[0] == SUPER_DOUBLE)
                        $returnArray[1] = 1;
                    if($row[0] == STANDARD_SINGLE)
                        $returnArray[2] = 1;
                    if($row[0] == STANDARD_DOUBLE)
                        $returnArray[3] = 1;
                }

                return $returnArray;
            }
        }

        public function retrieveUserRole($email)
        {
            //SQL: Getting the role from GIVEN 'email'
            /*"SELECT U.role 
            FROM User U 
            WHERE U.email = '%s'";*/

            $query = sprintf("SELECT ".USER_INFO_ROLE_COL." FROM ".USER_INFORMATION_TABLE." WHERE ".USER_INFO_EMAIL_COL."= '%s'",
                              mysql_real_escape_string($email));

            //execute the query
            $executeQuery = mysql_query($query);
 
            if(!$executeQuery)
                die();
            else{
               $row = mysql_fetch_array($executeQuery);

               return $row[0]; 
            }
        }

        public function retrieveBookingListFromEmail($email, $role)
        {
            $bookingList = array();

            if($role == NORMAL_USER){
                $query = sprintf("SELECT b.".BOOKING_ID_COL.", h.".HOTEL_NAME_COL.", b.".USER_INFO_EMAIL_COL.", b.".BOOKING_ROOM_TYPE_NAME_COL.", b.".NUMBER_OF_ROOM_COL.", b.".START_DATE_COL.", b.".END_DATE_COL.", b.".BOOKING_DATE_COL." FROM ".BOOKING_TABLE." b, ".HOTEL_INFORMATION_TABLE." h,".USER_INFORMATION_TABLE." u WHERE b.".USER_INFO_EMAIL_COL." ='%s' AND b.".HOTEL_ID_COL."= h.".HOTEL_ID_COL." AND b.".STATUS_COL."<> 0 AND b."
                                  .USER_INFO_EMAIL_COL." = u.".USER_INFO_EMAIL_COL." ORDER BY b.".BOOKING_DATE_COL." ASC ",
                                   mysql_real_escape_string($email)); 

            }
            else
                if($role == ADMIN){
                     $query = sprintf("SELECT b.".BOOKING_ID_COL.", h."
                                                 .HOTEL_NAME_COL.", b."
                                                 .USER_INFO_EMAIL_COL.", b."
                                                 .BOOKING_ROOM_TYPE_NAME_COL.", b."
                                                 .NUMBER_OF_ROOM_COL.", b."
                                                 .START_DATE_COL.", b."
                                                 .END_DATE_COL.", b."
                                                 .BOOKING_DATE_COL." FROM "
                                                 .BOOKING_TABLE." b, "
                                                 .HOTEL_INFORMATION_TABLE." h WHERE b."
                                                 .HOTEL_ID_COL."= h."
                                                 .HOTEL_ID_COL." AND b."
                                                 .STATUS_COL."<> 0 ORDER BY b.".BOOKING_DATE_COL." ASC ");
                }

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)
                die();
            else
            {
                while($rows = mysql_fetch_array($executeQuery)){
                   
                    //getting number of room for each type
                    if($rows['roomTypeName'] == SUPER_SINGLE)
                        $_S1 = $rows['numberOfRoom'];
                    else 
                        $_S1 = 0;

                    if($rows['roomTypeName'] == SUPER_DOUBLE)
                        $_D1 = $rows['numberOfRoom'];
                    else 
                        $_D1 = 0;

                    if($rows['roomTypeName'] == STANDARD_SINGLE)
                        $_S2 = $rows['numberOfRoom'];
                    else 
                        $_S2 = 0;

                    if($rows['roomTypeName'] == STANDARD_DOUBLE)
                        $_D2 = $rows['numberOfRoom'];
                    else 
                        $_D2 = 0;
        
                    //roomType array
                    $roomType = array($_S1, $_D1, $_S2, $_D2);

                    //array for each tuple
                    $bookingItem = array('bookingID' => $rows['bookingID'], 'email' => $rows['email'], 'hotel' => $rows['name'], 'roomType' => $roomType,
                                'startDate' => $rows['startDate'], 'endDate' => $rows['endDate'], 'bookingDate' => $rows['bookingDate']);
        
                    //push into big array
                    array_push($bookingList, $bookingItem);
                }
            }

            return $bookingList;
        }
	}
?>