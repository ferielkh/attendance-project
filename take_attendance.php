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

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_attendance'])) {

    foreach ($students as $stu) {
        $student_id = $stu['id'];
        $note = $_POST['message'][$student_id] ?? '';

        for ($s = 1; $s <= 6; $s++) {
            $present = isset($_POST['p'][$student_id][$s]) ? 1 : 0;
            $participated = isset($_POST['pa'][$student_id][$s]) ? 1 : 0;

            // Insert or update
            $stmt = $conn->prepare("
                INSERT INTO attendance_records (student_id, session_number, present, participated, note)
                VALUES (?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE present=?, participated=?, note=?
            ");
            $stmt->bind_param(
                "iiiisiii",
                $student_id, $s, $present, $participated, $note,
                $present, $participated, $note
            );
            $stmt->execute();
        }
    }

    $success = "Attendance updated successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Take Attendance</title>
<link rel="stylesheet" href="style.css">
<style>
.cart { background: #fff; padding: 20px; margin: 20px auto; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 1000px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
th { background:#2b6a4a; color: #fff; }
tr:hover { background:#d0f0d0; }
button { padding: 8px 16px; margin:5px; cursor:pointer; border:none; border-radius:5px; background:#2b6a4a; color:white; }
input[type=text] { width: 90%; padding:5px; }
</style>
</head>
<body>

<?php include "professor_navbar.php"; ?>

<div class="cart">
<h2>📚 Take Attendance</h2>
<?php if(isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST">
<table>
<thead>
<tr>
<th rowspan="2">ID</th>
<th rowspan="2">Name</th>
<?php for($i=1;$i<=6;$i++): ?>
<th colspan="2">Session <?= $i ?></th>
<?php endfor; ?>
<th rowspan="2">Message</th>
</tr>
<tr>
<?php for($i=1;$i<=6;$i++): ?>
<th>P</th><th>Pa</th>
<?php endfor; ?>
</tr>
</thead>

<tbody>
<?php foreach($students as $stu): ?>
<tr>
<td><?= $stu['id'] ?></td>
<td><?= $stu['fullname'] ?></td>

<?php for($s=1;$s<=6;$s++): 
    $row = $conn->query("SELECT present, participated FROM attendance_records WHERE student_id={$stu['id']} AND session_number={$s}")->fetch_assoc();
    $present_val = $row['present'] ?? 0;
    $participated_val = $row['participated'] ?? 0;
?>
<td><input type="checkbox" name="p[<?= $stu['id'] ?>][<?= $s ?>]" <?= $present_val ? "checked" : "" ?>></td>
<td><input type="checkbox" name="pa[<?= $stu['id'] ?>][<?= $s ?>]" <?= $participated_val ? "checked" : "" ?>></td>
<?php endfor; ?>

<?php
$note_val = $conn->query("SELECT note FROM attendance_records WHERE student_id={$stu['id']} ORDER BY session_number DESC LIMIT 1")->fetch_assoc()['note'] ?? '';
?>
<td><input type="text" name="message[<?= $stu['id'] ?>]" value="<?= htmlspecialchars($note_val) ?>" placeholder="Message"></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<button type="submit" name="save_attendance">Save Attendance</button>
</form>
</div>

</body>
</html>
