// Quiz Functionality
function checkQuiz(formId, totalQuestions) {
    const form = document.getElementById(formId);
    const resultDiv = document.getElementById('result');
    const submitBtn = form.querySelector('.submit-btn');
    
    if (!form || !resultDiv) return;
    
    let score = 0;
    let userAnswers = {};
    let correctAnswers = {};
    
    // Collect user answers and correct ones
    for (let i = 1; i <= totalQuestions; i++) {
        const userRadio = form.querySelector(`input[name="q${i}"]:checked`);
        const correctHidden = form.querySelector(`.correct-answer[data-q="${i}"]`);
        
        if (correctHidden) {
            correctAnswers[`q${i}`] = correctHidden.value;
        }
        
        if (userRadio) {
            userAnswers[`q${i}`] = userRadio.value;
            if (userAnswers[`q${i}`] === correctAnswers[`q${i}`]) {
                score++;
            }
        }
    }
    
    // Calculate percentage
    const percentage = Math.round((score / totalQuestions) * 100);
    
    // Disable submit and show results
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitted';
    
    // Highlight answers
    for (let i = 1; i <= totalQuestions; i++) {
        const questionDiv = form.querySelector(`.question:nth-of-type(${i})`);
        const radios = questionDiv.querySelectorAll('input[type="radio"]');
        const correctOption = correctAnswers[`q${i}`];
        const userOption = userAnswers[`q${i}`];
        
        radios.forEach(radio => {
            const label = radio.closest('label');
            if (radio.value === correctOption) {
                label.classList.add('correct-answer');
            } else if (radio.value === userOption && userOption !== correctOption) {
                label.classList.add('incorrect-answer');
            }
        });
    }
    
    // Display result
    resultDiv.innerHTML = `
        <div class="success">
            <h3>Your Score: ${score} / ${totalQuestions} (${percentage}%)</h3>
            <p>${getFeedback(percentage)}</p>
            <button onclick="location.reload()" class="btn">Retake Quiz</button>
        </div>
    `;
    
    // Scroll to result
    resultDiv.scrollIntoView({ behavior: 'smooth' });
}

function getFeedback(percentage) {
    if (percentage >= 90) return 'Excellent! You aced the quiz.';
    if (percentage >= 70) return 'Great job! Keep it up.';
    if (percentage >= 50) return 'Good effort. Review the topics.';
    return 'Better luck next time. Study more!';
}

// Admin Form Enhancements
function clearForm() {
    const form = document.getElementById('adminForm');
    if (form) {
        form.reset();
        document.getElementById('questionId').value = '0';
        document.querySelector('.admin-form h3').textContent = 'Add New Question';
    }
}

// Form Validation for Admin (before submit)
document.addEventListener('DOMContentLoaded', function() {
    const adminForm = document.getElementById('adminForm');
    if (adminForm) {
        adminForm.addEventListener('submit', function(e) {
            const correctOption = document.getElementById('correctOption').value;
            if (!/^[A-D]$/i.test(correctOption)) {
                e.preventDefault();
                alert('Correct option must be A, B, C, or D.');
                return false;
            }
            
            // Basic check for empty fields
            const requiredFields = ['question_text', 'option_a', 'option_b', 'option_c', 'option_d'];
            for (let field of requiredFields) {
                const input = document.getElementById(field);
                if (!input || !input.value.trim()) {
                    e.preventDefault();
                    alert('All fields are required.');
                    return false;
                }
            }
        });
    }
    
    // Logo fallback (hide if not loaded)
    const logo = document.querySelector('.logo');
    if (logo) {
        logo.addEventListener('error', function() {
            this.style.display = 'none';
        });
    }
});

// Utility: Make editQuestion work with escaped strings (from PHP)
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
