<?php
// form.php

// Set header for JSON response (optional)
header('Content-Type: application/json');

// Simple server-side validation
if(isset($_POST['studentID'], $_POST['lastName'], $_POST['firstName'], $_POST['email'])){
    $studentID = $_POST['studentID'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];

    // Optional: you can add more validation here (email format, unique ID, etc.)

    // Normally you'd save to a database, but for now we'll just return success
    echo json_encode([
        'status' => 'success',
        'studentID' => $studentID,
        'lastName' => $lastName,
        'firstName' => $firstName,
        'email' => $email
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields.'
    ]);
}
?>
