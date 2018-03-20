<?php
$servername = "localhost";
$username 	= "root";
$password 	= "aikya@123";
$database   = "karnatakadhd_subdomain";

require_once ('MysqliDb.php');

$db = new MysqliDb ($servername, $username, $password,$database);
?>
