<?php
require_once 'php/database/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST['name'];
    $surname = $_POST['surname'];
    $email   = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $database = new Database();
    $conn = $database->connect();

    $stmt = $conn->prepare("
        INSERT INTO messages (name, surname, email, subject, message) 
        VALUES (?, ?, ?, ?, ?)
    ");

    // Execute the statement with the submitted values
    if ($stmt->execute([$name, $surname, $email, $subject, $message])) {
        header('Location: /FinalProject/thankyou.php');
        exit();
    } else {
        echo "Error occurred while inserting data.";
    }
}
