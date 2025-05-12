<?php
// Start session, clear all session variables, and destroy the session
session_start();
session_unset();
session_destroy();

// Redirect user to the login page
header("Location: ./login.php");
exit();
?>