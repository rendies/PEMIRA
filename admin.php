<?php
  
  session_start();
  
  if(isset($_SESSION['admin'])){
    header('location:adminindex.php');
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    
    <div class="container">
      <div class="form-signin" style="text-align:center;">
        <h1>PEMIRA<sup>web</sup></h1>
      </div>
      <div class="form-signin" style="border:1px silver solid; text-align:center; background:white;">
        <h2 style="margin-top:0px;"><small>Admin</small></h2>
        <form class="form-signin" action="adminSignin.php">
          
          <input type="text" class="form-control" placeholder="Username" name='username' required autofocus>
          <br>
         
          <input type="password" class="form-control" placeholder="Password" name='password' required >
          <label class="checkbox">
           
          </label>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
        </form>
      </div>
    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>