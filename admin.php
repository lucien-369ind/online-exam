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
            <img src="logo.png" alt="Online Exam Logo" class="logo"> <!-- Change src to your logo file/URL here -->
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
        <img src="logo.png" alt="Online Exam Logo" class="logo"> <!-- Change src to your logo file/URL here -->
        <h1>Admin Panel</h1>
        <p><a href="index.php" class="back-link">← Back to Home</a> | <a href="?logout=1" class="back-link">Logout</a></p>
        
        <?php if ($success): ?><p class="success"><?php echo htmlspecialchars($success); ?></p><?php endif; ?>
        
        <h2>Select Subject</h2>
        <div class="button-grid">
            <a href="?subject=math" class="btn subject-btn <?php echo $subject == 'math' ? 'active' : ''; ?>">Mathematics</a>
            <a href="?subject=science" class="btn subject-btn <?php echo $subject == 'science' ? 'active' : ''; ?>">Science</a>
            <a href="?subject=english" class="btn subject-btn <?php echo $subject == 'english' ? 'active' : ''; ?>">English</a>
            <a href="?subject=history" class="btn subject-btn <?php echo $subject == 'history' ? 'active' : ''; ?>">History</a>
        </div>
        
        <h3>Editing: <?php echo ucfirst($subject); ?> (<?php echo count($questions); ?> questions)</h3>
        
        <div class="question-list">
            <?php if (empty($questions)): ?>
                <p>No questions yet. Add one below!</p>
            <?php else: ?>
                <?php foreach ($questions as $q): ?>
                    <div class="question-item">
                        <h4><?php echo htmlspecialchars($q['question_text']); ?></h4>
                        <p><strong>Options:</strong><br>A: <?php echo htmlspecialchars($q['option_a']); ?><br>B: <?php echo htmlspecialchars($q['option_b']); ?><br>C: <?php echo htmlspecialchars($q['option_c']); ?><br>D: <?php echo htmlspecialchars($q['option_d']); ?><br><strong>Correct:</strong> <?php echo $q['correct_option']; ?></p>
                        <button class="edit-btn" onclick="editQuestion('<?php echo $q['id']; ?>', '<?php echo addslashes($q['question_text']); ?>', '<?php echo addslashes($q['option_a']); ?>', '<?php echo addslashes($q['option_b']); ?>', '<?php echo addslashes($q['option_c']); ?>', '<?php echo addslashes($q['option_d']); ?>', '<?php echo $q['correct_option']; ?>')">Edit</button>
                        <a href="process_admin.php?action=delete&id=<?php echo $q['id']; ?>&subject=<?php echo $subject; ?>" class="delete-btn" onclick="return confirm('Delete this question?')">Delete</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="admin-form">
            <h3>Add New Question</h3>
            <form id="adminForm" method="POST" action="process_admin.php">
                <input type="hidden" name="subject" value="<?php echo $subject; ?>">
                <input type="hidden" name="id" id="questionId" value="0">
                <input type="hidden" name="action" value="save">
                
                <label>Question Text:</label>
                <textarea name="question_text" id="questionText" required></textarea>
                
                <label>Option A:</label>
                <input type="text" name="option_a" id="optionA" required>
                
                <label>Option B:</label>
                <input type="text" name="option_b" id="optionB" required>
                
                <label>Option C:</label>
                <input type="text" name="option_c" id="optionC" required>
                
                <label>Option D:</label>
                <input type="text" name="option_d" id="optionD" required>
                
                <label>Correct Option (A/B/C/D):</label>
                <select name="correct_option" id="correctOption" required>
                    <option value="">Select</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
                
                <button type="submit" class="save-btn">Save Question</button>
                <button type="button" class="clear-btn" onclick="clearForm()">Clear</button>
            </form>
        </div>
    </div>
</body>
</html>
