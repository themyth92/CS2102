<?php
	/*==========================================
		@API used to control the display of status and message respond to client
		@Used in db_functions.inc
	==========================================*/
	class DataDisplay{

		private $_status;
		/*==================================
	   		@constructor
	   	==================================*/
		function __construct() {
			//list of success or fail status
            $this -> _status =  array('SUCCESS'                  => array('status' => 'success', 'code' => '200'),
            						  'FAIL'	                 => array('status' => 'fail',    'code' => '100'));
	    }

	    /*==================================
    		@destructor
    	==================================*/
    	function __destruct() {

    	}

    	/*===================================================
    		@display the message to client in JSON form
    		@param string, string, array
    		@param data for additional data added to the json
    		@return json
    	===================================================*/
    	public function displayJSON($status, $data = null){
            
            if($data === null)
                $arr  = array('status' => $this -> _status[$status]);
            else 
                if($data !== null)
                    $arr  = array('status' => $this -> _status[$status], 'data' => $data);
    		
            $json = array();
    		$json = json_encode($arr);
			
			header('Content-Type: application/json');
			echo $json;
    	}
    }
?>