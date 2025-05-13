<?php
session_start();
if (!isset($_SESSION['rola']) || $_SESSION['rola'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

require_once '../classes/Users.php';
use classes\Users;
$usersClass = new Users();

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';
$users     = ($searchTerm !== '') ? $usersClass->searchUsers($searchTerm) : $usersClass->getAllUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/manage_users.css">
</head>
<body>
<div class="container mt-4">
    <!-- Back Button -->
    <a href="../admin/admin.php" class="back-btn">Back</a>
</div>

<div class="admin-container">
    <h1>User Management</h1>
    <!-- Search form and Add User link -->
    <div class="row search-box mb-3">
        <div class="col-md-6">
            <form method="GET" action="manage_users.php">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search User" value="<?php echo htmlspecialchars($searchTerm); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a href="add_user.php" class="btn btn-primary">Add User</a>
        </div>
    </div>

    <!-- Users Table -->
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($users): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['login']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['rola']); ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger action-btn">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">No users found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>