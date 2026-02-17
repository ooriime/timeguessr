// Synchroniser l'input et le slider
function syncYearInputs() {
    const yearInput = document.getElementById('year-input');
    const yearSlider = document.getElementById('year-slider');

    if (yearInput && yearSlider) {
        yearSlider.addEventListener('input', function() {
            yearInput.value = this.value;
        });

        yearInput.addEventListener('input', function() {
            yearSlider.value = this.value;
        });
    }
}

// Animation de fade-in pour les images
function animateImageLoad() {
    const img = document.querySelector('.image-container img');
    if (img) {
        // Si l'image est déjà chargée
        if (img.complete) {
            img.style.opacity = '1';
        } else {
            // Sinon, attendre le chargement
            img.style.opacity = '0';
            img.onload = function() {
                setTimeout(() => {
                    img.style.transition = 'opacity 0.5s ease';
                    img.style.opacity = '1';
                }, 100);
            };
        }
    }
}

// Validation du formulaire
function validateGuessForm() {
    const form = document.getElementById('guess-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const yearInput = document.getElementById('year-input');
            const year = parseInt(yearInput.value);

            if (isNaN(year) || year < 1800 || year > 2024) {
                e.preventDefault();
                alert('Please enter a valid year between 1800 and 2024');
                return false;
            }
        });
    }
}

// Animation du score
function animateScore() {
    const scoreValue = document.querySelector('.score-value');
    if (scoreValue) {
        const finalScore = parseInt(scoreValue.textContent);
        let currentScore = 0;
        const increment = Math.ceil(finalScore / 50);

        const timer = setInterval(() => {
            currentScore += increment;
            if (currentScore >= finalScore) {
                currentScore = finalScore;
                clearInterval(timer);
            }
            scoreValue.textContent = currentScore;
        }, 20);
    }
}

// Effet de particules pour le score
function createConfetti() {
    const resultTitle = document.querySelector('.result-title');
    if (resultTitle && window.innerWidth > 768) {
        for (let i = 0; i < 50; i++) {
            setTimeout(() => {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = '-10px';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 70%, 60%)`;
                confetti.style.borderRadius = '50%';
                confetti.style.pointerEvents = 'none';
                confetti.style.zIndex = '9999';
                confetti.style.transition = 'all 2s ease';

                document.body.appendChild(confetti);

                setTimeout(() => {
                    confetti.style.top = '100vh';
                    confetti.style.left = (parseFloat(confetti.style.left) + (Math.random() * 40 - 20)) + '%';
                    confetti.style.opacity = '0';
                }, 50);

                setTimeout(() => {
                    confetti.remove();
                }, 2050);
            }, i * 30);
        }
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    syncYearInputs();
    animateImageLoad();
    validateGuessForm();

    // Si on est sur la page de résultat
    if (document.querySelector('.result-container')) {
        animateScore();

        // Ajouter confetti si le score est bon
        const difference = document.querySelector('.difference-value');
        if (difference) {
            const diff = parseInt(difference.textContent.replace(/\D/g, ''));
            if (diff <= 5) {
                createConfetti();
            }
        }
    }
});

// Ajouter un effet de hover sur les boutons
document.addEventListener('mousemove', function(e) {
    const buttons = document.querySelectorAll('.btn-primary');
    buttons.forEach(button => {
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        if (x >= 0 && x <= rect.width && y >= 0 && y <= rect.height) {
            button.style.setProperty('--mouse-x', x + 'px');
            button.style.setProperty('--mouse-y', y + 'px');
        }
    });
});
