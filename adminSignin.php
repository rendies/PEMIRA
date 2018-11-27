<?php

session_start();

include 'koneksi.php';

$_SESSION['username'] = htmlspecialchars($_REQUEST['username']);

$query = "select * from admin where username = '" . htmlspecialchars(addslashes($_REQUEST['username'])) . "' AND password = '". md5($_REQUEST['password']) . "'" ;

$exe = mysql_query($query);

$array = mysql_fetch_array($exe);

$_SESSION['admin'] = true;

header('location:adminindex.php');

?>