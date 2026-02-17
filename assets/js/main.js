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

function validateGuessForm() {
    const form = document.getElementById('guess-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const yearInput = document.getElementById('year-input');
            const year = parseInt(yearInput.value);

            if (isNaN(year) || year < 1800 || year > 2024) {
                e.preventDefault();
                alert('Entrez une annee valide entre 1800 et 2024');
                return false;
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    syncYearInputs();
    validateGuessForm();
});
