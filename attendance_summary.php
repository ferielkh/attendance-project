<?php
session_start();
include "config.php";

// Only professor access
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'professor'){
    header("Location: login.php");
    exit;
}

// Fetch all students
$students = $conn->query("SELECT id, fullname FROM students")->fetch_all(MYSQLI_ASSOC);

// Prepare attendance summary
$summary = [];
foreach($students as $stu){
    $student_id = $stu['id'];
    $res = $conn->query("SELECT SUM(present) AS total_present, SUM(participated) AS total_participation FROM attendance_records WHERE student_id = $student_id");
    $row = $res->fetch_assoc();
    $total_present = $row['total_present'] ?? 0;
    $total_participation = $row['total_participation'] ?? 0;
    $total_absence = 6 - $total_present; // 6 sessions

    // Determine row color and message
    $color = '';
    $message = '';
    if($total_absence >= 5){
        $color = 'red';
        $message = 'Too many absences';
    } elseif($total_absence >= 3){
        $color = 'yellow';
        $message = 'Attendance low';
    } else {
        $color = 'green';
        $message = 'Good attendance';
    }

    $summary[] = [
        'id' => $stu['id'],
        'fullname' => $stu['fullname'],
        'total_present' => $total_present,
        'total_participation' => $total_participation,
        'total_absence' => $total_absence,
        'color' => $color,
        'message' => $message
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Attendance Summary</title>
<link rel="stylesheet" href="style.css">
<style>
.cart { background: #fff; padding: 20px; margin: 20px auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 900px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
th { background:#2b6a4a; color: #fff; }
tr.green { background:#c8e6c9; }
tr.yellow { background:#fff9c4; }
tr.red { background:#ffcdd2; }
tr.highlight { background:#4caf50 !important; color:white; font-weight:bold; }
button { padding: 8px 16px; margin:5px; cursor:pointer; border:none; border-radius:5px; background:#2b6a4a; color:white; }
input[type="text"] { padding: 5px 10px; margin:5px 0; width: 200px; }
</style>
<script>
// Highlight Excellent Students
function highlightExcellent(){
    document.querySelectorAll('tr.green').forEach(row=>{
        row.classList.add('highlight');
    });
}

// Reset Highlight
function resetHighlight(){
    document.querySelectorAll('tr.highlight').forEach(row=>{
        row.classList.remove('highlight');
    });
}

// Search by name
function searchName(){
    let input = document.getElementById("searchInput").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");
    rows.forEach(row=>{
        let name = row.cells[1].innerText.toLowerCase();
        row.style.display = name.includes(input) ? "" : "none";
    });
}

// Sort table by a column
function sortTable(colIndex, desc=false){
    let table = document.querySelector("tbody");
    let rows = Array.from(table.querySelectorAll("tr"));
    rows.sort((a,b)=>{
        let aVal = parseInt(a.cells[colIndex].innerText);
        let bVal = parseInt(b.cells[colIndex].innerText);
        return desc ? bVal - aVal : aVal - bVal;
    });
    rows.forEach(r=>table.appendChild(r));
}
</script>
</head>
<body>

<?php include "professor_navbar.php"; ?>

<div class="cart">
<h2>📊 Attendance Summary</h2>

<div style="margin-bottom:10px;">
    <input type="text" id="searchInput" placeholder="Search by name" onkeyup="searchName()">
    <button onclick="highlightExcellent()">Highlight Excellent Students</button>
    <button onclick="resetHighlight()">Reset Highlight</button>
    <button onclick="sortTable(4, false)">Sort by Absences (low → high)</button>
    <button onclick="sortTable(3, true)">Sort by Participation (high → low)</button>
</div>

<table>
<thead>
<tr>
<th>ID</th>
<th>Name</th>
<th>Presence</th>
<th>Participation</th>
<th>Absences</th>
<th>Message</th>
</tr>
</thead>
<tbody>
<?php foreach($summary as $stu): ?>
<tr class="<?= $stu['color'] ?>">
<td><?= $stu['id'] ?></td>
<td><?= $stu['fullname'] ?></td>
<td><?= $stu['total_present'] ?></td>
<td><?= $stu['total_participation'] ?></td>
<td><?= $stu['total_absence'] ?></td>
<td><?= $stu['message'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

</body>
</html>
