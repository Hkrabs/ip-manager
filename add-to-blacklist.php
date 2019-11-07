<?php

    // Include bootstrap file to initialization
    require_once 'bootstrap.php';

    // Set default values
    $ipAddress = '';
    $ttl = -1;
    $reason = '';

    $readyToCreate = false;

    $input = file_get_contents('php://input');

    // Check if post data is JSON
    if ($data = json_decode($input)) {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Max-Age: 3600');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Request-With');

        $data = (array) $data;

        // Check post variables in JSON
        if (isset($data['ip_address'])) {
            $ipAddress =  $data['ip_address'];
        }
        else {
            die('IP adresi gerekli.');
        }

        if (isset($data['ttl'])) {
            $ttl = $data['ttl'];
        }

        if (isset($data['reason'])) {
            $reason = $data['reason'];
        }

        $readyToCreate = true;
    }
    else if ($_POST) {
        // Check post variables in form data
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

        $readyToCreate = true;
    }
    if ($readyToCreate) {
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
    else {
        die('Geçersiz metot');
    }

    // If there is a query for that then redirect
    thenRedirect();