<?php
session_start();

  if(!isset($_SESSION['nim'])){
    header('location:index.php');
  }

  include 'koneksi.php';


  	if (is_numeric($_REQUEST['id']) && is_numeric($_REQUEST['value'])):

  		$query = "SELECT id FROM pemilih where nim = " . $_SESSION['nim'];

  		$exe = mysql_query($query);

  		$array = mysql_fetch_array($exe);

  		$idPemilih = $array['id'];	

  		$query = "INSERT INTO `pemira`.`polling` (`id`, `fkPemilih`, `fkTipePilihan`, `fkCalonPilihan`, `tanggalPilih`) 
  					VALUES (NULL, '$idPemilih', '$_REQUEST[id]', '$_REQUEST[value]', ' " . date('Y-m-d H:i:s') . "') ";

  		$exe = mysql_query($query);

  		if ($exe) { 

  			echo json_encode(['success'=>$exe]);

  		}

  		else {
  			echo json_encode(['success'=>'false']);
  		}

  	else:
  			echo json_encode(['success'=>'false']);

  	endif;