<?php
	include_once('backend/browser/browser.php');
	session_start();
	session_destroy();
	redirectUser('index.php');
?>