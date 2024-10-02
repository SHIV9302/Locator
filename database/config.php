<?php
session_start();

// database configuratio....
$dbHost = 'localhost:3307 ';
$dbName = 'locator';
$dbUsername = 'root';
$dbPassword ='';

// create database connectio......
$dbc = mysqli_connect($dbHost,$dbUsername,$dbPassword,$dbName);
?>