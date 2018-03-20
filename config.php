<?php
date_default_timezone_set('Asia/Kolkata');
error_reporting(0);
session_start();

if (!isset($_SESSION['userid']) or intval($_SESSION['userid']) == 0) {
    header("Location: index.php");
    exit;
}

require dirname(__FILE__) . '/dbconnect.php';
?>