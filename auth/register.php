<?php
use classes\Database;

session_start();
require_once '../classes/Database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $login    = $_POST['login'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $database       = new Database();
        $conn           = $database->connect();

        $stmt = $conn->prepare('SELECT * FROM users_db WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $error = "User with this email already exists!";
        } else {
            $stmt = $conn->prepare('INSERT INTO users_db (login, email, heslo, rola) VALUES (?, ?, ?, ?)');
            if ($stmt->execute([$login, $email, $hashedPassword, 'user'])) {
                $userId = $conn->lastInsertId();
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $login;
                $_SESSION['rola'] = 'user';

                header("Location: /FinalProject/index.php");
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
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<div class="registration-container">
    <h2>Register</h2>
    <form method="post" action="">
        <input type="hidden" name="register" value="1">
        <label for="login">Username:</label>
        <input type="text" name="login" id="login" required>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Register</button>
    </form>
    <p style="margin-top: 20px;">Already have an account? <a href="login.php">Log in</a></p>
    <?php if (!empty($error)): ?>
        <p class="error-message" style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</div>
</body>
</html>