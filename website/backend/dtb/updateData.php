<?php
	class DataUpdate{
		
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

        public function updateDateModified($bookingID, $startDate, $endDate)
        {
            /*
                UPDATE booking 
                SET startDate = '%s', endDate = '%s', bookingDate = '%s'
                WHERE bookingID = '%s';
            */

            $query = sprintf("UPDATE ".BOOKING_TABLE." SET ".START_DATE_COL." = '%s',".END_DATE_COL."= '%s' WHERE ".BOOKING_ID_COL."= '%s'",
                        mysql_real_escape_string($startDate), 
                        mysql_real_escape_string($endDate), 
                        mysql_real_escape_string($bookingID));

            //execute the query
            $executeQuery = mysql_query($query);

            if(!$executeQuery)
                //query failed to execute
                return false;
            else
                return true;
        }

        public function updateBookingStatus($bookingID, $status = 0)
        {
            $query = sprintf("UPDATE ".BOOKING_TABLE." SET ".STATUS_COL." = '%s' WHERE ".BOOKING_ID_COL."= '%s'", mysql_real_escape_string($status), mysql_real_escape_string($bookingID));
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