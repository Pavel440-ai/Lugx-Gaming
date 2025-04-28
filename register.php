<?php
session_start();
require_once 'php/database/Database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login    = $_POST['login'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $database = new Database();
        $conn = $database->connect();

        $stmt = $conn->prepare('SELECT * FROM users_db WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "User with this email already exists!";
        } else {
            $stmt = $conn->prepare('INSERT INTO users_db (login, email, heslo) VALUES (?, ?, ?)');
            if ($stmt->execute([$login, $email, $hashedPassword])) {
                header('Location: index.php');
                exit();
            } else {
                $error = "Registration failed!";
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
<div class="registration-container">
    <h2>Registration</h2>
    <form method="post" action="register.php">
        <label for="login">Username:</label>
        <input type="text" name="login" id="login" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Register</button>
    </form>
    <?php if (!empty($error)) : ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
</div>
</body>
</html>