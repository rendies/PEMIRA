<?php
  
  session_start();

  if(!isset($_SESSION['admin'])){
    header('location:admin.php');
  }

  include 'koneksi.php';

?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title>Sticky Footer Navbar Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="">

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
            <a class="navbar-brand" href="#">Pemira Admin</a>
          </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
              <li ><a href="adminindex.php">Pemilih</a></li>
              <li><a href="adminresult.php">Hasil PEMIRA</a></li>
              <li class="active"><a href="adminpilihan.php">Manage Pilihan</a></li>
              <li><a href="adminlogout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>List Calon Pilihan</h1>
        </div>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ImportModal">Import</button>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#DeleteAllModal">Hapus Semua</button>
        <br />
        <br />
        <table class="table table-bordered table-striped table-hover with-check">
                  <thead>
                    <tr>
                      <th>Tipe Pilihan</th>
                      <th>Prodi</th>
                      <th>Nama</th>
                      <th>Foto</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      $query = 'select calonpilihan.id as id, prodi.name as prodi, tipepilihan.nama as tipe, calonpilihan.nama as nama, calonpilihan.foto as foto from calonpilihan left join prodi on fkProdi = prodi.id left join tipepilihan on fkTipePilihan = tipepilihan.id Order By  fkTipePilihan, prodi.name ';

                      $exe = mysql_query($query);

                      while($array=mysql_fetch_array($exe)) {

                    ?>
                    <tr>
                      <td><?php echo $array['tipe']; ?></td>
                      <td><?php echo $array['prodi']; ?></td>
                      <td><?php echo $array['nama']; ?></td>
                      <td><img src="<?php echo $array['foto']; ?>" width="50" height="50"><input type="hidden" name="idCalon" value="<?php echo $array['id']; ?>"><a class="upload-button btn btn-sm" data-toggle="modal" data-target="#upload">Upload</a></td>
                    </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                </table>
      </div>
    </div>

    <div id="footer">
      <div class="container">
        <p class="text-muted credit">Created By : Himma MI @2013</p>
      </div>
    </div>

    <div class="modal fade" id="ImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="importCalon.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Import dari CSV</h4>
            </div>
            <div class="modal-body">
              <input type="file" name="file">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Upload Foto</h4>
            </div>
            <div class="modal-body">
              <input type="file" name="file">
              <input type="hidden" name="idCalonModal">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="DeleteAllModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="deleteCalon.php" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">Konfirmasi Delete Data</h4>
            </div>
            <div class="modal-body">
              Anda Yakin akan Menghapus Semua Data
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Hapus</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

      $('.upload-button').on('click', function() {

        $('input[name=idCalonModal]').val($(this).parent().find('input[name=idCalon]').val());

      })
          
    </script>

</body></html>