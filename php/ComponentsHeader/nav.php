<?php
// Start the session if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="main-nav">
    <!-- Logo linking to the homepage -->
    <a href="index.php" class="logo">
        <img src="assets/images/logo.png" alt="Logo" style="width: 158px;">
    </a>

    <!-- Navigation menu -->
    <ul class="nav">
        <?php if (isset($_SESSION['rola']) && $_SESSION['rola'] === 'admin'): ?>
            <!-- Link to the admin panel for admin users -->
            <li><a href="admin/admin.php">Admin Panel</a></li>
        <?php endif; ?>

        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="shop.php">Our Shop</a></li>
        <li><a href="product-details.php">Product Details</a></li>
        <li><a href="qna.php">QnA</a></li>
        <li><a href="contact.php">Contact Us</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Show logout option with the username -->
            <li><a href="auth/logout.php">Logout (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
        <?php else: ?>
            <!-- Show login option if the user is not logged in -->
            <li><a href="auth/login.php">Login</a></li>
        <?php endif; ?>
    </ul>

    <!-- Mobile menu trigger -->
    <a class="menu-trigger">
        <span>Menu</span>
    </a>
</nav>