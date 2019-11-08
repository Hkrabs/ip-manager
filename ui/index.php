<?php

    require_once __DIR__ . '/sidebar-color.php';
    require_once __DIR__ . '/layout/header.php';
    require_once __DIR__ . '/layout/sidebar.php';

    if (isset($_GET['page'])) {
        if ($_GET['page'] == 'main') {
            require_once __DIR__ . '/main.php';
        }
        else if ($_GET['page'] == 'add-to-blacklist') {
            require_once __DIR__ . '/add-to-blacklist.php';
        }
        else if ($_GET['page'] == 'add-to-whitelist') {
            require_once __DIR__ . '/add-to-whitelist.php';
        }
        else {
            require_once __DIR__ . '/404.php';
        }
    }
    else {
        require_once __DIR__ . '/main.php';
    }

    require_once __DIR__ . '/layout/footer.php';