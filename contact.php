<?php
$host     = 'localhost';
$dbname   = 'lugx_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = htmlspecialchars(trim($_POST['name']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    $sql  = "INSERT INTO messages (name, surname, email, subject, message) 
             VALUES (:name, :surname, :email, :subject, :message)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name'    => $name,
            ':surname' => $surname,
            ':email'   => $email,
            ':subject' => $subject,
            ':message' => $message
        ]);
        include './thankyou.php';
        exit;
    } catch (PDOException $e) {
        echo "Error saving your message: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lugx Gaming Template - Contact Page</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>
<body>
<!-- Preloader Start -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- Preloader End -->

<!-- Header Area Start -->
<?php include 'php/header.php'; ?>
<!-- Header Area End -->

<!-- Page Heading -->
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Contact Us</h3>
                <span class="breadcrumb"><a href="index.php">Home</a> &gt; Contact Us</span>
            </div>
        </div>
    </div>
</div>

<!-- Contact Page Section -->
<div class="contact-page section">
    <div class="container">
        <div class="row">
            <!-- Left column with contact information -->
            <div class="col-lg-6 align-self-center">
                <div class="left-text">
                    <div class="section-heading">
                        <h6>Contact Us</h6>
                        <h2>Say Hello!</h2>
                    </div>
                    <p>
                        Lugx Gaming Template is built on Bootstrap 5 and is perfectly suited for your gaming website.
                        Use this template according to your needs. Thank you.
                    </p>
                    <ul>
                        <li><span>Address:</span> Sunny Isles Beach, FL 33160, United States</li>
                        <li><span>Phone:</span> +123 456 7890</li>
                        <li><span>Email:</span> lugx@contact.com</li>
                    </ul>
                </div>
            </div>

            <!-- Right column with the contact form -->
            <div class="col-lg-6">
                <div class="contact-form">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Your first name" required>
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Last Name</label>
                            <input type="text" name="surname" class="form-control" id="surname" placeholder="Your last name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" class="form-control" id="message" rows="5" placeholder="Your message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'php/footer.php'; ?>

<!-- Scripts -->
<!-- jQuery (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript Bundle -->
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Custom JavaScript -->
<script src="assets/js/custom.js"></script>
</body>
</html>