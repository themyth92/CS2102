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
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src='../bootstrap/js/bootstrap.min.js'></script>
	    <script src="js/main/ajax.js"></script>
	    <script src='js/main/main.js'></script>
	</head>
	<body>
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
			                            <li><a href="#"><i class="icon-cog"></i> Manage booking</a></li>
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

		<!-- search side bar -->
		<div id = 'search-side-bar' class="btn-group btn-group-vertical side-bar well">
			<!-- location -->
			<div>
				<label>Search location :</label>
				<div class="input-prepend">
					 <span class="add-on"><i class="icon-search"></i></span>
					<input class="span4" id="location-search" type="text" placeholder="Input your location here">
				</div>
			</div>

			<!-- price range -->
			<div id = 'price-range-search'>
				<label>Price range:</label>
				<div class="input-prepend input-append full-width">
					<div class="btn-group">
					 		<span class="add-on">From</span>
							<input class="span1" id="price-from" type="text"  value = '0'>
							<span class="add-on">$</span>
					</div>
					<div class="btn-group pull-right">
					 		<span class="add-on">To</span>
							<input class="span1" id="price-to" type="text" value = '0'>
							<span class="add-on">$</span>
					</div>

				</div> 
			</div>

			<!--Feature search-->
			<div>
				<label>Features :</label>
				<div class="input">
	              <ul class="inputs-list">
	                <li>
	                  <label>
	                    <input type="checkbox" id = 'feature-1'>
	                    <span>Swimming pool</span>
	                  </label>
	                </li>
	                <li>
	                  <label>
	                    <input type="checkbox" id = 'feature-2'>
	                    <span>Fitness club</span>
	                  </label>
	                </li>
	              </ul>
	            </div>
			</div>

			<!--Room category search-->
			<div>
				<label>Room types :</label>
				<div class="input">
	              <ul class="inputs-list">
	                <li>
	                  <label>
	                    <input type="checkbox" id = 'room-type-1'>
	                    <span>Single</span>
	                  </label>
	                </li>
	                <li>
	                  <label>
	                    <input type="checkbox" id = 'room-type-2'>
	                    <span>Double</span>
	                  </label>
	                </li>
	                <li>
	                  <label>
	                    <input type="checkbox" id = 'room-type-3'>
	                    <span>Superior</span>
	                  </label>
	                </li>
	                <li>
	                  <label>
	                    <input type="checkbox" id = 'room-type-4'>
	                    <span>Standard</span>
	                  </label>
	                </li>
	              </ul>
	            </div>
			</div>

			<!--submit button-->
			<div class = 'align-center'>
				<input id = 'search-btn' class="btn btn-primary" type="submit" value = 'Go!'>
			</div>
		</div>
	</body>
</html>