<?php
session_start();
include "admin_navbar.php";
include "config.php";

// Handle Add Student
if(isset($_POST['add_student'])){
    $name = $_POST['fullname'];
    if(!empty($name)){
        $stmt = $conn->prepare("INSERT INTO students (fullname) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }
}

// Handle Delete Student
if(isset($_POST['delete_student'])){
    $id = $_POST['student_id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fetch all students
$res = $conn->query("SELECT id, fullname FROM students");
$students = $res->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Students</title>
<link rel="stylesheet" href="style.css">
<style>
.cart { 
    background:#f7f7f7; 
    padding:20px; 
    border-radius:10px; 
    margin:20px auto; 
    width:80%; 
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}
table { 
    border-collapse: collapse; 
    width: 100%; 
}
th, td { 
    border:1px solid #ccc; 
    padding:8px; 
    text-align:center; 
}
th { 
    background:#2b6a4a; 
    color:white; 
}
button { 
    padding:5px 10px; 
    border:none; 
    border-radius:5px; 
    background:#2b6a4a; 
    color:white; 
    cursor:pointer; 
}
button:hover { 
    background:#1f4d3a; 
}
form.inline { display:inline; }
</style>
</head>
<body>

<div class="cart">
<h2>Students Management</h2>

<form method="POST">
<input type="text" name="fullname" placeholder="Full Name" required>
<button type="submit" name="add_student">Add Student</button>
</form>

<br>

<table>
<tr><th>ID</th><th>Name</th><th>Action</th></tr>
<?php foreach($students as $s): ?>
<tr>
    <td><?= $s['id'] ?? '-' ?></td>
    <td><?= $s['fullname'] ?? '-' ?></td>
    <td>
        <form method="POST" class="inline">
            <input type="hidden" name="student_id" value="<?= $s['id'] ?? '' ?>">
            <button type="submit" name="delete_student">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</table>
</div>

</body>
</html>
