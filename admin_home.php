<?php
session_start();
include "admin_navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Home</title>
<link rel="stylesheet" href="style.css">
<style>
.cart {
    background: #f7f7f7;
    padding: 20px;
    border-radius: 10px;
    margin: 20px auto;
    width: 80%;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
h2 { color: #2b6a4a; }
</style>
</head>
<body>
<div class="cart">
    <h2>Welcome, <?= $_SESSION['name'] ?? "Admin" ?>!</h2>
    <p>This is your admin dashboard. You can manage students, professors, attendance, and view statistics from here.</p>
</div>

<div class="cart">
    <h3>Quick Info</h3>
    <p>Name: <?= $_SESSION['name'] ?? "Admin" ?></p>
    <p>Email: admin@example.com</p>
    <p>Role: Administrator</p>
    <p>Year: 2025/2026</p>
</div>
</body>
</html>
