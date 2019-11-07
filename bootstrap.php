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

    /**
     * Redirect to page if there is redirect query
     *
     * @param [string] $path
     * @return void
     */
    function thenRedirect() {
        if (isset($_GET['redirect'])) {
            if (!in_array(substr($_GET['redirect'], 0, 7), array('http://', 'https://'))) {
                header(sprintf('location: %s', $_GET['redirect']));
                die();
            }
        }
    }