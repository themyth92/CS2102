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
    }

?>