<?php
    $configs = include('dbconfig.php');
    $dbconn = mysqli_connect($configs['host'], $configs['username'], $configs['password'], $configs['dbname']);

    if (mysqli_connect_errno()) {
        echo "Failed Connection to Database: " . mysqli_connect_error();
        returnWithError($conn->connect_error);
    }
?>