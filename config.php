<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "attendance_db";

// optionally create $conn here:
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("DB Conn Error: " . $conn->connect_error);
}
