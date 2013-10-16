<?php
	require_once(__DIR__.'/../DBFunction.php');
	require_once(__DIR__.'/../config.php');


	session_start();
	if(isset($_POST[ACTION]) && isset($_SESSION[EMAIL])){
		
		$db = new DBFunctions();
		
		if($_POST[ACTION] == MANAGE){

			$email = $_SESSION[EMAIL];
			
			$db -> dbUserBookingSearch($email);
		}

		if($_POST[ACTION] == REMOVE){
			if(isset($_POST[BOOKING_ID])){
				$bookingID = $_POST[BOOKING_ID];
				$db -> dbRemoveUser($bookingID);
			}
		}
	}
?>