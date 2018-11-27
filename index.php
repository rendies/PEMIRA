<?php
  
  session_start();

  if(isset($_SESSION['nim'])){
    header('location:vote.php');
  }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Bootstrap 101 Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatepemira.css" rel="stylesheet">
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
    
    <div class="wrap">
        <div class="header">
            <img src="logo/PEMIRA.png" width="30%" height="30%" 
                 style="margin-left: 7%; margin-top: 20px; margin-bottom: 20px;"/>
            <img src="logo/PEMIRAWORD.png" width="50%" height="50%" 
                 style="margin-left: 2%; margin-bottom: 30px;"/>  
        </div>
        <div class="mid">
            <img src="logo/panah.png" width="50"
                   style="margin-left: 28%;"/>
            <br/><br/><br/>

            <form class="form-signin" action="signin.php">
          
              <input type="text" class="form-control textbox" placeholder="NIM" name='nim' required autofocus>
              <br>
             
              <button class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
            </form>
            
           <br/><br/><br/><br/>
        </div>
        <div class="footer">
            <br/>
            © Manajemen Informatika @ 2013
            <br/><br/>
        </div>
        
        <?php
        // put your code here
        ?>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>