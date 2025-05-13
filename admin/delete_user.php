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
    // If form is submitted, process deletion
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        if ($userClass->deleteUser($id)) {
            header("Location: manage_users.php?deleted=1");
            exit();
        } else {
            echo "Error deleting user.";
        }
    } else {
        header("Location: manage_users.php");
        exit();
    }
} else {
    if (!isset($_GET['id'])) {
        header("Location: manage_users.php");
        exit();
    }

    $id = intval($_GET['id']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Confirm Deletion</title>
        <link rel="stylesheet" href="../assets/css/delete_user.css">
    </head>
    <body>
    <div class="container">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete the user with ID: <?php echo $id; ?>?</p>
        <form method="POST" action="delete_user.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Delete">
            <a href="manage_users.php">Cancel</a>
        </form>
    </div>
    </body>
    </html>
    <?php
}
?>