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
    }
?>