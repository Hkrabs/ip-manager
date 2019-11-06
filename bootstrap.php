<?php

    // Include root config file
    $config = require('./config.php');

    // Include sub config files
    require_once './config/db.config.php';

    // If storage selected as MySQL
    if ($config['storage'] == 'mysql') {
        // Create database connection from database config
        $connection = mysql_connect($db_host, $db_user, $db_password)
        or die('Bağlantı başarısız.');

        // Connect to database
        $connection = mysql_select_db($db_name, $connection)
        or die('Veritabanı hatası.');

        // Include MySQL driver
        require_once './drivers/mysql.driver.php';
    }

    if ($config['logging'] == true) {
        ini_set('log_errors', 1);
        ini_set('error_log', './error_log.txt');
    }