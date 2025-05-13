<?php
session_start();

if (!isset($_SESSION['rola']) || $_SESSION['rola'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once '../classes/Users.php';
use classes\Users;

$userClass = new Users();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rola     = trim($_POST['rola']);

    if (!empty($username) && !empty($email) && !empty($password) && !empty($rola)) {
        if ($userClass->addUser($username, $email, $password, $rola)) {
            header("Location: manage_users.php?added=1");
            exit();
        } else {
            $error = "Error adding user.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="registration-container">
    <h2>Add User</h2>
    <?php if ($error): ?>
        <p class="error-message" style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="add_user.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="rola">Role:</label>
        <select name="rola" id="rola" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Add User</button>
    </form>
    <p style="margin-top: 20px;"><a href="manage_users.php">Go Back</a></p>
</div>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>