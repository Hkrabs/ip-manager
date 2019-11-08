<?php

    // Include bootstrap file to initialization
    require_once './src/bootstrap.php';

    // Set default values
    $ipAddress = '';

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
        if (!empty($data['ip_address'])) {
            $ipAddress =  $data['ip_address'];
        }
        else {
            die('IP adresi gerekli.');
        }

        $readyToCreate = true;
    }
    else if ($_POST) {
        if (!empty($_POST['ip_address'])) {
            $ipAddress =  $_POST['ip_address'];
        }
        else {
            die('IP adresi gerekli.');
        }

        $readyToCreate = true;
    }

    if ($readyToCreate) {
        // Add IP address to storage
        addToWhitelist($ipAddress);
    }

    // If there is a query for that then redirect
    thenRedirect();