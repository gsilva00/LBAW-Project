// Show and hide comment replies
function initializeReplyToggles() {
    const buttons = document.querySelectorAll('.see-replies-button');

    if (!buttons.length) {
        console.log('Reply buttons not found.');
        return;
    }

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const repliesContainer = this.nextElementSibling;
            const chevron = button.querySelector('i');

            if (!repliesContainer || !chevron) {
                console.log('Replies container or chevron icon not found.');
                return;
            }

            chevron.classList.toggle('bx-chevron-down');
            chevron.classList.toggle('bx-chevron-up');
            repliesContainer.classList.toggle('show');
        });
    });
}

// Call the function to initialize the functionality
initializeReplyToggles();