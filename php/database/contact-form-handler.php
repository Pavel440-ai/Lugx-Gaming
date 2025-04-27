<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_form";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO messages (name, surname, email, subject, message) 
            VALUES ('$name', '$surname', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        header('Location: /FinalProject/thankyou.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();

