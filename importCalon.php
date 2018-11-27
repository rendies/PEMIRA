<?php
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  session_start();

  if(!isset($_SESSION['admin'])){
    header('location:admin.php');
  }

  include 'koneksi.php';
  include 'library/csv/importcsv.php';

  $allowedExts = array("csv");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ( in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    
    if (file_exists("data/calon.csv"))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      	move_uploaded_file($_FILES["file"]["tmp_name"],"data/calon.csv");

	  	$data = csv_to_array('data/calon.csv', ',');
  		
  		if(!empty($data)){

			$selecQuery = "SELECT * from prodi";

			$exeSelect = mysql_query($selecQuery);

			$prodi = [];

			while($array = mysql_fetch_array($exeSelect)) {

				$prodi[$array['alias']] = $array['id'];

			}

      $selecQuery = "SELECT * from tipepilihan";

      $exeSelect = mysql_query($selecQuery);

      $tipe = [];

      while($array = mysql_fetch_array($exeSelect)) {

        $tipe[$array['nama']] = $array['id'];

      }

  			foreach ($data as $key => $value) {

  				$queryExist = "select count(*) as count from calonpilihan where fkTipePilihan = " . trim(strtoupper($tipe[$value['TIPE']])) . " AND nama ='" . $value['NAMA'] ."'  AND fkProdi = " . trim(strtoupper($prodi[$value['PRODI']])) . " ";

  				$exeExist = mysql_query($queryExist);

  				$total = mysql_fetch_array($exeExist);

  				if(empty($total['count'])) {
  				
	  				$sql = "INSERT INTO `pemira`.`calonpilihan` (`id`, `fkProdi`, `fkTipePilihan`, `nama`, `deskripsi`, `foto`) VALUES (NULL, ".trim(strtoupper($prodi[$value['PRODI']])).", ".trim(strtoupper($tipe[$value['TIPE']])).", '$value[NAMA]', '$value[DESKRIPSI]', '');";

	  				$exeInsert = mysql_query($sql);

  				}
          else {
            $sql = "UPDATE `pemira`.`calonpilihan` SET `deskripsi` = '$value[DESKRIPSI]' where fkProdi = " . trim(strtoupper($prodi[$value['PRODI']])) . " AND fkTipePilihan = " . trim(strtoupper($tipe[$value['TIPE']])) . " AND nama ='" . $value['NAMA'] ."'";

            $exeInsert = mysql_query($sql);
          }
  			}

  			unlink('data/calon.csv');

  			header('location:adminpilihan.php');

  		}

      }
    }
  }
else
  {
  echo "Invalid file";
  }

?>