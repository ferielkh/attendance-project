<?php
session_start();
include "student_navbar.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Timetable</title>
<style>
.card {
    background:white;
    padding:25px;
    max-width:900px;
    margin:40px auto;
    border-radius:15px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}
table {
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th, td {
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}
th { background:#2b6a4a; color:white; }
h2 { color:#2b6a4a; }
</style>
</head>
<body>

<div class="card">
<h2>🗓 Timetable</h2>

<table>
<tr>
<th>Day</th>
<th>08:00 - 10:00</th>
<th>10:00 - 12:00</th>
<th>13:00 - 15:00</th>
<th>15:00 - 17:00</th>
</tr>

<tr>
<td>Sunday</td>
<td>GL</td><td>SID</td><td>PAW</td><td>IHM</td>
</tr>

<tr>
<td>Monday</td>
<td>SAD</td><td>ASI</td><td>GL</td><td>Free</td>
</tr>

<tr>
<td>Wednesday</td>
<td>PAW</td><td>SID</td><td>IHM</td><td>ASI</td>
</tr>

<tr>
<td>Saturday</td>
<td>GL</td><td>SAD</td><td>SID</td><td>Free</td>
</tr>

</table>
</div>

</body>
</html>
