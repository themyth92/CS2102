<?php
	function checkSession($email){
		
		if(!is_null($email))
			return true;
		else
			return false;
	}

	//redicect to any URL in the page
	function redirectUser($page){
		//URL is starting by http:// plus host plus the current directory of the current page plus the page redirect
		$url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
		//remove any trailing slahshes
		$url=rtrim($url,'/\\');
		
		$url.='/'.$page;
			
		//redirect to the page
		header("Location:$url");
		exit();
	}
?>