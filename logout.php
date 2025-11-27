<?php
session_start();

// Handle logout
if (isset($_POST['confirm_logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Logout</title>
<link rel="stylesheet" href="style.css">
<style>
body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.cart {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    text-align: center;
}

h2 {
    color: #2b6a4a;
}

p {
    margin-top: 10px;
    font-size: 16px;
}

form {
    display: flex;
    justify-content: space-between;
    margin-top: 30px;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.back-btn {
    background: #2b6a4a;
    color: white;
}

.back-btn:hover {
    background: #1f4d3a;
}

.logout-btn {
    background: #c0392b;
    color: white;
}

.logout-btn:hover {
    background: #e74c3c;
}

.logout-btn svg {
    width: 16px;
    height: 16px;
    fill: white;
}
</style>
</head>
<body>

<div class="cart">
    <h2>Logout Confirmation</h2>
    <p>Are you sure you want to log out?</p>
    <form method="POST">
        <button type="button" class="back-btn" onclick="history.back();">Back</button>
        <button type="submit" name="confirm_logout" class="logout-btn">
            <!-- Logout Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M502.6 273l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9L426.1 288H192c-13.3 0-24-10.7-24-24s10.7-24 24-24h234.1l-21.4-21.4c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c9.4 9.4 9.4 24.6 0 33.9zM336 416v-48c0-13.3 10.7-24 24-24h64c13.3 0 24 10.7 24 24v48c0 13.3-10.7 24-24 24h-64c-13.3 0-24-10.7-24-24zm0-288V80c0-13.3 10.7-24 24-24h64c13.3 0 24 10.7 24 24v48c0 13.3-10.7 24-24 24h-64c-13.3 0-24-10.7-24-24z"/>
            </svg>
            Logout
        </button>
    </form>
</div>

</body>
</html>
