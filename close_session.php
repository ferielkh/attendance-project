<?php
require 'db_connect.php';

$conn = getConnection();

$session_id = $_GET['id'] ?? null;

if (!$session_id) {
    die("Session ID missing.");
}

$sql = "UPDATE attendance_sessions SET status = 'closed' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$session_id]);

echo "Session $session_id has been closed.";
?>
