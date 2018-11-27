<?php
session_start();
include 'koneksi.php';

$_SESSION['nim'] = htmlspecialchars($_REQUEST['nim']);

$query = "select * from pemilih where nim = " . $_REQUEST['nim'] . " ";
$exe = mysql_query($query);
$array = mysql_fetch_array($exe);

if(!$array || !$exe):

	session_destroy();

	header('location:index.php');

endif;

$_SESSION['prodi'] = $array['fkProdi'];

$_SESSION['chosed'] = $array['chosed'];



if($array['chosed']):

	header('location:chosed.php');

else:

	header('location:vote.php');

endif;

?>