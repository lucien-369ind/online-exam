CREATE DATABASE IF NOT EXISTS online_exam;
USE online_exam;

CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(50) NOT NULL,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL CHECK (correct_option IN ('A', 'B', 'C', 'D')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default sample questions (5 per subject)
INSERT INTO questions (subject, question_text, option_a, option_b, option_c, option_d, correct_option) VALUES
-- Mathematics
('math', 'What is 2 + 2?', 'A. 3', 'B. 4', 'C. 5', 'D. 6', 'B'),
('math', 'Solve for x: x^2 = 4', 'A. x=2', 'B. x=4', 'C. x=±2', 'D. x=0', 'C'),
('math', 'What is the area of a circle with radius 1? (π ≈ 3.14)', 'A. 3.14', 'B. 6.28', 'C. 2', 'D. 1', 'A'),
('math', 'Simplify: 8/2 * 3', 'A. 12', 'B. 4', 'C. 24', 'D. 6', 'A'),
('math', 'What is the derivative of x^2?', 'A. 2x', 'B. x', 'C. 2', 'D. x^2', 'A'),

-- Science
('science', 'What is H2O?', 'A. Oxygen', 'B. Water', 'C. Hydrogen', 'D. Salt', 'B'),
('science', 'Which planet is known as the Red Planet?', 'A. Earth', 'B. Mars', 'C. Jupiter', 'D. Venus', 'B'),
('science', 'What is the basic unit of life?', 'A. Atom', 'B. Cell', 'C. Molecule', 'D. Organ', 'B'),
('science', 'E=mc² is from which scientist?', 'A. Newton', 'B. Einstein', 'C. Galileo', 'D. Tesla', 'B'),
('science', 'What gas do plants absorb?', 'A. Oxygen', 'B. Carbon Dioxide', 'C. Nitrogen', 'D. Helium', 'B'),

-- English
('english', 'What is a synonym for "happy"?', 'A. Sad', 'B. Joyful', 'C. Angry', 'D. Tired', 'B'),
('english', 'Identify the verb in "She runs fast."', 'A. She', 'B. Runs', 'C. Fast', 'D. The', 'B'),
('english', 'What is the plural of "child"?', 'A. Childs', 'B. Children', 'C. Childes', 'D. Childs\'', 'B'),
('english', "'To be or not to be' is from which play?", 'A. Romeo and Juliet', 'B. Hamlet', 'C. Macbeth', 'D. Othello', 'B'),
('english', 'What does "metaphor" mean?', 'A. Direct comparison', 'B. Comparison using "like" or "as"', 'C. Exaggeration', 'D. Repetition', 'A'),

-- History
('history', 'Who was the first U.S. President?', 'A. Lincoln', 'B. Washington', 'C. Jefferson', 'D. Roosevelt', 'B'),
('history', 'In what year did World War II end?', 'A. 1945', 'B. 1939', 'C. 1918', 'D. 1941', 'A'),
('history', 'Who invented the telephone?', 'A. Edison', 'B. Bell', 'C. Tesla', 'D. Marconi', 'B'),
('history', 'What ancient civilization built the pyramids?', 'A. Romans', 'B. Greeks', 'C. Egyptians', 'D. Mayans', 'C'),
('history', 'The Renaissance began in which country?', 'A. France', 'B. Italy', 'C. England', 'D. Spain', 'B');