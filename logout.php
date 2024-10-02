<?php
require_once("database/config.php"); 
 
session_destroy();
header('location:login.php');
?>


