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
    <form class="form-horizontal" action='' method="POST">
      <fieldset>
        <div id="legend">
          <legend class="">Register</legend>
        </div>
        <div class="control-group">
          <div class = 'controls'>
            <div class = 'error-msg inactive' id = 'error-msg'>
              <p class="text-error">Duplicate user account</p>
            </div>
          </div>
        </div>
        <div class="control-group">
          <div class = 'controls'>
            <div class = 'success-msg inactive' id = 'success-msg'>
              <p class="text-success">Success! You can <a href = 'index.php'>click here</a> to login</p>
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
          <!-- Button -->
          <div class="controls">
            <button class="btn btn-primary " id = 'registerBtn'>Register</button>
            <div class = 'preloader inactive' id = 'preloader'><img src = 'image/preloader.gif'/></div>
          </div>
        </div>
      </fieldset>
    </form>
  </body>
</html>