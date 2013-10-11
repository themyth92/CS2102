<!DOCTYPE html>
<html>
	<head>
		<title>Hotel booking homepage</title>
		<link href = '../bootstrap/css/bootstrap.min.css' type = 'text/css' rel = 'stylesheet'>
		<link href = 'css/home.css' type = 'text/css' rel ='stylesheet'>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/login/ajax.js"></script>
    	<script src='js/login/login.js'></script>
	</head>
	<body>
		<div class= 'login-form'>
			<form class="form-horizontal" action='' method="POST">
			  <fieldset>
			    <div id="legend">
			      <legend class="">Login</legend>
			    </div>
			    <div class="control-group">
		          <div class = 'controls'>
		            <div class = 'error-msg inactive' id = 'error-msg'>
		              <p class="text-error">No account exists</p>
		            </div>
		          </div>
		        </div>
			    <div class="control-group">
			      <!-- Username -->
			      <label class="control-label"  for="username">Username</label>
			      <div class="controls">
			        <input type="text" id="username" name="username" placeholder="" class="input-xlarge">
			      </div>
			    </div>
			 
			    <div class="control-group">
			      <!-- Password-->
			      <label class="control-label" for="password">Password</label>
			      <div class="controls">
			        <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
			      </div>
			    </div>
			    <div class="control-group">
			     	<div class="controls">
			    		<div class = 'btn btn-link button-link'><a href = 'signup.php'>Don't have account yet ?</a></div>
			    	</div>
			    </div>		 
			    <div class="control-group">
			      <!-- Button -->
			      <div class="controls">
			        <button class="btn btn-primary " id = 'loginBtn'>Login</button>
			        <div class = 'preloader inactive' id = 'preloader'><img src = 'image/preloader.gif'/></div>
			      </div>
			    </div>
			  </fieldset>
			</form>
		</div>
	</body>
</html>