<?php

    // Set main config by its file
    $config = require('./config.php');

    // If storage selected as MySQL
    if ($config['storage'] == 'mysql') {

        // Set database config by its file
        $dbConfig = require('./config/db.config.php');

        if ($dbConfig['db_type'] == 'mysql') {
            // Include MySQL driver
            require_once './drivers/mysql.driver.php';
        }
    }

    // If logging is active on default config file
    if ($config['logging'] == true) {
        ini_set('log_errors', 1);
        ini_set('error_log', './error_log.txt');
    }