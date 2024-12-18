    const followButton = document.getElementById('follow-user-button');
    const followUrl = '/following/user/action/follow';
    const unfollowUrl = '/following/user/action/unfollow';

    followButton.addEventListener('click', function () {
        console.log('clicked');
        const isFollowing = followButton.textContent.trim() === 'Unfollow User';
        const url = isFollowing ? unfollowUrl : followUrl;
        const userId = followButton.dataset.userId;
        const profileId = followButton.dataset.profileId; // Assuming you have a data attribute for the profile ID

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