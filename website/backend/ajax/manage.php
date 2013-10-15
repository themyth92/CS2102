<?php
	require_once(__DIR__.'/../DBFunction.php');
	require_once(__DIR__.'/../config.php');


	session_start();
	if(isset($_POST[ACTION]) && isset($_SESSION[EMAIL])){
		if($_POST[ACTION] == MANAGE){

			$email = $_SESSION[EMAIL];
			$db = new DBFunctions();
			$db -> dbUserBookingSearch($email);
		}
	}
?>