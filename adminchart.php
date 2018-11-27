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
        <a href="?type=BEM" class="btn btn-primary btn-sm">Ketua BEM</a>
        <a href="?type=sebaran" class="btn btn-primary btn-sm">Sebaran Hasil</a>
        <a href="?type=MI" class="btn btn-primary btn-sm InviteByMail">MPM MI</a>
		<a href="?type=TPM" class="btn btn-primary btn-sm InviteByMail">MPM TPM</a>
		<a href="?type=P4" class="btn btn-primary btn-sm InviteByMail">MPM P4</a>
		<a href="?type=TO" class="btn btn-primary btn-sm InviteByMail">MPM TO</a>
		<a href="?type=TAB" class="btn btn-primary btn-sm InviteByMail">MPM TAB</a>
		<a href="?type=MK" class="btn btn-primary btn-sm InviteByMail">MPM MK</a>
		<a href="?type=TPHP" class="btn btn-primary btn-sm InviteByMail">MPM TPHP</a>
        <br />
        <br />
        <table class="table table-bordered table-striped table-hover with-check">
                  <tbody>
                    <?php
					if (isset($_GET['type']))
					{
					if($_GET['type']=="BEM")
  				{
            $query="SELECT calonpilihan.nama AS Nama_Calon,
  					COUNT(polling.id)AS Hasil,calonpilihan.id AS ID_Calon FROM calonpilihan LEFT JOIN 
  					polling ON polling.fkCalonPilihan = calonpilihan.id
  					INNER JOIN prodi ON calonpilihan.fkProdi = prodi.id
  					WHERE calonpilihan.fkTipePilihan = 1
  					GROUP BY calonpilihan.nama";

            $queryTotal = "SELECT COUNT( * ) AS COUNT FROM polling left join pemilih ON fkPemilih = pemilih.id left join prodi on fkProdi = prodi.id where  fkTipePilihan = 1";
          }
          
					else 
					{
            $query="SELECT calonpilihan.nama AS Nama_Calon,
					COUNT(polling.id)AS Hasil,calonpilihan.id AS ID_Calon FROM calonpilihan LEFT JOIN
					polling ON polling.fkCalonPilihan = calonpilihan.id INNER JOIN prodi ON calonpilihan.fkProdi = prodi.id WHERE prodi.alias = '$_GET[type]' AND calonpilihan.fkTipePilihan = 2 GROUP BY calonpilihan.nama";
					
          $queryTotal = "SELECT COUNT(*) as 'COUNT' FROM polling left join pemilih ON fkPemilih = pemilih.id left join prodi on fkProdi = prodi.id where prodi.alias = '$_GET[type]' AND fkTipePilihan = 2";

          }


          $exeTotal = mysql_query($queryTotal);

          $arrayTotal = mysql_fetch_array($exeTotal);

					$exe = mysql_query($query);

					$x=0;
					
          while($array=mysql_fetch_array($exe)) {
					
      				$data .= "{
      							y: ".$array['Hasil'].",
      							color: colors['". $x ."'],
      							drilldown: {
      								name: '".$array['Nama_Calon']."',
      								color: colors[ '".$x."']
      								}
      						},";
      						
      				$nama_calon .= "'". $array['Nama_Calon'] . "',";
					
					
          ?>
                    <tr>
					<td colspan="2">
						
		<script type="text/javascript">
				$({countNum: $(<?php echo "'#counter".trim($x)."'";?>).text()}).animate({countNum:<?php echo $array['Hasil']+1;?>},
					{
						duration: <?php echo $array['Hasil']*300; ?>,
						easing:'linear',
						step: function(){
							$(<?php echo "'#counter$x'";?>).text(Math.floor(this.countNum));
						},
						complete: function(){
							this_is_the_time += 1;
							
							console.log(this_is_the_time);
							
							if(this_is_the_time >= <?php echo ($_REQUEST['type'] == 'BEM')? 3 : 5; ?>){
								
								$('#chart').show();
								
							}
						}
					}
				);
		</script>
			
					<?php echo $array['Nama_Calon']; ?><br/>
					<h1><div id=<?php echo "\"counter".trim($x)."\"";?>>0</div></h1>
					</td>



					<?php if($x==0){?>
                      <td rowspan="5" style="width:700px">
					  <div id="chart" style="width:650px; height: 400px; margin: 0 auto; display:none"></div>
					  <?php }?>
					  
					<?php if($x==0){?>
                      </td>
					  <?php }?>
                    </tr>

                    
                    <?php
					$x++;
                    }
                    ?>
                    <tr>
                      <td>

            
                    Total Pemilih<br/>
          <h1><div id=''><?php echo $arrayTotal['COUNT'];?></div></h1>
          </td>
                    </tr>
                    <?php
					}
					else
					{}
					
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
      
        var colors = Highcharts.getOptions().colors,
            categories = [<?php echo substr($nama_calon, 0, -1);?>],
            name = 'Made in MI 2013     ',
            data = [<?php echo $data; ?>];
    
        function setChart(name, categories, data, color) {
			chart.xAxis[0].setCategories(categories, false);
			chart.series[0].remove(false);
			chart.addSeries({
				name: name,
				data: data,
				color: color || 'white'
			}, false);
			chart.redraw();
        }
    
        var chart = $('#chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Hasil Pemira 2013'
            },
            subtitle: {
                text: 'source: polman.astra.ac.id/pemira'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: 'Our Vote'
                }
            },
            plotOptions: {
                column: {
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: colors[0],
                        style: {
                            fontWeight: 'bold'
                        },
                        formatter: function() {
                            return this.y +'';
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +':<b>'+ this.y +' suara</b><br/>';
                    return s;
                }
            },
            series: [{
                name: name,
                data: data,
                color: 'white'
            }],
            exporting: {
                enabled: false
            }
        })
        .highcharts(); // return chart
    });
    

		</script>
	

</body></html>