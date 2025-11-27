<?php
require 'db_connect.php';

$conn = getConnection();

if (!$conn) {
    die("Connection failed");
}

// Form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $matricule = $_POST['matricule'];
    $group_id = $_POST['group_id'];

    $sql = "INSERT INTO students (fullname, matricule, group_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$fullname, $matricule, $group_id])) {
        echo "Student added successfully!<br>";
        echo "<a href='list_students.php'>Go to list</a>";
    } else {
        echo "Error adding student.";
    }
}
?>

<form method="POST">
    Full Name: <input type="text" name="fullname" required><br>
    Matricule: <input type="text" name="matricule" required><br>
    Group ID: <input type="text" name="group_id" required><br>
    <input type="submit" value="Add Student">
</form>
