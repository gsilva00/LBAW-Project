document.addEventListener('DOMContentLoaded', function() {
    const removeButtons = document.querySelectorAll('.remove');

    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const url = button.getAttribute('data-url');
            const topicId = button.getAttribute('data-topic-id');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    topic_id: topicId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(() => {
                button.closest('.block').remove(); // Remove the topic block from the DOM
                
                const remainingBlocks = document.querySelectorAll('.block');
                if (remainingBlocks.length === 0) {
                    const container = document.querySelector('#favouriteTopicTitle'); // Assuming the parent container has this class
                    const noTopicsMessage = document.createElement('div');
                    noTopicsMessage.className = 'not-available-container';
                    noTopicsMessage.innerHTML = '<p>No favourite topics.</p>';
                    container.insertAdjacentElement('afterend', noTopicsMessage);
                }

            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
});