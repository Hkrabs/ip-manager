<?php

    // Include bootstrap file to initialization
    require_once './src/bootstrap.php';

    // Set header as plain text
    header('Content-Type: text/plain');

    // Get blacklisted IPs as array
    $whitelist = getWhitelist();

    // Print blacklisted IPs to screen
    for ($i = 0; $i < count($whitelist); $i++) {
        printf("%s\r\n", $whitelist[$i]);
    }