<?php
	class DataStore{
		
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
        ==============================================*/
        public function storeUserInformation($email, $password){

            //the query to execute
            $query = sprintf("INSERT INTO ".USER_INFORMATION_TABLE."(".USER_INFO_EMAIL_COL." ,".USER_INFO_PASS_COL.") VALUES('%s', '%s')",
                              mysql_real_escape_string($email),
                              mysql_real_escape_string($password));

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)

                //query failed to execute
                return false;
            
            else{

            	return true;
            }   
        }

        public function storeBooking($roomTypeName, $hotelID, $email, $startDate, $endDate, $bookingDate, $numberOfRoom)
        {
            /*
            INSERT INTO booking VALUES ($roomTypeName, $hotelID, $email, $startDate, $endDate, $bookingDate, $numberOfRoom);
            */
            $query = sprintf("INSERT INTO ".BOOKING_TABLE." ("
                                           .BOOKING_ROOM_TYPE_NAME_COL." ,"
                                           .HOTEL_ID_COL." ,"
                                           .USER_INFO_EMAIL_COL." ,"
                                           .START_DATE_COL." ,"
                                           .END_DATE_COL." ,"
                                           .BOOKING_DATE_COL." ,"
                                           .NUMBER_OF_ROOM_COL.") VALUES ('%s','%s','%s','%s','%s','%s','%s')"
                ,mysql_escape_string($roomTypeName), mysql_escape_string($hotelID), mysql_escape_string($email), mysql_escape_string($startDate)
                ,mysql_escape_string($endDate), mysql_escape_string($bookingDate), mysql_escape_string($numberOfRoom));
            file_put_contents("text.txt", $query);
            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)
            //query failed to execute
                return false;
            else
                return true;
        }   

    }
?>