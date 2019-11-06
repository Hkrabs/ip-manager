<?php

    // Include bootstrap file to initialization
    require_once 'bootstrap.php';

    // Set default values
    $ipAddress = '';
    $ttl = -1;
    $reason = '';

    // If data post
    if ($_POST) {
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

        addToBlacklist($ipAddress, $ttl, $reason);

        if ($config['logging'] == true) {
            $log = sprintf("Banned: %s for %s minutes. Sebep: %s", $ipAddress, $ttl, $reason);

            error_log($log, 0);
        }
    }

    thenRedirect();