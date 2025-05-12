<?php
session_start();
require_once __DIR__ . '/../classes/QnA.php';
use classes\QnA;
$qna = new QnA();

if (!isset($_SESSION['rola']) || $_SESSION['rola'] !== 'admin') {
    header("Location: ../qna.php");
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$entry = $qna->getQnAById($id);
if (!$entry) {
    die("QnA not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (!empty($question) && !empty($answer)) {
        $qna->updateQnA($id, $question, $answer);
        header("Location: ../qna.php?updated=1");
        exit();
    } else {
        $error = "Please fill in both fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit QnA</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Edit Question and Answer</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <!-- QnA edit form -->
    <form method="post">
        <div class="mb-3">
            <label for="question" class="form-label">Question</label>
            <input type="text" name="question" id="question" class="form-control" value="<?= htmlspecialchars($entry['question']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="answer" class="form-label">Answer</label>
            <textarea name="answer" id="answer" class="form-control" rows="4" required><?= htmlspecialchars($entry['answer']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="../qna.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<!-- Bootstrap JS -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>