<?php
session_start(); // For admin sessions

// Valid subjects
$validSubjects = ['math', 'science', 'english', 'history'];

// Function to load questions from JSON
function loadQuestions($subject) {
    global $validSubjects;
    if (!in_array($subject, $validSubjects)) {
        return [];
    }
    $file = 'data/' . $subject . '.json';
    if (!file_exists($file)) {
        // Create default file if missing
        saveQuestions($subject, getDefaultQuestions($subject));
    }
    $json = file_get_contents($file);
    return json_decode($json, true) ?: [];
}

// Function to save questions to JSON
function saveQuestions($subject, $questions) {
    $file = 'data/' . $subject . '.json';
    $json = json_encode($questions, JSON_PRETTY_PRINT);
    file_put_contents($file, $json);
}

// Default questions (embedded; used if file missing)
function getDefaultQuestions($subject) {
    $defaults = [
        'math' => [
            ['id' => 1, 'question_text' => 'What is 2 + 2?', 'option_a' => 'A. 3', 'option_b' => 'B. 4', 'option_c' => 'C. 5', 'option_d' => 'D. 6', 'correct_option' => 'B'],
            ['id' => 2, 'question_text' => 'Solve for x: x^2 = 4', 'option_a' => 'A. x=2', 'option_b' => 'B. x=4', 'option_c' => 'C. x=±2', 'option_d' => 'D. x=0', 'correct_option' => 'C'],
            ['id' => 3, 'question_text' => 'What is the area of a circle with radius 1? (π ≈ 3.14)', 'option_a' => 'A. 3.14', 'option_b' => 'B. 6.28', 'option_c' => 'C. 2', 'option_d' => 'D. 1', 'correct_option' => 'A'],
            ['id' => 4, 'question_text' => 'Simplify: 8/2 * 3', 'option_a' => 'A. 12', 'option_b' => 'B. 4', 'option_c' => 'C. 24', 'option_d' => 'D. 6', 'correct_option' => 'A'],
            ['id' => 5, 'question_text' => 'What is the derivative of x^2?', 'option_a' => 'A. 2x', 'option_b' => 'B. x', 'option_c' => 'C. 2', 'option_d' => 'D. x^2', 'correct_option' => 'A']
        ],
        'science' => [
            ['id' => 1, 'question_text' => 'What is H2O?', 'option_a' => 'A. Oxygen', 'option_b' => 'B. Water', 'option_c' => 'C. Hydrogen', 'option_d' => 'D. Salt', 'correct_option' => 'B'],
            ['id' => 2, 'question_text' => 'Which planet is known as the Red Planet?', 'option_a' => 'A. Earth', 'option_b' => 'B. Mars', 'option_c' => 'C. Jupiter', 'option_d' => 'D. Venus', 'correct_option' => 'B'],
            ['id' => 3, 'question_text' => 'What is the basic unit of life?', 'option_a' => 'A. Atom', 'option_b' => 'B. Cell', 'option_c' => 'C. Molecule', 'option_d' => 'D. Organ', 'correct_option' => 'B'],
            ['id' => 4, 'question_text' => 'E=mc² is from which scientist?', 'option_a' => 'A. Newton', 'option_b' => 'B. Einstein', 'option_c' => 'C. Galileo', 'option_d' => 'D. Tesla', 'correct_option' => 'B'],
            ['id' => 5, 'question_text' => 'What gas do plants absorb?', 'option_a' => 'A. Oxygen', 'option_b' => 'B. Carbon Dioxide', 'option_c' => 'C. Nitrogen', 'option_d' => 'D. Helium', 'correct_option' => 'B']
        ],
        'english' => [
            ['id' => 1, 'question_text' => 'What is a synonym for "happy"?', 'option_a' => 'A. Sad', 'option_b' => 'B. Joyful', 'option_c' => 'C. Angry', 'option_d' => 'D. Tired', 'correct_option' => 'B'],
            ['id' => 2, 'question_text' => 'Identify the verb in "She runs fast."', 'option_a' => 'A. She', 'option_b' => 'B. Runs', 'option_c' => 'C. Fast', 'option_d' => 'D. The', 'correct_option' => 'B'],
            ['id' => 3, 'question_text' => 'What is the plural of "child"?', 'option_a' => 'A. Childs', 'option_b' => 'B. Children', 'option_c' => 'C. Childes', 'option_d' => 'D. Childs\'', 'correct_option' => 'B'],
            ['id' => 4, 'question_text' => '"To be or not to be" is from which play?', 'option_a' => 'A. Romeo and Juliet', 'option_b' => 'B. Hamlet', 'option_c' => 'C. Macbeth', 'option_d' => 'D. Othello', 'correct_option' => 'B'],
            ['id' => 5, 'question_text' => 'What does "metaphor" mean?', 'option_a' => 'A. Direct comparison', 'option_b' => 'B. Comparison using "like" or "as"', 'option_c' => 'C. Exaggeration', 'option_d' => 'D. Repetition', 'correct_option' => 'A']
        ],
        'history' => [
            ['id' => 1, 'question_text' => 'Who was the first U.S. President?', 'option_a' => 'A. Lincoln', 'option_b' => 'B. Washington', 'option_c' => 'C. Jefferson', 'option_d' => 'D. Roosevelt', 'correct_option' => 'B'],
            ['id' => 2, 'question_text' => 'In what year did World War II end?', 'option_a' => 'A. 1945', 'option_b' => 'B. 1939', 'option_c' => 'C. 1918', 'option_d' => 'D. 1941', 'correct_option' => 'A'],
            ['id' => 3, 'question_text' => 'Who invented the telephone?', 'option_a' => 'A. Edison', 'option_b' => 'B. Bell', 'option_c' => 'C. Tesla', 'option_d' => 'D. Marconi', 'correct_option' => 'B'],
            ['id' => 4, 'question_text' => 'What ancient civilization built the pyramids?', 'option_a' => 'A. Romans', 'option_b' => 'B. Greeks', 'option_c' => 'C. Egyptians', 'option_d' => 'D. Mayans', 'correct_option' => 'C'],
            ['id' => 5, 'question_text' => 'The Renaissance began in which country?', 'option_a' => 'A. France', 'option_b' => 'B. Italy', 'option_c' => 'C. England', 'option_d' => 'D. Spain', 'correct_option' => 'B']
        ]
    ];
    return $defaults[$subject] ?? [];
}
?>
