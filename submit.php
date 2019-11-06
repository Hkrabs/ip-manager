<?php

    // Include bootstrap file to initialization
    require_once 'bootstrap.php';

    // Set default values
    $ipAddress = '';
    $ttl = -1;
    $reason = '';

    // If data post
    if ($_POST) {
        // Check post variables
        if (isset($_POST['ip_address'])) {
            $ipAddress =  $_POST['ip_address'];
        }
        else {
            die('IP adresi gerekli.');
        }

        if (isset($_POST['ttl'])) {
            $ttl =  $_POST['ttl'];
        }

        if (isset($_POST['reason'])) {
            $reason =  $_POST['reason'];
        }

        // Add IP address, time to live value and reason to storage
        addToBlacklist($ipAddress, $ttl, $reason);

        // Check if logging is active on config
        if ($config['logging'] == true) {
            // Prepare log string
            $log = sprintf("Banned: %s for %s minutes. Sebep: %s", $ipAddress, $ttl, $reason);

            // Log that
            error_log($log, 0);
        }
    }