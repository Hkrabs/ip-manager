<?php

    function addToBlacklist($ipAddress, $ttl = -1, $reason = '') {
        global $connection;

        $created = date('Y-m-d H:i:s');

        $ipAddress = mysql_real_escape_string($ipAddress);
        $ttl = mysql_real_escape_string($ttl);
        $reason = mysql_real_escape_string($reason);

        $insert = mysql_query("INSERT INTO blacklist (ip_address, created, ttl, reason) VALUES ('{$ipAddress}', '{$created}', '{$ttl}', '{$reason}')");

        if ($insert) {
            echo sprintf("%s başarıyla kaydedildi.", $ipAddress);
        }

        return $insert;
    }

    function addToWhitelist($ipAddress) {
        global $connection;

        $ipAddress = mysql_real_escape_string($ipAddress);

        $insert = mysql_query("INSERT INTO whitelist (ip_address) VALUES ('{$ipAddress}')");

        if ($insert) {
            echo sprintf("%s başarıyla kaydedildi.", $ipAddress);
        }

        return $insert;
    }

    function getBlackList() {
        global $connection;

        $blacklist = array();

        $blacklistQuery = mysql_query("SELECT * FROM blacklist WHERE CURTIME() <= (blacklist.created + INTERVAL blacklist.ttl MINUTE) or blacklist.ttl = -1");

        if (!mysql_num_rows($blacklistQuery)) {
            return;
        }

        while ($row = mysql_fetch_assoc($blacklistQuery)) {
            if (checkWhiteList($row['ip_address'])) {
                continue;
            }
            $blacklist[] = $row['ip_address'];
        }

        return $blacklist;
    }

    function getWhiteList() {
        global $connection;

        $whitelist = array();

        $whitelistQuery = mysql_query("SELECT * FROM whitelist");

        if (!mysql_num_rows($whitelistQuery)) {
            return;
        }

        while ($row = mysql_fetch_assoc($whitelistQuery)) {
            $whitelist[] = $row['ip_address'];
        }

        return $whitelist;
    }

    function checkWhiteList($ipAddress) {
        global $connection;

        $whitelistQuery = mysql_query("SELECT * FROM whitelist WHERE ip_address = '$ipAddress'");

        if (mysql_num_rows($whitelistQuery)) {
            return true;
        }
        return false;
    }

    function thenRedirect($path) {
        if (isset($_GET['redirect'])) {
            if (!in_array(substr($_GET['redirect'], 0, 7), array('http://', 'https://'))) {
                header(sprintf('location: %s', $_GET['redirect']));
                die();
            }
        }
    }
