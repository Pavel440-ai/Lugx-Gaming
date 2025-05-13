<?php
session_start();
if (!isset($_SESSION['rola']) || $_SESSION['rola'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once '../classes/Users.php';
use classes\Users;
$userClass = new Users();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id       = intval($_POST['id']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $rola     = trim($_POST['rola']);
    $password = !empty($_POST['password']) ? trim($_POST['password']) : null;

    if ($userClass->updateUser($id, $username, $email, $password, $rola)) {
        header("Location: manage_users.php?updated=1");
        exit();
    } else {
        $error = "Error updating user data.";
    }
} else {
    if (!isset($_GET['id'])) {
        header("Location: manage_users.php");
        exit();
    }

    $id = intval($_GET['id']);
    $userData = $userClass->getUserById($id);
    if (!$userData) {
        header("Location: manage_users.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
</head>
<body>
<div class="registration-container">
    <h2>Edit User</h2>
    <?php if (isset($error)): ?>
        <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="edit_user.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($userData['id']); ?>">

        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($userData['login']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>

        <label for="password">Password (leave blank to keep unchanged):</label>
        <input type="password" name="password" id="password">

        <label for="rola">Role:</label>
        <select name="rola" id="rola">
            <option value="user" <?php echo ($userData['rola'] === 'user') ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?php echo ($userData['rola'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>

        <button type="submit">Update Data</button>
    </form>
    <p><a href="manage_users.php">Go Back</a></p>
</div>
</body>
</html>