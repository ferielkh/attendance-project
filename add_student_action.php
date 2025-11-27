<?php
require 'db_connect.php';

$conn = getConnection();
header('Content-Type: application/json'); // we'll return JSON

if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['studentID'];
    $last = $_POST['lastName'];
    $first = $_POST['firstName'];
    $email = $_POST['email'];

    // simple server-side validation
    if (!preg_match("/^[0-9]+$/", $id) || !preg_match("/^[A-Za-z]+$/", $last) || !preg_match("/^[A-Za-z]+$/", $first) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit;
    }

    $sql = "INSERT INTO students (student_id, last_name, first_name, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([$id, $last, $first, $email])) {
        echo json_encode(['status' => 'success', 'student' => ['id'=>$id,'last'=>$last,'first'=>$first,'email'=>$email]]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add student']);
    }
}
?>
