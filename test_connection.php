<?php
$conn = require "db_connect.php"; // Load the connection

if ($conn) {
    echo "Connection successful";
} else {
    echo "Connection failed";
}
?>