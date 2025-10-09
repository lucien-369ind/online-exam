<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Examination Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Online Examination Portal</h1>
        <p>Select a subject to start the MCQ-based exam.</p>
        <div class="button-grid">
            <a href="quiz.php?subject=math" class="btn">Mathematics</a>
            <a href="quiz.php?subject=science" class="btn">Science</a>
            <a href="quiz.php?subject=english" class="btn">English</a>
            <a href="quiz.php?subject=history" class="btn">History</a>
        </div>
        <a href="admin.php" class="btn admin-btn">Admin Panel (Edit Questions)</a>
    </div>
</body>

</html>
