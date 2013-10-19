<?php
	require_once(__DIR__.'/../DBFunction.php');
	require_once(__DIR__.'/../config.php');

	if(isset($_POST[BOOKING_ID]) && isset($_POST[START_DATE]) && 
	   isset($_POST[END_DATE]) && isset($_POST[BOOKING_DATE]) && 
	   isset($_POST[ROOM_TYPE_1]) && isset($_POST[ROOM_TYPE_2]) &&
	   isset($_POST[ROOM_TYPE_3]) && isset($_POST[ROOM_TYPE_4])){
		$hotelID = $_POST[BOOKING_ID];
		$startDate = $_POST[START_DATE];
		$endDate   = $_POST[END_DATE];
		$roomType1 = $_POST[ROOM_TYPE_1];
		$roomType2 = $_POST[ROOM_TYPE_2];
		$roomType3 = $_POST[ROOM_TYPE_3];
		$roomType4 = $_POST[ROOM_TYPE_4];
		session_start();
		$email     = $_SESSION[EMAIL];
		$bookingDate = $_POST[BOOKING_DATE];

		$db = new DBFunctions();
		$db -> dbBook($email, $hotelID, $startDate, $endDate, $roomType1, $roomType2, $roomType3, $roomType4, $bookingDate);
	}
?>