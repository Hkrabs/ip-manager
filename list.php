<?php

    // Include bootstrap file to initialization
    require_once 'bootstrap.php';

    $blacklist = getBlackList();

    for ($i = 0; $i < count($blacklist); $i++) {
        echo sprintf("%s<br />\n", $blacklist[$i]);
    }