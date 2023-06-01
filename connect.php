<?php
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'used_cars_data';

    $connect = mysqli_connect($hostname, $username, $password, $database);

    if (!$connect) {
        die($connect);
    }
?>