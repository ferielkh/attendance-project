<?php
session_start();
include "admin_navbar.php";
include "config.php";

// Get statistics
$res = $conn->query("
    SELECT 
        s.fullname,
        SUM(ar.present) AS total_present,
        SUM(ar.participated) AS total_participated
    FROM students s
    LEFT JOIN attendance_records ar ON s.id = ar.student_id
    GROUP BY s.id
");
$stats = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Statistics</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="style.css">
<style>
.cart { background:#f7f7f7; padding:20px; border-radius:10px; margin:20px auto; width:80%; box-shadow:0 2px 6px rgba(0,0,0,0.1);}
</style>
</head>
<body>
<div class="cart">
<h2>Attendance Statistics</h2>
<canvas id="attendanceChart" width="800" height="400"></canvas>
</div>

<script>
const ctx = document.getElementById('attendanceChart').getContext('2d');
const labels = <?= json_encode(array_column($stats,'fullname')) ?>;
const presents = <?= json_encode(array_column($stats,'total_present')) ?>;
const participated = <?= json_encode(array_column($stats,'total_participated')) ?>;

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            { label: 'Present', data: presents, backgroundColor: '#2b6a4a' },
            { label: 'Participated', data: participated, backgroundColor: '#4ade80' }
        ]
    },
    options: {
        responsive:true,
        scales: { y: { beginAtZero:true } }
    }
});
</script>
</body>
</html>
