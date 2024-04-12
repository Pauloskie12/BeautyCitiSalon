<?php
$host = "localhost";
$username = "u679186036_beautyciti_db";
$password = "BeautyCiti@123";
$database = "u679186036_beautyciti_db";
$connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>