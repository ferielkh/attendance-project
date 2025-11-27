<?php
require('config.php');

function getConnection() {
    try {
        global $host, $user, $password, $dbname;

        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;

    } catch (PDOException $e) {
        file_put_contents('error_log.txt', $e->getMessage() . "\n", FILE_APPEND);
        return false;
    }
}
?>
