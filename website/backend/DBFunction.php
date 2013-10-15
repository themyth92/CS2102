<?php
	/*================================================
		@all neccessary functions for database control
        @include also the data checking from client
	================================================*/
    require      'dtb/validateData.php';
    require      'dtb/retrieveData.php';
    require      'dtb/storeData.php';
    require      'dtb/displayData.php';
    require      'dtb/updateData.php';

    class DBFunctions{

        //control validate input
        protected $_validate;
        //control taking data from database
        protected $_retrieve;
        //control store data into database
        protected $_store;
        //control other function used for display purpose
        protected $_display;

        protected $_update;

	   	/*==================================
	   		@constructor
	   	==================================*/
	   	function __construct() {
            $this -> _validate = new DataValidate();
            $this -> _retrieve = new DataRetrieve();
            $this -> _store    = new DataStore();
            $this -> _display  = new DataDisplay();
            //$this -> _update   = new dataUpdate();
	    }
	
    	/*==================================
    		@destructor
    	==================================*/
    	function __destruct() {

    	}

    	public function dbUserLogin($email, $password){

    		if(is_null($password) || is_null($password)){
    			
    			$this -> _display -> displayJSON(FAIL);
    			return false;
    		}

    		if($this -> _validate -> validateUserInfo($email, $password)){
    			//we also need to return the role here
    			//however the retrieve data has not been done yet
    			//also need to return the email to keep track of user action
    			//and to store it on session
    			session_start();
    			$_SESSION[EMAIL] = $email;
    			
    			$this -> _display -> displayJSON(SUCCESS);
    			return true;
    		}
    		else{
    			$this -> _display -> displayJSON(FAIL);
    			return false;
    		}
    	}

    	public function dbUserRegister($email, $password){

    		if(is_null($password) || is_null($email)){

    			$this -> _display -> displayJSON(FAIL);
    			return false;
    		}

    		if(!($this -> _validate -> validateUserInfo($email))){

    			$this -> _store -> storeUserInformation($email, $password); 
    			$this -> _display -> displayJSON(SUCCESS);

    			return true;
    		}
    		else{
    			$this -> _display -> displayJSON(FAIL);
    			return false;
    		}
    	}

        public function dbUserSearch($location, $feature1, $feature2,
                            $room_type1, $room_type2, $room_type3, $room_type4){
            $this -> _retrieve -> retrieveHotelListFromSearch($location, $feature1, $feature2, $room_type1, $room_type2, $room_type3, $room_type4);
        }

        public function dbUserRoleSearch($email)
        {
            $this -> _retrieve -> retriveUserRole($email);
        }

        public function dbUserBookingSearch($email)
        {
            if(is_null($email))
            {
                $this -> _display -> displayJSON(FAIL);
                return false;
            }

            if($this -> _retrieve -> retrieveBookingListFromEmail($email))
            {
                $arr = $this -> _retrieve -> retrieveBookingListFromEmail($email);
                $this -> _display -> displayJSON(SUCCESS, $arr);
                return true;
            }
            else
            {
                $this -> _display -> displayJSON(FAIL);
                return false;
            }

        }
    }
?>