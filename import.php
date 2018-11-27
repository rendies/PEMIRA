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
    
    if (file_exists("data/pemilih.csv"))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      	move_uploaded_file($_FILES["file"]["tmp_name"],"data/pemilih.csv");

	  	$data = csv_to_array('data/pemilih.csv', ',');
  		
  		if(!empty($data)){

			$selecQuery = "SELECT * from prodi";

			$exeSelect = mysql_query($selecQuery);

			$prodi = [];

			while($array = mysql_fetch_array($exeSelect)) {

				$prodi[$array['alias']] = $array['id'];

			}

  			foreach ($data as $key => $value) {

  				$queryExist = "select count(*) as count from pemilih where nim = '" . $value['NIM'] . "'";

  				$exeExist = mysql_query($queryExist);

  				$total = mysql_fetch_array($exeExist);

  				if(empty($total['count'])) {
  				
	  				$sql = "INSERT INTO `pemira`.`pemilih` (`id`, `nim`, `nama`, `email`, `fkProdi`, `verifyCode`, `chosed`) VALUES (NULL, '$value[NIM]', '$value[NAMA]', '$value[EMAIL]', '" . $prodi[$value['ALIAS']] . "', '" . substr(SHA1($value['NIM'] . $value['NAMA']), 15, 5) . "', NULL);";

	  				$exeInsert = mysql_query($sql);

  				}
          else {
            $sql = "UPDATE `pemira`.`pemilih` SET `nama` = '$value[NAMA]', `email` = '$value[EMAIL]', `fkProdi` = '".$prodi[$value['ALIAS']]."' WHERE `pemilih`.`nim` = $value[NIM];";

            $exeInsert = mysql_query($sql);
          }
  			}

  			unlink('data/pemilih.csv');

  			header('location:adminindex.php');

  		}

      }
    }
  }
else
  {
  echo "Invalid file";
  }

?>