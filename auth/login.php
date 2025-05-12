<?php
use classes\Database;

session_start();
require_once '../classes/Database.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    $email    = $_POST['login_email'];
    $password = $_POST['login_password'];

    if (!empty($email) && !empty($password)) {
        $database = new Database();
        $conn = $database->connect();

        $stmt = $conn->prepare('SELECT * FROM users_db WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['heslo'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['login'];
            $_SESSION['rola'] = $user['rola'];

            header('Location: ../index.php');
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Please fill in both fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
<div class="registration-container">
    <h2>Login</h2>
    <form method="post" action="">
        <input type="hidden" name="login_submit" value="1">
        <label for="login_email">Email:</label>
        <input type="email" name="login_email" id="login_email" required>
        <label for="login_password">Password:</label>
        <input type="password" name="login_password" id="login_password" required>
        <button type="submit">Log in</button>
    </form>
    <p style="margin-top: 20px;">Don't have an account? <a href="register.php">Create one</a></p>
    <?php if (!empty($error)): ?>
        <p class="error-message" style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
</div>
</body>
</html>