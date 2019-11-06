<?php

    if (function_exists('mysql_connect')) {
        // Create database connection from database config
        $connection = mysql_connect($dbConfig['db_host'], $dbConfig['db_user'], $dbConfig['db_password'])
        or die('Bağlantı başarısız.');

        // Connect to database
        $connection = mysql_select_db($dbConfig['db_name'], $connection)
        or die('Veritabanı hatası.');
    }
    else {
        // Create database connection from database config
        $connection = mysqli_connect($dbConfig['db_host'], $dbConfig['db_user'], $dbConfig['db_password'], $dbConfig['db_name']);

        if (mysqli_connect_errno()) {
            echo 'Veritabanı hatası.';
        }
    }


    /**
     * Add an IP address to blacklist
     *
     * @param [string] $ipAddress
     * @param integer $ttl
     * @param string $reason
     * @return void
     */
    function addToBlacklist($ipAddress, $ttl = -1, $reason = '') {
        global $connection;

        $created = date('Y-m-d H:i:s');

        if (function_exists('mysql_real_escape_string')) {
            $ipAddress = mysql_real_escape_string($ipAddress);
            $ttl = mysql_real_escape_string($ttl);
            $reason = mysql_real_escape_string($reason);
        }
        else {
            $ipAddress = mysqli_real_escape_string($connection, $ipAddress);
            $ttl = mysqli_real_escape_string($connection, $ttl);
            $reason = mysqli_real_escape_string($connection, $reason);
        }

        $sql = "INSERT INTO blacklist (ip_address, created, ttl, reason) VALUES ('{$ipAddress}', '{$created}', '{$ttl}', '{$reason}')";

        if (function_exists('mysql_query')) {
            $insert = mysql_query($sql);
        }
        else {
            $insert = mysqli_query($connection, $sql);
        }

        if ($insert) {
            echo sprintf("%s başarıyla kaydedildi.", $ipAddress);
        }

        return $insert;
    }

    /**
     * List blacklisted IPs
     *
     * @return void
     */
    function getBlackList() {
        global $connection;

        $blacklist = array();

        $sql = "SELECT * FROM blacklist WHERE CURTIME() <= (blacklist.created + INTERVAL blacklist.ttl MINUTE) or blacklist.ttl = -1";

        if (function_exists('mysql_query')) {
            $blacklistQuery = mysql_query($sql);
        }
        else {
            $blacklistQuery = mysqli_query($connection, $sql);
        }

        if (function_exists('mysql_num_rows')) {
            $result = mysql_num_rows($blacklistQuery);
        }
        else {
            $result = mysqli_num_rows($blacklistQuery);
        }

        if (!$result) {
            return;
        }

        if (function_exists('mysql_fetch_assoc')) {
            while ($row = mysql_fetch_assoc($blacklistQuery)) {
                if (checkWhiteList($row['ip_address'])) {
                    continue;
                }
                $blacklist[] = $row['ip_address'];
            }
        }
        else {
            while ($row = mysqli_fetch_assoc($blacklistQuery)) {
                if (checkWhiteList($row['ip_address'])) {
                    continue;
                }
                $blacklist[] = $row['ip_address'];
            }
        }

        return $blacklist;
    }

    /**
     * List whitelisted IPs
     *
     * @return void
     */
    function getWhiteList() {
        global $connection;

        $whitelist = array();

        $sql = "SELECT * FROM whitelist";

        if (function_exists('mysql_query')) {
            $whitelistQuery = mysql_query($connection, $sql);
        }
        else {
            $whitelistQuery = mysqli_query($connection, $sql);
        }

        if (function_exists('mysql_num_rows')) {
            $result = mysql_num_rows($whitelistQuery);
        }
        else {
            $result = mysqli_num_rows($whitelistQuery);
        }

        if (!$result) {
            return;
        }

        if (function_exists('mysql_num_rows')) {
            while ($row = mysql_fetch_assoc($whitelistQuery)) {
                $whitelist[] = $row['ip_address'];
            }
        }
        else {
            while ($row = mysqli_fetch_assoc($whitelistQuery)) {
                $whitelist[] = $row['ip_address'];
            }
        }

        return $whitelist;
    }

    /**
     * Add an IP address to whitelist
     *
     * @param [string] $ipAddress
     * @return void
     */
    function addToWhitelist($ipAddress) {
        global $connection;

        if (function_exists('mysql_real_escape_string')) {
            $ipAddress = mysql_real_escape_string($connection, $ipAddress);
        }
        else {
            $ipAddress = mysqli_real_escape_string($connection, $ipAddress);
        }

        $sql = "INSERT INTO whitelist (ip_address) VALUES ('{$ipAddress}')";

        if (function_exists('mysql_query')) {
            $insert = mysql_query($sql);
        }
        else {
            $insert = mysqli_query($connection, $sql);
        }

        if ($insert) {
            echo sprintf("%s başarıyla kaydedildi.", $ipAddress);
        }

        return $insert;
    }

    /**
     * Check is IP address in whitelist
     *
     * @param [string] $ipAddress
     * @return void
     */
    function checkWhiteList($ipAddress) {
        global $connection;

        $sql = "SELECT * FROM whitelist WHERE ip_address = '$ipAddress'";

        if (function_exists('mysql_query')) {
            $whitelistQuery = mysql_query($sql);
        }
        else {
            $whitelistQuery = mysqli_query($sql);
        }

        if (function_exists('mysql_num_rows')) {
            $result = mysqli_num_rows($whitelistQuery);
        }

        var_dump(mysqli_num_rows($whitelistQuery));

        if ($result) {
            return true;
        }
        return false;
    }

    /**
     * Redirect to page if there is redirect query
     *
     * @param [string] $path
     * @return void
     */
    function thenRedirect($path) {
        if (isset($_GET['redirect'])) {
            if (!in_array(substr($_GET['redirect'], 0, 7), array('http://', 'https://'))) {
                header(sprintf('location: %s', $_GET['redirect']));
                die();
            }
        }
    }