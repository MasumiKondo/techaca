<?php
function getDb() {
    $dsn = 'mysql:dbname=selfphp; host=localhost';
    $usr = 'selfusr';
    $passwd = 'selfpass';

    try {
        $db = new PDO($dsn, $usr, $passwd);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES utf8');
    } catch (PDOException $e) {
        die("接続エラー：{$e->getMessage()}");
    }
    return $db;
}
