//unfollow topic
function unfollow_topic() {
    const removeButtons = document.querySelectorAll('.remove');

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
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
}

unfollow_topic();

//unfollow tag
function unfollow_profile_user() {
    const removeButtons = document.querySelectorAll('.remove');

    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const url = button.getAttribute('data-url');
            const tagId = button.getAttribute('data-tag-id');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    tag_id: tagId
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(() => {
                    button.closest('.block').remove(); // Remove the tag block from the DOM

                    const remainingBlocks = document.querySelectorAll('.block');
                    if (remainingBlocks.length === 0) {
                        const container = document.querySelector('#favouriteTagTitle'); // Assuming the parent container has this class
                        const noTagsMessage = document.createElement('div');
                        noTagsMessage.className = 'not-available-container';
                        noTagsMessage.innerHTML = '<p>No favourite tags.</p>';
                        container.insertAdjacentElement('afterend', noTagsMessage);
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
}

unfollow_profile_user();


//unfollow user
function unfollow_user_profile() {
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('unfollow-user-button-profile')) {
            console.log('clicked');
            const unfollowButton = event.target;
            const userId = unfollowButton.dataset.userId;
            const profileId = unfollowButton.dataset.profileId;
            const url = event.target.getAttribute('data-url');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId, profile_id: profileId })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        unfollowButton.closest('.profile-container-admin').remove();
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }
    });
}
unfollow_user_profile();