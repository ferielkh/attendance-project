<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['studentID'];
    $last = $_POST['lastName'];
    $first = $_POST['firstName'];
    $email = $_POST['email'];

    $errors = [];

    if (empty($id) || !preg_match("/^[0-9]+$/", $id)) {
        $errors[] = "Student ID must be numbers only.";
    }
    if (empty($last) || !preg_match("/^[A-Za-z]+$/", $last)) {
        $errors[] = "Last Name must be letters only.";
    }
    if (empty($first) || !preg_match("/^[A-Za-z]+$/", $first)) {
        $errors[] = "First Name must be letters only.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        echo "<p style='color:green;'>Student Added: $first $last ($id) - $email</p>";
    }
}
?>
