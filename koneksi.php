<?php

define("ROOT_PATH", '/'. basename(dirname(__FILE__)));

$username = 'root';
$password = '';
$host	= 'localhost';
$db = 'pemira';

$connection = mysql_connect($host,$username,$password) or die('Cannot Connect');
$db = mysql_select_db($db) or die('db cannot found');

?>