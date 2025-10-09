<?php require_once 'functions.php'; 

// Simple login check
if (!isset($_SESSION['admin_logged_in'])) {
    if (isset($_POST['login'])) {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['admin_logged_in'] = true;
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Invalid credentials.';
        }
    }
    // Show login form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>Admin Login</h1>
            <?php if (isset($error)): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
            <form method="POST">
                <label>Username: <input type="text" name="username" required style="width: 200px; padding: 5px;"></label><br><br>
                <label>Password: <input type="password" name="password" required style="width: 200px; padding: 5px;"></label><br><br>
                <button type="submit" name="login" class="btn">Login</button>
            </form>
            <p><a href="index.php" class="back-link">← Back to Home</a></p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Handle subject selection
$subject = $_GET['subject'] ?? 'math';
if (!in_array($subject, $validSubjects)) {
    $subject = 'math';
}

$questions = loadQuestions($subject);

// Handle success message
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function editQuestion(id, questionText, optA, optB, optC, optD, correct) {
            document.getElementById('questionId').value = id;
            document.getElementById('questionText').value = questionText;
            document.getElementById('optionA').value = optA;
            document.getElementById('optionB').value = optB;
            document.getElementById('optionC').value = optC;
            document.getElementById('optionD').value = optD;
            document.getElementById('correctOption').value = correct;
            document.querySelector('.admin-form h3').textContent = 'Edit Question';
        }
        function clearForm() {
            document.getElementById('adminForm').reset();
            document.getElementById('questionId').value = 0;
            document.querySelector('.admin-form h3').textContent = 'Add New Question';
        }
    </script>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Panel</h1>
        <p><a href="index.php" class="back-link">← Back to Home</a> | <a href="?logout=1" class="back-link">Logout</a></p>
        
        <?php if ($success): ?><p class="success"><?php echo htmlspecialchars($success); ?></p><?php endif; ?>
        
        <h2>Select Subject</h2>
        <div class="button-grid">
            <a href="?subject
