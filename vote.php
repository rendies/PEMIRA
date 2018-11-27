<?php
  
  session_start();

  if(!isset($_SESSION['nim'])){
    header('location:index.php');
  }

  include 'koneksi.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Pemilihan Raya</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <link rel="shortcut icon" href="logo/PEMIRA.png">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="logo/PEMIRA.png" height="75" /></a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav" >
              <li><button class="btn" data-toggle="modal" data-target="#LogoutModal" style="margin-top:35px; ">Logout</button></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>

    <div class="alertBox">
    </div>
    
    <div class="container">

<?php


$query = "select * from tipepilihan";
$exe = mysql_query($query);

$view = '';
while ($array = mysql_fetch_array($exe)){

  $view .= '<div class="row" style="margin-top:30px;">';

  $view .= '   <div class="col-lg-12 col-md-12 card-calon-title">';
  
  $title = (ucwords($array['nama']) == 'BEM')? 'Presiden BEM' : 'Anggota MPM';

  $view .= '        <p class="lead"><b>Calon ' . $title . '</b></p>';
  
  $view .= '    </div>';

  $view .= '</div>';

  $view .= '<div class="row">';

  $where = ($array['global'] == 1)? 'where fkTipePilihan = "' . $array['id'] . '"':'where fkTipePilihan = "' . $array['id'] . '" AND fkProdi="' . $_SESSION['prodi'] .'"';
  $queryCalon = "select calonpilihan.*, prodi.name as prodi, prodi.alias as alias from calonpilihan LEFT JOIN prodi ON calonpilihan.fkProdi = prodi.id ". $where;
  $exeCalon = mysql_query($queryCalon);

  while ($arrayCalon = mysql_fetch_array($exeCalon)){

    $view .= '<div class="col-lg-3 card-calon" style="min-height:475px; position:relative;">';
    $view .= '      <p  class="lead calon-name" style="line-height: 50px;font-size:1.3em; height:50px"><b >' . $arrayCalon['nama'] . '</b></p>';
    $view .= '      <img src="' . $arrayCalon['foto'] . '" alt="' . $arrayCalon['nama'] . '" class="foto" />';
    $view .= '<dl class="dl-horizontal">';

    $view .= '      <dt style="width:75px">Prodi :</dt><dd style="margin-left:90px">' . $arrayCalon['prodi'] . ' (' . $arrayCalon['alias'] . ')</dd>';
    $view .= '      <dt style="width:75px">Deskripsi :</dt><dd style="margin-left:90px">' . $arrayCalon['deskripsi'] . '</dd>';
    $view .= '</dl>';
    $view .= '      <p>';

    

    $queryCheck = "SELECT COUNT( polling.id ) AS  `count` FROM polling LEFT JOIN pemilih ON pemilih.id = fkPemilih where fkTipePilihan = '" . $array['id'] . "' AND nim = " . $_SESSION['nim'] ;

    $exeCheck = mysql_query($queryCheck);

    $arrayCheck = mysql_fetch_array($exeCheck);
 
    if (isset($arrayCheck['count']) && empty($arrayCheck['count'])):

      $view .= '<a style=" bottom:20px; left:45px;" class="btn btn-primary btn-md btn-block" data-loading-text="Loading..." data-dismiss="alert" data-value="'.$arrayCalon['id'].'" name="'.$array['id'].'" href="#" role="button"><b>PILIH</b></a>';
    
    endif;
    
    $view .= '</p>';
    
    $view .= '</div>';

  }

  $view .= '</div>';

}



echo $view;
?>

      
    </div> <!-- /container -->

    <div id="footer">
      <div class="container">
        <p class="text-muted credit">Created By : Himma MI @2013</p>
      </div>
    </div>

    <div class="modal fade" id="LogoutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="import.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Konfirmasi Logout</h4>
            </div>
            <div class="modal-body">
              Ketika anda logout, anda tidak diperkenankan untuk login kembali.<br />
              Ketika anda belum memilih, maka dengan logout anda dianggap golput

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
              <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">

      $(document).on('click','.card-calon a.btn',function(){

          var name = $(this).attr('name');

          var value = $(this).data('value');

          $('a[name=' + name + ']').hide();

          $.post('voteAction.php', {'id':name, 'value':value}, function(data){

            if (data == 'success'){

              $(this).parent().html('<center class="disabled"><b>Selected</b></center>');

              

            }
            else
            {

              $(this).alert();

            }

           

          });

          return false;

      });

  </script>
  </body>
</html>