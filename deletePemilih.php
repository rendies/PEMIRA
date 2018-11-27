<?php
  
  session_start();

  if(!isset($_SESSION['admin'])){
    header('location:admin.php');
  }

  include 'koneksi.php';

  $query = "Delete FROM pemilih";

  $exe = mysql_query($query);

  header('location:adminindex.php');