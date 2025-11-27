<?php

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'professor'){
    header("Location: login.php"); exit;
}
?>

<style>
.navbar {
    display: flex;
    justify-content: center;
    background: #2b6a4a;
    padding: 10px;
    gap: 30px;
    align-items: center;
}
.navbar a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 5px 15px;
    border-radius: 5px;
}
.navbar a:hover {
    background: #24563c;
}
.profile-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #fff;
    color: #2b6a4a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    cursor: pointer;
    position: relative;
}
.profile-dropdown {
    display: none;
    position: absolute;
    top: 45px;
    right: 0;
    background: white;
    color: #2b6a4a;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 5px #aaa;
}
.profile-circle:hover .profile-dropdown {
    display: block;
}
</style>

<div class="navbar">
    <a href="professor_home.php">Home</a>
    <a href="take_attendance.php">Take Attendance</a>
    <a href="attendance_summary.php">Attendance Summary</a>
    <a href="logout.php">Logout</a>

    <div class="profile-circle">
        <?= strtoupper($_SESSION['username'][0]) ?>
        <div class="profile-dropdown">
            <p><?= $_SESSION['username'] ?></p>
            <p>professor@example.com</p>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>
