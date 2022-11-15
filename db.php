<?php
    /*
     * Master  File used to access database
     * Stored in the root directory of our greenriverdev.com account
     * Not accessible via the web by itself !!!
    */
    // PRODUCTION
    /*
    $username = 'redgreen_php';
    $password = 'redtomatoes';
    $hostname = 'localhost';
    $database = 'redgreen_wedding';
    */

    // DEVELOPMENT
    $username = 'root';
    $password = 'pw';
    $hostname = 'localhost:3306';
    $database = 'rentals';

    $cnxn = @mysqli_connect($hostname, $username, $password, $database) or 
    die("Error Connecting to DB: " . mysqli_connect_error());
    
    //echo 'connected to Database!';
?>