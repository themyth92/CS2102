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
	define('BOOKING_TABLE'					, 'Booking');
	/*
		column
	*/
	define('USER_INFO_EMAIL_COL'			, 'email');
	define('USER_INFO_PASS_COL'             , 'password');
	define('USER_INFO_ROLE_COL'			    , 'role');

	define('HOTEL_ID_COL'					, 'hotelID');
	define('HOTEL_NAME_COL'					, 'name');
	define('HOTEL_ADDRESS_COL'				, 'address');
	define('HOTEL_CONTACT_COL'				, 'contactNum');
	define('HOTEL_POSTAL_COL'				, 'postalCode');

	define('FEATURE_ID_COL'				    , 'featureID');
	define('FEATURE_NAME_COL'				, 'name');

	define('ROOM_TYPE_NAME_COL'				, 'name');
	define('ROOM_TYPE_PRICE_COL'			, 'price');
	define('ROOM_TYPE_NUMBER_ROOM'			, 'numberOfRoom');

	define('BOOKING_ID_COL'					, 'bookingID');
	define('START_DATE_COL'					, 'startDate');
	define('END_DATE_COL'					, 'endDate');
	define('BOOKING_DATE_COL'				, 'bookingDate');
	define('NUMBER_OF_ROOM_COL'				, 'numberOfRoom');
	define('BOOKING_ROOM_TYPE_NAME_COL'		, 'roomTypeName');
	define('STATUS_COL'						, 'status');
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
	define('ACTION'							, 'action');
	define('EMAIL'							, 'email');
	define('LOCATION'						, 'location');
	define('PRICE_FROM'						, 'priceFrom');
	define('PRICE_TO'						, 'priceTo');
	define('FEATURE_1'						, 'feature1');
	define('FEATURE_2'						, 'feature2');
	define('ROOM_TYPE_1'					, 'roomType1');
	define('ROOM_TYPE_2'					, 'roomType2');
	define('ROOM_TYPE_3'					, 'roomType3');
	define('ROOM_TYPE_4'					, 'roomType4');

	define('BOOKING_ID'						, 'bookingID');
	define('START_DATE'						, 'startDate');
	define('END_DATE'						, 'endDate');
	define('BOOKING_DATE'					, 'bookingDate');
	/*
		browser action
	*/
	define('MANAGE'							, 'manage');
	define('REMOVE'							, 'remove');
	define('MODIFY'							, 'modify');
	/*	
		table contant
	*/
	define('SUPER_SINGLE'					, 'Superior Single');
	define('SUPER_DOUBLE'					, 'Superior Double');
	define('STANDARD_SINGLE'				, 'Standard Single');
	define('STANDARD_DOUBLE'				, 'Standard Double');
	define('FEATURE1'						, '1');
	define('FEATURE2'						, '2');
	define('ADMIN'							, '1');
	define('NORMAL_USER'					, '0');
?>