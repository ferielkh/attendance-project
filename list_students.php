<?php
require 'db_connect.php';

$conn = getConnection();

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT * FROM students";
$stmt = $conn->query($sql);

echo "<h2>Students List</h2>";

$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($students) {
    echo "<table border='1' cellpadding='5'>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Matricule</th>
                <th>Group ID</th>
                <th>Actions</th>
            </tr>";

    foreach ($students as $row) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['matricule']}</td>
                <td>{$row['group_id']}</td>
                <td>
                    <a href='update_student.php?id={$row['id']}'>Edit</a> |
                    <a href='delete_student.php?id={$row['id']}'>Delete</a>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No students found.";
}
?>
