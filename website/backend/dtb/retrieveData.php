<?php
	class DataRetrieve{
		
		private $_retrieve;

		/*==================================
	   		@constructor
	   	==================================*/
		function __construct() {
        	
        	require_once(__DIR__.'/../connect.php');
        	
        	// connecting to database
        	$this -> send = new DtbConnect();
        	$this -> send -> connect();
	    }
	}
?>