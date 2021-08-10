<?php
echo "Welcome to my app";
session_start();
require_once "./app/Bridge.php";
$myapp = new app();
?>