<?php
require_once "helpers.php" ;

if (isset($_REQUEST[session_name()])) session_start();

$_SESSION = [];

$url = '/index.php';
header('Location: ' . $url);
exit;