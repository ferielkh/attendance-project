<?php
// session_start(); <-- removed
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}
$admin_name = $_SESSION['name'] ?? "Admin";
?>
<style>
.navbar {
    display: flex;
    justify-content: center;
    background: #2b6a4a;
    padding: 10px;
    gap: 20px;
}
.navbar a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 8px 12px;
    border-radius: 5px;
}
.navbar a:hover {
    background: #1f4d3a;
}
.navbar .profile-circle {
    width: 35px;
    height: 35px;
    background: #fff;
    color: #2b6a4a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    cursor: pointer;
}
</style>

<div class="navbar">
    <a href="admin_home.php">Home</a>
    <a href="admin_students.php">Students</a>
    <a href="admin_professors.php">Professors</a>
    <a href="admin_attendance.php">Attendance</a>
    <a href="admin_statistics.php">Statistics</a>
    <a href="logout.php">Logout</a>
    <div class="profile-circle" title="<?= $admin_name ?>"><?= strtoupper($admin_name[0] ?? 'A') ?></div>
</div>
