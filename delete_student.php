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

$sql = "DELETE FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt->execute([$id])) {
    echo "Student deleted successfully!";
    echo "<br><a href='list_students.php'>Back to list</a>";
} else {
    echo "Error deleting student";
}
?>
