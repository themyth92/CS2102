<?php
	include_once('backend/browser/browser.php');
	include_once('backend/config.php');

	session_start();
	if(isset($_SESSION[EMAIL])){
		
		$email = $_SESSION[EMAIL];
		
		if(!checkSession($email)){
			redirectUser('index.php');
		}
	}
	else{
		redirectUser('index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Your booking</title>
		<link href = '../bootstrap/css/bootstrap.min.css' type = 'text/css' rel = 'stylesheet'>
	    <link href = 'css/main.css' type = 'text/css' rel ='stylesheet'>
	    <link href = 'css/manage.css' type = 'text/css' rel ='stylesheet'>
	    <link href = 'css/datepicker.css' rel = 'stylesheet'>
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src='../bootstrap/js/bootstrap.min.js'></script>
	    <script src='js/main/bootstrap-datepicker.js'></script>
	    <script src='js/main/jquery.showLoading.min.js'></script>
	    <script src="js/main/ajax.js"></script>
	    <script src='js/manage/manage.js'></script>
	</head>
	<body>
		<div id ='app' class = 'app'>
			<!--navigation bar-->
			<div id = 'navigation'>
				<div class="navbar nav">
				    <div class="navbar-inner">
				        <div class="container">
				          	<div class="nav-collapse collapse">
				              <div class="pull-right">
				                <ul class="nav pull-right">
				                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, <?php echo $email ?> <b class="caret"></b></a>
				                        <ul class="dropdown-menu">
				                            <li><a href="main.php"><i class="icon-home"></i> Home </a></li>
				                            <li class="divider"></li>
				                            <li><a href="logout.php"><i class="icon-off"></i> Logout</a></li>
				                        </ul>
				                    </li>
				                </ul>
				              </div>
				            </div>
				        </div>
				    </div>
				</div>
			</div>
			<div id = 'message' class = 'text-center'>
				<div class = 'text-error inactive'>Can not modify your booking!</div>
				<div class = 'text-success inactive'>You have modified your booking successfully!!!</div>
			</div>

			<table class="table table-condensed table-bordered table-hover">
				<thead>
					<tr>
						<th rowspan = '2'>Booking ID</th>
						<th rowspan = '2'>Hotel</th>
						<th rowspan = '2'>User name</th>
						<th rowspan = '2'>RoomType</th>
						<th rowspan = '2'>Room amount</th>
						<th rowspan = '2'>Checkin</th>
						<th rowspan = '2'>Checkout</th>
						<th rowspan = '2'>BookingDate</th>
						<th rowspan = '2' colspan = '2'>Action</th>
					</tr>
				</thead>
				<tbody id = 'main-table'>
				</tbody>
			</table>
		</div>
	</body>
</html>