<?php
require_once 'functions.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$subject = $_POST['subject'] ?? $_GET['subject'] ?? '';
$id = $_POST['id'] ?? $_GET['id'] ?? 0;

if (!in_array($subject, $validSubjects)) {
    die('Invalid subject.');
}

$questions = loadQuestions($subject);

if ($action === 'save') {
    // Add or Edit
    $questionText = trim($_POST['question_text'] ?? '');
    $optA = trim($_POST['option_a'] ?? '');
    $optB = trim($_POST['option_b'] ?? '');
    $optC = trim($_POST['option_c'] ?? '');
    $optD = trim($_POST['option_d'] ?? '');
    $correct = strtoupper(trim($_POST['correct_option'] ?? ''));

    if (empty($questionText) || empty($optA) || empty($optB) || empty($optC) || empty($optD) || !in_array($correct, ['A', 'B', 'C', 'D'])) {
        header("Location: admin.php?subject=$subject&error=Invalid input.");
        exit;
    }

    $editId = (int)$id;
    if ($editId > 0) {
        // Edit existing
        foreach ($questions as &$q) {
            if ($q['id'] == $editId) {
                $q['question_text'] = $questionText;
                $q['option_a'] = $optA;
                $q['option_b'] = $optB;
                $q['option_c'] = $optC;
                $q['option_d'] = $optD;
                $q['correct_option'] = $correct;
                break;
            }
        }
        $message = 'Question updated successfully!';
    } else {
        // Add new
        $newId = max(array_column($questions, 'id')) + 1;
        $questions[] = [
            'id' => $newId,
            'question_text' => $questionText,
            'option_a' => $optA,
            'option_b' => $optB,
            'option_c' => $optC,
            'option_d' => $optD,
            'correct_option' => $correct
        ];
        $message = 'Question added successfully!';
    }

    saveQuestions($subject, $questions);
    header("Location: admin.php?subject=$subject&success=" . urlencode($message));
    exit;
} elseif ($action === 'delete') {
    // Delete
    $deleteId = (int)$id;
    $questions = array_filter($questions, function($q) use ($deleteId) {
        return $q['id'] != $deleteId;
    });
    $questions = array_values($questions); // Re-index
    saveQuestions($subject, $questions);
    $message = 'Question deleted successfully!';
    header("Location: admin
