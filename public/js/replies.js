document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.see-replies-button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const repliesContainer = this.nextElementSibling;
            const chevron = button.querySelector('i');
            chevron.classList.toggle('bx-chevron-down');
            chevron.classList.toggle('bx-chevron-up');
            repliesContainer.classList.toggle('show');
        });
    });
});