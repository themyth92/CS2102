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

    	public function retrieveHotelListWithLocationAndRoomType($location, $ssingle = false, $ssdouble = false, $stsingle = false, $stdouble = false){

            //the query to execute
            $query = sprintf("SELECT ".USER_INFORMATION_TABLE."(".USER_INFO_EMAIL_COL." ,".USER_INFO_PASS_COL.") VALUES('%s', '%s')",
                              mysql_real_escape_string($email),
                              mysql_real_escape_string($password));
    	}
	}
?>