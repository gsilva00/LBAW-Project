function followUser() {
    const followButton = document.getElementById('follow-user-button');

    if (followButton !== null) {

        followButton.addEventListener('click', function () {
            console.log('clicked');
            const isFollowing = followButton.textContent.trim() === 'Unfollow User';
            const url = followButton.getAttribute('data-url');
            const userId = followButton.dataset.userId;
            const profileId = followButton.dataset.profileId;
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({user_id: userId, profile_id: profileId})
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        followButton.textContent = isFollowing ? 'Follow User' : 'Unfollow User';
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });

    }
}

followUser();