document.addEventListener('DOMContentLoaded', function() {
    const upvoteButton = document.getElementById('upvote-button');
    const downvoteButton = document.getElementById('downvote-button');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const upvoteUrl = upvoteButton.getAttribute('data-upvote-url');
    const downvoteUrl = downvoteButton.getAttribute('data-downvote-url');

    upvoteButton.addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Upvote button clicked');
        fetch(upvoteUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            body: '_token=' + csrfToken
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                } else {
                    document.querySelector('.article-votes p strong').textContent = data.article.upvotes - data.article.downvotes;
                    if (data.voteStatus === 1) {
                        document.querySelector('#upvote-button i').classList.remove('bx-upvote');
                        document.querySelector('#upvote-button i').classList.add('bxs-upvote');
                        document.querySelector('#downvote-button i').classList.remove('bxs-downvote');
                        document.querySelector('#downvote-button i').classList.add('bx-downvote');
                    } else {
                        document.querySelector('#upvote-button i').classList.remove('bxs-upvote');
                        document.querySelector('#upvote-button i').classList.add('bx-upvote');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    });

    downvoteButton.addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Downvote button clicked');
        fetch(downvoteUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            body: '_token=' + csrfToken
        })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                } else {
                    document.querySelector('.article-votes p strong').textContent = data.article.upvotes - data.article.downvotes;
                    if (data.voteStatus === -1) {
                        document.querySelector('#downvote-button i').classList.remove('bx-downvote');
                        document.querySelector('#downvote-button i').classList.add('bxs-downvote');
                        document.querySelector('#upvote-button i').classList.remove('bxs-upvote');
                        document.querySelector('#upvote-button i').classList.add('bx-upvote');
                    } else {
                        document.querySelector('#downvote-button i').classList.remove('bxs-downvote');
                        document.querySelector('#downvote-button i').classList.add('bx-downvote');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    });
});