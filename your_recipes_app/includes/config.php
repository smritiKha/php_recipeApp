<?php

    //database configuration
    $host       = 'localhost';
    $user       = 'root';
    $pass       = '';
    $database   = 'your_recipes_app_db';

    $connect = new mysqli($host, $user, $pass, $database);

    if (mysqli_connect_errno()) {
        die ('Whoops! failed to connect to database : ' . mysqli_connect_error());
    } else {
        $connect->set_charset('utf8mb4');
    }

    $GLOBALS['config'] = $connect;

    $ENABLE_RTL_MODE = 'false';

?>