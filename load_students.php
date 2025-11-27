<?php
include "config.php";

// Only allow professor
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'professor') {
    echo "Access denied";
    exit;
}

if(!isset($_GET['group'])) {
    echo "No group selected";
    exit;
}

$group_id = $_GET['group'];

// Fetch students in this group
$stmt = $conn->prepare("SELECT id, fullname FROM students WHERE group_id=?");
$stmt->bind_param("i", $group_id);
$stmt->execute();
$result = $stmt->get_result(); // easier than bind_result
?>

<form method="POST" action="save_attendance.php">
<table border="1" cellpadding="5" cellspacing="0">
<tr>
    <th>Student ID</th>
    <th>Full Name</th>
    <th>Attendance</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlspecialchars($row['fullname']) ?></td>
    <td>
        <select name="student[<?= $row['id'] ?>]">
            <option value="present">Present</option>
            <option value="absent">Absent</option>
        </select>
    </td>
</tr>
<?php endwhile; ?>
</table>

<button type="submit">Save Attendance</button>
</form>

<?php
$stmt->close();
?>
