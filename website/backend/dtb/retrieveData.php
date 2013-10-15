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
                $query = "SELECT h.* FROM hotel h
                        INNER JOIN ROOM_TYPE_TABLE r ON r.hotelID = h.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0
                        AND r.price BETWEEN '".$lower_bound"' AND '".$upper_bound"')";
            } elseif ($feature_no == 0) {
                $query = "SELECT h.* FROM hotel h
                        INNER JOIN ROOM_TYPE_TABLE r ON h.hotelID = r.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0 
                        AND (r.name = '".$room_type1."' OR r.name = '".$room_type2."' OR
                             r.name = '".$room_type3."' OR r.name = '".$room_type4."')
                        AND r.price BETWEEN '".$lower_bound"' AND '".$upper_bound"')";
            } elseif ($room_type_no == 0) {
                $query = "SELECT h.* FROM hotel h
                        INNER JOIN HOTEL_FEATURE_TABLE hf ON h.hotelID = hf.hotelID
                        INNER JOIN ROOM_TYPE_TABLE r ON h.hotelID = r.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0 
                        AND (hf.featureID = '".$feature1."' OR hf.featureID = '".$feature2."')
                        AND r.price BETWEEN '".$lower_bound"' AND '".$upper_bound"')";
            } else {
                $query = "SELECT h.* FROM hotel h
                        INNER JOIN HOTEL_FEATURE_TABLE hf ON h.hotelID = hf.hotelID
                        INNER JOIN ROOM_TYPE_TABLE r ON h.hotelID = r.hotelID
                        WHERE (INSTR(h.address, '{".$location."}') > 0 
                        AND (hf.featureID = '".$feature1."' OR hf.featureID = '".$feature2."')
                        AND (r.name = '".$room_type1."' OR r.name = '".$room_type2."' OR
                             r.name = '".$room_type3."' OR r.name = '".$room_type4."')
                        AND r.price BETWEEN '".$lower_bound"' AND '".$upper_bound"')";
            }
            
            return mysql_query($query);
        }
	}
?>