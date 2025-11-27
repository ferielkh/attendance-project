<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Professor Home</title>
<style>
body {
    font-family: Arial, sans-serif;
    background:#f0f4f7;
    margin:0;
    padding:0;
}

/* Navbar */
nav {
    background:#2b6a4a;
    padding:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    position:relative;
}

nav ul {
    list-style:none;
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
    align-items:center;
}

nav ul li {
    margin:0 20px;
}

nav ul li a {
    color:white;
    text-decoration:none;
    font-weight:bold;
    padding:5px 10px;
    border-radius:5px;
    transition: background 0.3s;
}

nav ul li a:hover {
    background:#24563c;
}

/* Profile icon */
.profile {
    position:absolute;
    right:20px;
    top:15px;
    width:40px;
    height:40px;
    background:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    font-weight:bold;
    color:#2b6a4a;
    border:2px solid #2b6a4a;
}

.profile:hover .dropdown {
    display:block;
}

.dropdown {
    display:none;
    position:absolute;
    right:0;
    top:50px;
    background:white;
    border:1px solid #ccc;
    border-radius:8px;
    padding:10px;
    width:200px;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
}

.dropdown p {
    margin:5px 0;
}

.dropdown a {
    display:block;
    margin-top:10px;
    color:#2b6a4a;
    text-decoration:none;
    font-weight:bold;
    padding:5px;
    border-radius:5px;
    border:1px solid #2b6a4a;
    text-align:center;
}

.dropdown a:hover {
    background:#2b6a4a;
    color:white;
}

/* Welcome card */
.welcome-card {
    width:400px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}

.welcome-card h2 {
    color:#2b6a4a;
    margin-bottom:15px;
}

.welcome-card p {
    font-size:16px;
    color:#333;
}
</style>
</head>
<body>

<!-- Navbar -->
<nav>
    <ul>
        <li><a href="professor_home.php">Home</a></li>
        <li><a href="take_attendance.php">Attendance</a></li>
        <li><a href="attendance_summary.php">Attendance Summary</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

    <div class="profile">
        H
        <div class="dropdown">
            <p><strong>Professor Hemili</strong></p>
            <p>Email: hemili@example.com</p>
            <p>ID: 123456</p>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<!-- Welcome card -->
<div class="welcome-card">
    <h2>Welcome, Professor <?= htmlspecialchars($_SESSION['username']) ?> 🌿</h2>
    <p>This is your homepage. Use the navbar above to navigate to attendance or summary pages.</p>
</div>

</body>
</html>
