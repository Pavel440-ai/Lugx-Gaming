<?php

use classes\QnA;
session_start();

require_once 'classes/QnA.php';
$qna = new QnA();

$isAdmin = isset($_SESSION['rola']) && $_SESSION['rola'] === 'admin';

if (isset($_GET['delete']) && $isAdmin) {
    $qna->deleteQnA((int)$_GET['delete']);
    header("Location: qna.php?deleted=1");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $answer   = $_POST['answer'];

    if (!empty($question) && !empty($answer)) {
        if ($qna->insertQnA($question, $answer)) {
            header("Location: qna.php?success=1");
            exit();
        } else {
            $error = "Error while adding data!";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

$questions = $qna->getQnA();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and page title -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lugx Gaming - QnA Page</title>

    <!-- Include Bootstrap styles and additional CSS files -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/qna.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>
<body>
<!-- Preloader element -->
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

<?php include 'php/header.php'; ?>

<!-- Page heading -->
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Questions and Answers</h3>
                <span class="breadcrumb"><a href="index.php">Home</a> &gt; QnA</span>
            </div>
        </div>
    </div>
</div>

<!-- Main QnA section -->
<div class="section trending">
    <div class="container">
        <!-- Display notifications for completed actions -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Question and answer added successfully!</div>
        <?php elseif (isset($_GET['deleted'])): ?>
            <div class="alert alert-warning">Entry successfully deleted.</div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Form for adding a new QnA entry -->
        <div class="row mt-5">
            <div class="col-lg-8 offset-lg-2">
                <div class="contact-form p-5 bg-light rounded shadow-sm">
                    <h4 class="mb-4 text-center">Add a New Question and Answer</h4>
                    <form method="post" action="qna.php">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <input type="text" name="question" id="question" class="form-control" placeholder="Enter your question..." required>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <textarea name="answer" id="answer" class="form-control" rows="4" placeholder="Enter the answer..." required></textarea>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <?php foreach ($questions as $item): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="qna-item h-100">
                        <h5><?= htmlspecialchars($item['question']); ?></h5>
                        <p><?= htmlspecialchars($item['answer']); ?></p>
                        <?php if ($isAdmin): ?>
                            <a href="admin/edit_qna.php?id=<?= (int)$item['id']; ?>" class="btn
                            btn-primary btn-sm">Edit</a>
                            <a href="qna.php?delete=<?= (int)$item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include 'php/footer.php'; ?>

<!-- Include necessary JS files (e.g., Bootstrap) -->
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/preloader.js"></script>
<!-- Include a separate file for the preloader -->
<script src='assets/js/preloader.js' type="text/javascript"></script>
</body>
</html>
