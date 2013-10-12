<?php
	/*=============================================
		@GLOBAL VARAIBLES
	==============================================*/

	/*
	  	define host information
	*/
	define('DB_HOST'						, 'localhost');
	define('DB_USER'						, 'themythn_admin');
	define('DB_PASSWORD'					, 'themyth@92');
	define('DB_DATABASE'					, 'themythn_HotelBooking');
	/*
		table
	*/
	define('USER_INFORMATION_TABLE'         , 'User');
	define('HOTEL_INFORMATION_TABLE'     	, 'Hotel');
	define('HOTEL_FEATURE_TABLE'			, 'HotelFeature');
	define('FEATURE_TABLE'					, 'Feature');
	define('ROOM_TYPE_TABLE'				, 'RoomType');
	/*
		column
	*/
	define('USER_INFO_EMAIL_COL'			, 'email');
	define('USER_INFO_PASS_COL'             , 'password');
	define('USER_INFO_ROLE_COL'			    , 'role');

	define('HOTEL_ID_COL'					, 'HotelID');
	define('HOTEL_NAME_COL'					, 'name');
	define('HOTEL_ADDRESS_COL'				, 'address');
	define('HOTEL_CONTACT_COL'				, 'contactNum');
	define('HOTEL_POSTAL_COL'				, 'postalCode');

	define('FEATURE_ID_COL'				    , 'featureID');
	define('FEATURE_NAME_COL'				, 'name');

	define('ROOM_TYPE_NAME_COL'				, 'name');
	define('ROOM_TYPE_PRICE_COL'			, 'price');
	define('ROOM_TYPE_NUMBER_ROOM'			, 'numberOfRoom');
	/*
		number
	*/
	define('MAXIMUM_USER_ACCOUNT'			, 1);

	/*
		status
	*/
	define('SUCCESS'						, 'SUCCESS');
	define('FAIL'							, 'FAIL');
	/*
	post parameter
	*/
	define('MESSAGE'						, 'message');
	define('EMAIL'							, 'email');
?>