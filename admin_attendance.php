<?php
session_start();
include "config.php";

// Only admin access
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

$admin_name = $_SESSION['name'] ?? "Admin";

// Fetch all students and calculate attendance summary
$students = [];
$res = $conn->query("SELECT id, fullname FROM students");
$students_list = $res->fetch_all(MYSQLI_ASSOC);

foreach($students_list as $stu){
    $student_id = $stu['id'];
    $stmt = $conn->prepare("SELECT SUM(present) as presences, SUM(participated) as participated FROM attendance_records WHERE student_id=?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    $presences = $result['presences'] ?? 0;
    $participated = $result['participated'] ?? 0;

    // Determine message and color
    $message = $presences >= 5 ? "Good Attendance" : ($presences >= 3 ? "Warning" : "Attendance Low");
    $color = $presences >= 5 ? "green" : ($presences >= 3 ? "yellow" : "red");

    $students[] = [
        "id"=>$student_id,
        "fullname"=>$stu['fullname'],
        "presences"=>$presences,
        "participated"=>$participated,
        "message"=>$message,
        "color"=>$color
    ];
}

// Sorting
if(isset($_GET['sort'])){
    if($_GET['sort'] == 'absence'){
        usort($students, fn($a,$b) => $b['presences'] <=> $a['presences']);
    }
    if($_GET['sort'] == 'participated'){
        usort($students, fn($a,$b) => $b['participated'] <=> $a['participated']);
    }
}

// Search
$search = $_GET['search'] ?? "";
if($search != ""){
    $students = array_filter($students, fn($stu) => stripos($stu['fullname'], $search) !== false);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Attendance Summary</title>
<link rel="stylesheet" href="style.css">
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
.navbar a:hover { background: #1f4d3a; }
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

.cart {
    background: #f5f5f5;
    padding: 20px;
    margin: 20px auto;
    border-radius: 12px;
    max-width: 95%;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

table { border-collapse: collapse; width: 100%; margin-top: 20px; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
th { background:#2b6a4a; color: #fff; }
.green { background: #b6fcb6; }
.yellow { background: #fcfcb6; }
.red { background: #fcb6b6; }
.highlight { background: #32CD32 !important; }

button { padding: 8px 16px; margin:5px; cursor:pointer; border:none; border-radius:5px; background:#2b6a4a; color:white; }
input[type=text] { padding:5px; width:200px; border-radius:5px; border:1px solid #ccc;}
</style>
</head>
<body>

<div class="navbar">
    <a href="admin_home.php">Home</a>
    <a href="admin_students.php">Students</a>
    <a href="admin_professors.php">Professors</a>
    <a href="admin_attendance.php">Attendance</a>
    <a href="admin_statistics.php">Statistics</a>
    <a href="logout.php">Logout</a>
    <div class="profile-circle" title="<?= $admin_name ?>"><?= strtoupper($admin_name[0] ?? 'A') ?></div>
</div>

<div class="cart">
<h2>📋 Attendance Summary</h2>

<form method="GET">
<input type="text" name="search" placeholder="Search student" value="<?= htmlspecialchars($search) ?>">
<button type="submit">Search</button>
<a href="admin_attendance.php"><button type="button">Reset</button></a>
</form>

<div>
<button onclick="highlightExcellent()">Highlight Excellent</button>
<button onclick="resetHighlight()">Reset Highlight</button>
<a href="?sort=absence"><button>Sort by Absence</button></a>
<a href="?sort=participated"><button>Sort by Participated</button></a>
</div>

<table>
<thead>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Presences</th>
<th>Participated</th>
<th>Message</th>
</tr>
</thead>
<tbody>
<?php foreach($students as $stu): ?>
<tr class="<?= $stu['color'] ?>">
<td><?= $stu['id'] ?></td>
<td><?= $stu['fullname'] ?></td>
<td><?= $stu['presences'] ?></td>
<td><?= $stu['participated'] ?></td>
<td><?= $stu['message'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<script>
function highlightExcellent(){
    document.querySelectorAll('tr.green').forEach(row=>{
        row.classList.add('highlight');
    });
}
function resetHighlight(){
    document.querySelectorAll('tr').forEach(row=>{
        row.classList.remove('highlight');
    });
}
</script>

</body>
</html>
