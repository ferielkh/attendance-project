<?php
session_start();
include "config.php";
include "student_navbar.php"; // your navbar for students

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Get student info
$stmt = $conn->prepare("SELECT fullname FROM students WHERE id=?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($fullname);
$stmt->fetch();
$stmt->close();

// Handle justification submission
if(isset($_POST['submit_justification'])){
    $session_id = $_POST['session_id'];
    $justification = $_POST['justification'];

    // Insert into justification table
    $stmt2 = $conn->prepare("INSERT INTO justification (student_id, session_number, justification, submitted_at) VALUES (?, ?, ?, NOW())");
    $stmt2->bind_param("iis", $student_id, $session_id, $justification);
    $stmt2->execute();
    $stmt2->close();

    $success = "Justification submitted successfully!";
}

// Get student's attendance summary
$stmt3 = $conn->prepare("
    SELECT student_id, session_number, present, participated, note
    FROM attendance_records
    WHERE student_id=?
");
$stmt3->bind_param("i", $student_id);
$stmt3->execute();
$res = $stmt3->get_result();
$attendance = $res->fetch_all(MYSQLI_ASSOC);
$stmt3->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Attendance</title>
<style>
body { font-family: Arial; background:#f0f4f7; padding:20px; }
.cart { background:#fff; padding:20px; border-radius:10px; width:80%; margin:20px auto; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
table { width:100%; border-collapse:collapse; margin-top:20px; }
th, td { padding:10px; border:1px solid #ccc; text-align:center; }
th { background:#2b6a4a; color:white; }
textarea { width:90%; }
button { padding:5px 10px; border:none; border-radius:5px; background:#2b6a4a; color:white; cursor:pointer; }
button:hover { background:#1f4d3a; }
.success { color: green; }
</style>
</head>
<body>

<div class="cart">
<h2>🌿 My Attendance 🌿</h2>
<p><strong>Student:</strong> <?= htmlspecialchars($fullname ?? '') ?></p>

<?php if(isset($success)) echo "<p class='success'>{$success}</p>"; ?>

<table>
<tr>
<th>Session</th>
<th>Presence</th>
<th>Participation</th>
<th>Message / Note</th>
<th>Justification</th>
</tr>

<?php foreach($attendance as $row): ?>
<tr>
<td><?= $row['session_number'] ?></td>
<td><?= $row['present'] ? 'Yes' : 'No' ?></td>
<td><?= $row['participated'] ? 'Yes' : 'No' ?></td>
<td><?= htmlspecialchars($row['note'] ?? '') ?></td>
<td>
    <?php if(!$row['present']): ?>
    <form method="POST">
        <input type="hidden" name="session_id" value="<?= $row['session_number'] ?>">
        <textarea name="justification" placeholder="Enter justification" required></textarea><br>
        <button type="submit" name="submit_justification">Submit</button>
    </form>
    <?php else: ?>
        -
    <?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</table>

</div>
</body>
</html>
