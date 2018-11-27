<?php

include('koneksi.php');

session_start();

if (isset($_SESSION['nim'])):

	$query = "UPDATE `pemira`.`pemilih` SET `chosed` = '1' WHERE `pemilih`.`nim` = " . $_SESSION['nim'] .";";

  	$exe = mysql_query($query);

endif;

session_destroy();

header('location:index.php');

?>