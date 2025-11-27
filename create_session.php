<?php
require 'db_connect.php';

$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $group_id = $_POST['group_id'];
    $opened_by = $_POST['opened_by'];

    $sql = "INSERT INTO attendance_sessions (course_id, group_id, opened_by, status)
            VALUES (?, ?, ?, 'open')";
    $stmt = $conn->prepare($sql);

    $stmt->execute([$course_id, $group_id, $opened_by]);

    $session_id = $conn->lastInsertId();

    echo "Session created! ID = " . $session_id;
}
?>

<form method="POST">
    Course: <input type="text" name="course_id" required><br>
    Group: <input type="text" name="group_id" required><br>
    Professor ID: <input type="text" name="opened_by" required><br>
    <button type="submit">Create Session</button>
</form>
