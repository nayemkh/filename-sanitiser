document.addEventListener('DOMContentLoaded', () => {
    const clearForm = document.getElementById('clear-form');
    const capitaliseWord = document.getElementById('capitalise-word');

    if (clearForm) {
        clearForm.addEventListener('click', () => {
            window.location.replace(window.location.href);
        });
    }

    if (capitaliseWord) {
        const ignoreWords = document.getElementsByClassName('ignore-words')[0];
        if (capitaliseWord.checked) {
            ignoreWords.classList.add('show-item');
        }
        capitaliseWord.addEventListener('change', e => {
            if (e.target.checked) {
                ignoreWords.classList.add('show-item');
            } else {
                ignoreWords.classList.remove('show-item');
            }
        });
    }
});