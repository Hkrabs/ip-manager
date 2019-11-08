<?php

    // Include bootstrap file to initialization
    require_once './src/bootstrap.php';

    if (isset($_GET['ip_address'])) {
        deleteFromWhitelist($_GET['ip_address']);
    }

    thenRedirect();