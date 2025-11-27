<?php
session_start();
include "config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] !== "student") {
    header("Location: login.php");
    exit;
}

$attendance_id = $_POST['attendance_id'];
$justification = $_POST['justification'];

// Update attendance
$stmt = $conn->prepare("UPDATE attendance SET justification=?, justification_status='pending' WHERE id=?");
$stmt->bind_param("si", $justification, $attendance_id);
$stmt->execute();

header("Location: student_attendance.php");
exit;
