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
	    <script src="js/main/ajax.js"></script>
	    <script src='js/main/main.js'></script>
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
				                            <li><a href="manage.php"><i class="icon-cog"></i> Manage booking</a></li>
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
					<div class="input-prepend control-group">
						 <span class="add-on"><i class="icon-search"></i></span>
						<input class="span4" id="location-search" type="text" placeholder="Input your location here">
					</div>
				</div>

				<!-- price range -->
				<div id = 'price-range-search'>
					<label>Price range:</label>
					<div class="input-prepend input-append full-width">
						<div class="btn-group control-group">
						 		<span class="add-on">From</span>
								<input class="span1" id="price-from" type="text"  value = '0'>
								<span class="add-on">$</span>
						</div>
						<div class="btn-group pull-right control-group">
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
		                    <span>Superior Single</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="checkbox" id = 'room-type-2'>
		                    <span>Superior Double</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="checkbox" id = 'room-type-3'>
		                    <span>Standard Single</span>
		                  </label>
		                </li>
		                <li>
		                  <label>
		                    <input type="checkbox" id = 'room-type-4'>
		                    <span>Standard Double</span>
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

			<!-- main panel -->
			<div id = 'main-panel-msg' class = 'text-error inactive main-panel'>No data retrieve</div>
			<div id = 'main-panel' class = 'main-panel'>
				
			</div>

			<!-- booking markup-->
			<div id="book-popup" class="modal hide fade" tabindex="-1" role="dialog" data-id aria-labelledby="modelName" aria-hidden="true">
			  
			  <!-- hotel name -->
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			    <h3 id="model-name" class = 'text-info'></h3>
			  </div>

			  <!-- body pop up-->
			  <div class="modal-body">
			  	<div class = 'text-error inactive' id = 'book-error'></div>
			  	<div class = 'text-success inactive' id = 'book-success'>Success!</div>
			  	<!--calendar-->
			  	<div class = 'modal-body-group'>
			  		<div id="startDate" class="input-append date" data-date data-date-format="yyyy-mm-dd">
			  			<label class="control-label">Start Date</label>
					    <input class="span2" size="16" type="text" readonly value>
					    <span class="add-on"><i class = "icon-calendar"></i></span>
					 </div>
					 <div id="endDate" class="input-append date" data-date data-date-format="yyyy-mm-dd">
					 	<label class="control-label">End Date</label>
					    <input class="span2" size="16" type="text" readonly value>
					    <span class="add-on"><i class = "icon-calendar"></i></span>
					 </div>
			  	</div>

			  	<!--room type -->
			  	<div class = 'modal-body-group'>
				  	<div>
					  	<div class="control-group">
						    <label class="control-label">Superior Single</label>
						    <div class="controls">
						      <input type="number" min = "0" step = "1" id="ssroom" class = 'span3'>
						    </div>
						</div>
						<div class="control-group">
						    <label class="control-label">Superior Double</label>
						    <div class="controls">
						      <input type="number" min = "0" step = "1" id="sdroom" class = 'span3'>
						    </div>
						</div>
					</div>
					<div>
						<div class="control-group">
						    <label class="control-label">Standard Single</label>
						    <div class="controls">
						      <input type="number" min = "0" steap = "1" id="stsroom" class = 'span3'>
						    </div>
						</div>
						<div class="control-group">
						    <label class="control-label">Standard Double</label>
						    <div class="controls">
						      <input type="number" min = "0" step = "1" id="stdroom" class = 'span3'>
						    </div>
						</div>  
					</div>
				</div>  
			  </div>

			  <!-- footer pop up --> 
			  <div class="modal-footer">
			  	<div class = 'preloader text-error inactive' id = 'book-error-msg'>We can not book your room due to availability of the hotel</div>
			  	<div class = 'preloader text-success inactive' id = 'book-success-msg'>Success!!!</div>
			    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			    <button class="btn btn-primary book">Book</button>
			  </div>

			</div>
		</div>
	</body>
</html>