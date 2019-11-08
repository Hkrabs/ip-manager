<?php

    // Function replacements for both of MySQL and MySQLi

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
        if (!$resource) {
            return false;
        }
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
    function getBlacklist($config = array()) {
        global $connection;

        $_config = [
            'show_by_ttl' => true,
            'ttl' => false,
            'created_date' => false,
            'id' => false,
            'reason' => false,
            'as_json' => false
        ];

        $config = array_merge($_config, $config);

        $blacklist = array();

        if ($config['show_by_ttl']) {
            $sql = "SELECT * FROM blacklist WHERE CURTIME() <= (blacklist.created + INTERVAL blacklist.ttl MINUTE) or blacklist.ttl = -1";
        }
        else {
            $sql = "SELECT * FROM blacklist";
        }

        if (!isset($_GET['reverse'])) {
            $sql .= " ORDER BY blacklist_id DESC";
        }
        else {
            $sql .= " ORDER BY blacklist_id ASC";
        }

        if (isset($_GET['limit'])) {
            if (preg_match("/^[0-9]+\,?\s?[0-9]*$/", $_GET['limit'])) {
                $limit = real_escape_string($connection, $_GET['limit']);
                $sql .= " LIMIT " . $limit;
            }
        }

        $blacklistQuery = query($connection, $sql);

        $result = num_rows($blacklistQuery);

        if (!$result) {
            return;
        }

        while ($row = fetch_assoc($blacklistQuery)) {
            if (checkWhitelist($row['ip_address'])) {
                continue;
            }

            $item = array();
            $item['ip_address'] = $row['ip_address'];
            
            if ($config['created_date']) {
                $item['created_date'] = $row['created'];
            }
            
            if ($config['ttl']) {
                $item['ttl'] = $row['ttl'];
            }
            
            if ($config['reason']) {
                $item['reason'] = $row['reason'];
            }

            if ($config['id']) {
                $item['id'] = $row['blacklist_id'];
                $blacklist[$row['blacklist_id']] = $item;
            }
            else {
                $blacklist[] = $item;
            }
        }

        if ($config['as_json']) {
            return json_encode($blacklist, JSON_PRETTY_PRINT);
        }

        return $blacklist;
    }

    function getBlacklistAsPlain() {
        $blacklist = getBlacklist();

        $plain = '';

        for ($i = 0; $i < count($blacklist); $i++) {
            $plain .= sprintf("%s\r\n", $blacklist[$i]['ip_address']);
        }

        return $plain;
    }

    /**
     * List whitelisted IPs
     *
     * @return void
     */
    function getWhitelist() {
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
    function checkWhitelist($ipAddress) {
        global $connection;

        $sql = "SELECT * FROM whitelist WHERE ip_address = '$ipAddress'";

        $whitelistQuery = query($connection, $sql);

        $result = num_rows($whitelistQuery);

        if ($result) {
            return true;
        }
        return false;
    }