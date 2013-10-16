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
            $this -> _update   = new DataUpdate();
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

        public function dbUserSearch($location, $lower_bound, $upper_bound, $feature1, $feature2,
                            $room_type1, $room_type2, $room_type3, $room_type4){


            $hotelList = $this -> _retrieve -> retrieveHotelListFromSearch($location, $lower_bound, $upper_bound, $feature1, $feature2, $room_type1, $room_type2, $room_type3, $room_type4);

            if(empty($hotelList)){
                $this -> _display ->displayJSON(FAIL);
                return false;
            }

            $dataReturn = array();
            foreach($hotelList as $value){
                $hotel = $this -> _retrieve -> retrieveHotelInformation($value);
                $feature = $this -> _retrieve -> retrieveHotelFeature($value);
                $roomType = $this -> _retrieve -> retrieveHotelRoomType($value);

                $arr = array('hotel' => $hotel, 'feature' => $feature, 'roomType' => $roomType);
                array_push($dataReturn, $arr);
            }

            $this -> _display -> displayJSON(SUCCESS, $dataReturn);
            return true;

        }

        public function dbUserBookingSearch($email)
        {   
            
            if(is_null($email))
            {
                $this -> _display -> displayJSON(FAIL);
                return false;
            }

            $role = $this -> _retrieve -> retrieveUserRole($email);
                
            if($this -> _retrieve -> retrieveBookingListFromEmail($email, $role))
            {
                $arr = $this -> _retrieve -> retrieveBookingListFromEmail($email, $role);
                $this -> _display -> displayJSON(SUCCESS, $arr);
                return true;
            }
            else
            {
                $this -> _display -> displayJSON(FAIL);
                return false;
            }
        }

        public function dbRemoveUser($bookingID){
            $this -> _update -> updateBookingStatus($bookingID);
            $this -> _display -> displayJSON(SUCCESS);
            return true;
        }
    }
?>