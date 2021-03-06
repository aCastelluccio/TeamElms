<!DOCTYPE html>
<?php

session_start();

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="login">
    <link rel="icon" href="../../favicon.ico">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="/_layout/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/_layout/bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/_layout/bootstrap/signin.css" rel="stylesheet">

  </head>

  <body class="body">

    <div class="container">

      <form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">Welcome</h2>
          
        <label for="email" class="sr-only">Email</label>
        <input type="email" id="email" name ="email" value="<?php echo $_SESSION['remember']; ?>" class="form-control" placeholder="Enter email" required autofocus>
          
        <label for="password" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

        <div class="checkbox">
            
          <label>
            <input type="hidden" value="NO" id="rememberSession" name="rememberSession">
            <input type="checkbox" value="YES" id="rememberSession" name="rememberSession" <?php if (isset($_SESSION['isChecked'])) { ?> checked <?php } ?>> Remember me
          </label>    
            
        </div>
          
        <button class="btn btn-lg btn-primary btn-block" type="submit" id="signinButton">Login</button>
          
      </form>
        
      <form class="form-signin" action="register.html" method="post">
          <button class="btn btn-lg btn-primary btn-block" type="submit" id="registerButton">Register an Account</button>
      </form>
        
      <div class="text-center">
          <a class="d-block small" href="password_reset.html">Forgot Password?</a>
      </div>

    </div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/_layout/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
    
</html>
