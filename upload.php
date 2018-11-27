<?php
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  session_start();

  if(!isset($_SESSION['admin'])){
    header('location:admin.php');
  }

  include 'koneksi.php';

$salt = date("Y-m-d-H-i-s");

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0 || !isset($_REQUEST['idCalonModal']))
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {

      $name = "images/".$salt . $_FILES["file"]["name"];

    if (file_exists($name))
      {
      echo $name . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
       $name);
      
      $sql = "UPDATE `pemira`.`calonpilihan` SET `foto` = '$name' WHERE `calonpilihan`.`id` = $_REQUEST[idCalonModal];";

      $exe = mysql_query($sql);

      header('location:adminpilihan.php');

      }
    }
  }
else
  {
  echo "Invalid file";
  }

?>