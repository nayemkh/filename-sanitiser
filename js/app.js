document.addEventListener('DOMContentLoaded', () => {
    const clearForm = document.getElementById('clear-form');
    if (clearForm) {
        clearForm.addEventListener('click', function() {
            window.location.replace(window.location.href);
        })
    }
});