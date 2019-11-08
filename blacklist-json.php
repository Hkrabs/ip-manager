<?php

    // Include bootstrap file to initialization
    require_once './src/bootstrap.php';

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Request-With');

    $config = array(
        'show_by_ttl' => false,
        'id' => true,
        'reason' => true,
        'created_date' => true,
        'ttl' => true,
        'as_json' => true,
        'except_whitelist' => false
    );

    if (isset($_GET['by_ttl'])) {
        $config['show_by_ttl'] = true;
    }

    if (isset($_GET['except_whitelist'])) {
        $config['except_whitelist'] = true;
    }

    // Get blacklisted IPs as array
    $blacklist = getBlacklist($config);

    // Print blacklisted IPs to screen
    echo $blacklist;