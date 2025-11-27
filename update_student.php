<?php
require 'db_connect.php';

$conn = getConnection();

if (!$conn) {
    die("Connection failed");
}

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Student ID missing");
}

// Fetch existing data
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found");
}

// Update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $matricule = $_POST['matricule'];
    $group_id = $_POST['group_id'];

    $sql = "UPDATE students SET fullname = ?, matricule = ?, group_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$fullname, $matricule, $group_id, $id])) {
        echo "Student updated successfully!<br>";
        echo "<a href='list_students.php'>Back to list</a>";
    } else {
        echo "Error updating student.";
    }
}
?>

<form method="POST">
    Full Name: <input type="text" name="fullname" value="<?= $student['fullname'] ?>" required><br>
    Matricule: <input type="text" name="matricule" value="<?= $student['matricule'] ?>" required><br>
    Group ID: <input type="text" name="group_id" value="<?= $student['group_id'] ?>" required><br>
    <input type="submit" value="Update Student">
</form>
