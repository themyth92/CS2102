<?php
	/*
		@handle inner action from browser
		@display the data to browser also
	*/
	require_once(__DIR__.'/../DBFunction.php');
	require_once(__DIR__.'/../config.php');

	if(isset($_POST[MESSAGE])){
		
		$messages  = $_POST[MESSAGE];
		$db = new DBFunctions();

		$message  = explode('_', $messages);

		$email    = $message[0];
		$password = $message[1];

		if(is_null($email) || is_null($message)){

		}
		else 
			if($email == '' || $password == ''){

		}
		else{

			$db -> dbUserRegister($email, $password);
		}
	}
?>