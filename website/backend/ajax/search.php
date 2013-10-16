<?php
	require_once(__DIR__.'/../DBFunction.php');
	require_once(__DIR__.'/../config.php');

	if(isset($_POST[LOCATION]) && 
	   isset($_POST[PRICE_FROM]) && 
	   isset($_POST[PRICE_TO]) && 
	   isset($_POST[FEATURE_1]) && 
	   isset($_POST[FEATURE_2]) &&
	   isset($_POST[ROOM_TYPE_1]) &&
	   isset($_POST[ROOM_TYPE_2]) &&
	   isset($_POST[ROOM_TYPE_3]) &&
	   isset($_POST[ROOM_TYPE_4])){

		$location   = $_POST[LOCATION];
		$priceFrom  = $_POST[PRICE_FROM];
		$priceTo    = $_POST[PRICE_TO];
		$feature1   = $_POST[FEATURE_1];
		$feature2   = $_POST[FEATURE_2];
		$roomType1  = $_POST[ROOM_TYPE_1];
		$roomType2  = $_POST[ROOM_TYPE_2];
		$roomType3  = $_POST[ROOM_TYPE_3];
		$roomType4  = $_POST[ROOM_TYPE_4];

		$db = new DBFunctions();
		$db -> dbUserSearch($location, $priceFrom, $priceTo, $feature1, $feature2, $roomType1, $roomType2, $roomType3, $roomType4);
	}
?>