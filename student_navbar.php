<?php
if(!isset($_SESSION)) session_start();

// Only students can access student pages
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'student'){
    header("Location: login.php");
    exit;
}
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

body {
    margin:0;
    font-family: 'Poppins', sans-serif;
}

.navbar {
    background:#2b6a4a;
    padding:15px 25px;
    display:flex;
    align-items:center;
    justify-content:center; /* CENTER NAVBAR LIKE PROFESSOR */
    color:white;
    position:relative;
}

.navbar-inner {
    display:flex;
    align-items:center;
    gap:25px;
}

.navbar a {
    color:white;
    text-decoration:none;
    font-weight:500;
    font-size:16px;
}

.navbar a:hover {
    text-decoration:underline;
}

.profile-section {
    position:absolute;
    right:25px;  /* Circle aligned right just like professor */
    display:flex;
    align-items:center;
    gap:10px;
}

.circle {
    width:40px;
    height:40px;
    background:#fff;
    color:#2b6a4a;
    border-radius:50%;
    text-align:center;
    line-height:40px;
    font-weight:bold;
    font-size:18px;
    cursor:pointer;
}

.profile-name {
    color:white;
    font-size:15px;
}
</style>

<div class="navbar">
    <div class="navbar-inner">
        <a href="student_home.php">Home</a>
        <a href="student_info.php">Personal Info</a>
        <a href="student_timetable.php">Timetable</a>
        <a href="student_attendance.php">My Attendance</a>
        <a href="student_grades.php">Grades</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="profile-section">
        <div class="profile-name">Feriel</div>
        <div class="circle">F</div>
    </div>
</div>
