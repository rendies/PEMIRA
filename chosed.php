<?php
  
  session_start();

  session_destroy();

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
        <h2 style="margin-top:0px;"><small>Anda Telah Menggunakan Hak Memilih anda, Terima Kasih!</small></h2>
        <p><b><a href="index.php"><< Kembali</a><b></p>
      </div>
    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

  <script type="text/JavaScript">
    setTimeout(function () {
       window.location.href = "index.php"; //will redirect to your blog page (an ex: blog.html)
    }, 2000);
  </script>
  </body>
</html>