<?php

    // Include bootstrap file to initialization
    require_once './src/bootstrap.php';

    if (isset($_GET['id'])) {
        deleteFromBlacklist($_GET['id']);
    }

    thenRedirect();