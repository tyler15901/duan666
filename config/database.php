<?php
$host = 'localhost';
$db   = 'bai1';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

function get_db_connection() {
    global $host, $db, $user, $pass, $charset, $options;
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
    }
    return $pdo;
}
