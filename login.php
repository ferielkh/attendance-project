<?php
session_start();

// Hardcoded users
$users = [
    "feriel" => [
        "password" => "1234",
        "role" => "student",
        "student_id" => 1,
        "name" => "Feriel"
    ],
    "hemili" => [
        "password" => "1234",
        "role" => "professor",
        "name" => "Hemili"
    ],
    "admin" => [
        "password" => "1234",
        "role" => "admin",
        "name" => "Admin"
    ]
];

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        $_SESSION['name'] = $users[$username]['name'];

        if ($users[$username]['role'] === "student") {
            $_SESSION['student_id'] = $users[$username]['student_id'];
            header("Location: student_home.php");
        } elseif ($users[$username]['role'] === "professor") {
            header("Location: professor_home.php");
        } else {
            header("Location: admin_home.php");
        }
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body { font-family: Arial; display:flex; justify-content:center; align-items:center; height:100vh; background:#f0f4f7;}
form { background:white; padding:20px 30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
input { display:block; margin-bottom:10px; padding:8px; width:200px; }
button { padding:8px 15px; background:#2b6a4a; color:white; border:none; border-radius:5px; cursor:pointer; }
small { color:red; }
</style>
</head>
<body>
<form method="POST">
<h2>Login</h2>
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit">Login</button>
<small><?= $error ?></small>
</form>
</body>
</html>
