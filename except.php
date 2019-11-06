<?php

// Include bootstrap file to initialization
require_once 'bootstrap.php';

// Set default values
$ipAddress = '';

// If data post
if ($_POST) {
    if (isset($_POST['ip_address'])) {
        $ipAddress =  $_POST['ip_address'];
    }
    else {
        die('IP adresi gerekli.');
    }

    addToWhitelist($ipAddress);
}