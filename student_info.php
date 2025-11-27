<?php
session_start();
include "student_navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Personal Info</title>
<style>
.card {
    background:white;
    padding:25px;
    max-width:700px;
    margin:40px auto;
    border-radius:15px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}
h2 { color:#2b6a4a; }
.info-row { margin:10px 0; font-size:18px; }
.label { font-weight:bold; color:#2b6a4a; }
</style>
</head>
<body>

<div class="card">
    <h2>👤 Personal Information</h2>

    <div class="info-row"><span class="label">Full Name:</span> Feriel Khoukhi</div>
    <div class="info-row"><span class="label">Email:</span> khoukhiferiel@gmail.com</div>
    <div class="info-row"><span class="label">Level:</span> Licence 3</div>
    <div class="info-row"><span class="label">Speciality:</span> ISIL</div>
    <div class="info-row"><span class="label">Academic Year:</span> 2025 / 2026</div>
</div>

</body>
</html>
