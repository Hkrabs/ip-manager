<?php

    // Include bootstrap file to initialization
    require_once 'bootstrap.php';
    header('Content-Type: text/plain');

    // Get blacklisted IPs as array
    $blacklist = getBlackList();

    // Print blacklisted IPs to screen
    for ($i = 0; $i < count($blacklist); $i++) {
        echo sprintf("%s\r\n", $blacklist[$i]);
    }