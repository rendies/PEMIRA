<?php
  
  session_start();

  if(!isset($_SESSION['admin'])){
    header('location:admin.php');
    die();
  }

  include 'koneksi.php';
  $data = '';
  $nama_calon = '';

?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="logo/PEMIRA.png">
	<script src="js/jquery.js"></script>
	<script type="text/javascript">
		var this_is_the_time = 0;
	</script>
    <title>Pemira ADMIN</title>

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
              <li class="active"><a href="adminindex.php">Pemilih</a></li>
              <li><a href="adminresult.php">Hasil Pilihan</a></li>
              <li><a href="adminpilihan.php">Manage Pilihan</a></li>
              <li><a href="adminlogout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>

      <!-- Begin page content -->
      <div class="container">
        <div class="page-header">
          <h1>Hasil Pemilihan</h1>
        </div>
        <a href="?type=sebaran" class="btn btn-primary btn-sm">Sebaran Hasil</a>
        <br />
        <br />
        <table class="table table-bordered table-striped table-hover with-check" style="text-align:center">
          <tbody>
            
            <?php
    					
              if (isset($_GET['type'])) {

    					 if($_GET['type']=="sebaran") {

                $query        = "SELECT COUNT(pemilih.id) as counter, RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) as tahun
                                  FROM pemilih
                                  WHERE pemilih.id NOT IN(select fkPemilih from polling where polling.fkTipePilihan = 1)
                                  GROUP BY RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) ORDER BY RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) DESC";          

                $exe = mysql_query($query);

                $x = 0;
                $categories = '';
                $data = [];

                while ($array = mysql_fetch_array($exe)) {

                  $querySebaran = "SELECT COUNT( pemilih.id ) as counter , RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) as tahun , calonpilihan.nama as nama
                                  FROM polling
                                  LEFT JOIN calonpilihan ON calonpilihan.id = fkCalonPilihan
                                  RIGHT JOIN pemilih ON pemilih.id = fkPemilih
                                  WHERE calonpilihan.fkTipePilihan =1 
                                        AND RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) = '$array[tahun]'
                                  GROUP BY RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) , calonpilihan.nama";

                  $queryGolput  = "SELECT COUNT( pemilih.id ) as counter , RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) 
                                  FROM pemilih
                                  WHERE pemilih.id NOT IN(select fkPemilih from polling where polling.fkTipePilihan = 1)
                                        AND RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) = '$array[tahun]'
                                  GROUP BY RIGHT( LEFT( pemilih.nim, 6 ) , 4 ) ";
                  
                  $exeSebaran = mysql_query($querySebaran);

                  $exeGolput = mysql_query($queryGolput);

                  $arrayGolput = mysql_fetch_array($exeGolput);

                  if ($array['tahun'] == 2011):

                    $tingkat = 3;

                  elseif ($array['tahun'] == 2012):

                    $tingkat = 2;

                  else:

                    $tingkat = 1;

                  endif;

                  ?>

                  <?php

                    if ($x==0) {
                      echo '<tr>';
                      echo '<td colspan="12" style="width:100%">';
                      echo ' <div id="chart" style="width:100%; height: 400px; margin: 0 auto;"></div>';
                      echo '</td>';
                      echo '</tr>';

                    }

                    ?>

                  <tr>

                    <td rowspan="1" colspan="6" style="vertical-align:center">
            
                      <?php echo '<h3><b>Tingkat ' . $tingkat . '</b></h3>';  ?>
                    
                    </td>

                  </tr>

                  <tr>

                    <td colspan="3" width="<?=1140/2?>px">
                      <h5>Total : <?php echo $array['counter']; ?></h5>
                    </td>

                    <td colspan="3">
                      <h5>GolPut : <?php echo $arrayGolput['counter']; ?></h5>
                    </td>

                    
                    
                  </tr>
                                   

                  <tr>

                    <?php
                    

                    while ($arraySebaran = mysql_fetch_array($exeSebaran)) {

                      if (!isset($data[$arraySebaran['nama']])):

                        $data[$arraySebaran['nama']] = [];

                        $data[$arraySebaran['nama']][$x] = $arraySebaran['counter'];

                      else:

                        $data[$arraySebaran['nama']][$x] = $arraySebaran['counter'];

                      endif;

                      ?>
                      
                        <td rowspan='1' colspan='2' style="text-align:center; width:<?=1140/3?>px">
                            
                          <h5><?php echo $arraySebaran['nama']; ?></h5>
                          <h3><b><?php echo $arraySebaran['counter']; ?></b></h3>

                        </td>  
                      
                      <?php 

                    }

                    $categories .= "'Tingkat $tingkat',";

                    if (!isset($data['GolPut'])):

                      $data['GolPut'] = [];

                      $data['GolPut'][$x] = $arrayGolput['counter'];

                    else:

                      $data['GolPut'][$x] = $arrayGolput['counter'];

                    endif;

                    $x++;
                  
                  ?>

                  </tr>

                  

          <?php

               }

             }
          				
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
          <form action="import.php" method="post" enctype="multipart/form-data">
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

    <div class="modal fade" id="DeleteAllModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="deletePemilih.php" method="post">
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
    
    <script src="js/bootstrap.min.js"></script>
	<script src="js/highcharts.js"></script>
	<script src="js/modules/exporting.js"></script>
	<script type="text/javascript">
$(function () {
        $('#chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Sebaran Pemilih Presiden BEM'
            },
            subtitle: {
                text: 'PEMIRA 2013'
            },
            xAxis: {
                categories: [
                    <?=$categories?>
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Mahasiswa'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y} Mahasiswa</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    pointPadding: 0.2,
                    borderWidth: 0
                },

                dataLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +'%';
                        }
                    }
            },
            series: [
            <?php
            foreach ($data as $key => $value) {
              
                echo "
                {
                
                  name: '$key',
                  data: [" . implode(',', $value) . "]
    
                },";

            }

            ?>
            ]
        });
    });
    

    </script>
	

</body></html>