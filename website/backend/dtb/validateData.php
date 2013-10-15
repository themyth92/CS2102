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

            // check if no of room type is 0 or not
            // if true then we don't need to check for availability
            if ($no_of_room_type_1 !=0) {
                // count mininum number of room available each day within booking time range
                $min = 9999999; //dummy value
                for ($i=0; $i<$arr)
            }

        }
    }

?>