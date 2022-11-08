<?php

$username = 'admin';
$password = 'admin';
$hostname = 'localhost';
$database = 'redgreen_database';

$cnxn = @mysqli_connect($hostname, $username, $password, $database) or die("Error Connecting to DB: " . mysqli_connect_error());

echo 'connected to Database!';

?>