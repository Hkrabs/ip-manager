<?php

    if (isset($_GET['sidebar-color'])) {
        setcookie('sidebar-color', $_GET['sidebar-color'], time() + 60*60*24*15);
        header('location: index.php');
    }
