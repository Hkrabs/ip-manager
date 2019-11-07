<?php

    // function replacements for both of MySQL and MySQLi

    /**
     * mysql_query()
     * mysqli_query()
     */
    function query($connection, $sql) {
        if (function_exists('mysql_query')) {
            return mysql_query($sql);
        }

        return mysqli_query($connection, $sql);
    }

    /**
     * mysql_connect() and mysql_select_db()
     * mysqli_connect()
     */
    function connect($dbHost, $dbUser, $dbPassword, $dbName) {
        if (function_exists('mysql_connect')) {
            $connection = mysql_connect($dbHost, $dbUser, $dbPassword);

            @mysql_select_db($dbName);

            return $connection;
        }
        else {
            return mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
        }
    }

    /**
     * mysql_real_escape_string()
     * mysqli_real_escape_string()
     */
    function real_escape_string($connection, $string) {
        if (function_exists('mysql_real_escape_string')) {
            return mysql_real_escape_string($string);
        }
        return mysqli_real_escape_string($connection, $string);
    }

    /**
     * mysql_num_rows()
     * mysqli_num_rows()
     */
    function num_rows($resource) {
        if (function_exists('mysql_num_rows')) {
            return mysql_num_rows($resource);
        }
        return mysqli_num_rows($resource);
    }

    /**
     * mysql_fetch_assoc()
     * mysqli_fetch_assoc()
     */
    function fetch_assoc($resource) {
        if (function_exists('mysql_fetch_assoc')) {
            return mysql_fetch_assoc($resource);
        }
        return mysqli_fetch_assoc($resource);
    }

    // Create database connection from database config
    $connection = connect($dbConfig['db_host'], $dbConfig['db_user'], $dbConfig['db_password'], $dbConfig['db_name'])
    or die('Veritabanı hatası');

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

        // Filter inputs before add to database
        $ipAddress = real_escape_string($connection, $ipAddress);
        $ttl = real_escape_string($connection, $ttl);
        $reason = real_escape_string($connection, $reason);

        $sql = "INSERT INTO blacklist (ip_address, created, ttl, reason) VALUES ('{$ipAddress}', '{$created}', '{$ttl}', '{$reason}')";

        $insert = query($connection, $sql);

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

        $blacklistQuery = query($connection, $sql);

        $result = num_rows($blacklistQuery);

        if (!$result) {
            return;
        }

        while ($row = fetch_assoc($blacklistQuery)) {
            if (checkWhiteList($row['ip_address'])) {
                continue;
            }
            $blacklist[] = $row['ip_address'];
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

        $whitelistQuery = query($connection, $sql);

        $result = num_rows($whitelistQuery);

        if (!$result) {
            return;
        }

        while ($row = fetch_assoc($whitelistQuery)) {
            $whitelist[] = $row['ip_address'];
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

        $ipAddress = real_escape_string($connection, $ipAddress);

        $sql = "INSERT INTO whitelist (ip_address) VALUES ('{$ipAddress}')";

        $insert = query($connection, $sql);

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

        $whitelistQuery = query($connection, $sql);

        $result = num_rows($whitelistQuery);

        if ($result) {
            return true;
        }
        return false;
    }