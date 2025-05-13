<?php
session_start();
if (!isset($_SESSION['rola']) || $_SESSION['rola'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>

<div class="admin-wrapper">
    <div class="admin-form">
        <h1>Admin Panel</h1>
        <p>Welcome, Admin. Choose an action:</p>

        <form>
            <div class="form-group">
                <a href="./manage_users.php" class="btn btn-outline-primary btn-block mb-3">Manage Users</a>
            </div>
            <div class="form-group">
                <a href="../qna.php" class="btn btn-outline-success btn-block mb-4">Manage QnA</a>
            </div>
            <div class="form-group">
                <a href="../index.php" class="btn btn-link">Back to Home</a>
            </div>
        </form>
    </div>
</div>

<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
