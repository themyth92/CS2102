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
		<title>Main page</title>
		<link href = '../bootstrap/css/bootstrap.min.css' type = 'text/css' rel = 'stylesheet'>
	    <link href = 'css/main.css' type = 'text/css' rel ='stylesheet'>
	    <link href = 'css/datepicker.css' rel = 'stylesheet'>
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src='../bootstrap/js/bootstrap.min.js'></script>
	    <script src='js/main/bootstrap-datepicker.js'></script>
	    <script src='js/main/jquery.showLoading.min.js'></script>
	    <script src="js/manage/ajax.js"></script>
	    <script src='js/manage/main.js'></script>
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


			<table class="table table-condensed table-bordered table-hover">
				<thead>
					<tr>
						<th>Booking ID</th>
						<th>Hotel</th>
						<th style = 'text-align:center' colspan = '8'>RoomType</th>
						<th>Checkin</th>
						<th>Checkout</th>
						<th>BookingDate</th>
						<th style = 'text-align:center' colspan = '2'>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>111</td>
						<td>test</td>
						<td>Sup Single</td>
						<td><input class='span1' value = '1'></td>
						<td>Sup Double</td>
						<td><input class='span1' value = '1'></td>
						<td>Stan Single</td>
						<td><input class='span1' value = '1'></td>
						<td>Stan Double</td>
						<td><input class='span1' value = '1'></td>
						<td><input class='span1' value = '1'></td>
						<td><input class='span1' value = '1'></td>
						<td><input class='span1' value = '1'></td>
						<td><button class = 'btn btn-primary'>Modify</button></td>
						<td><button class = 'btn btn-danger'>Delete</button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>