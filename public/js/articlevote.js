document.addEventListener('DOMContentLoaded', function() {
    const upvoteButton = document.getElementById('upvote-button');
    const downvoteButton = document.getElementById('downvote-button');
    const favoriteButton = document.querySelector('.favorite');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const upvoteUrl = upvoteButton.getAttribute('data-upvote-url');
    const downvoteUrl = downvoteButton.getAttribute('data-downvote-url');
    const favoriteUrl = favoriteButton.getAttribute('data-favorite-url');

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

document.addEventListener('DOMContentLoaded', function() {
    const favoriteButton = document.querySelector('.favorite');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const favoriteUrl = favoriteButton.getAttribute('data-favorite-url');

    favoriteButton.addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Favorite button clicked');
        const isFavourite = favoriteButton.querySelector('i').classList.contains('bxs-star') ? 1 : 0;
        fetch(favoriteUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            body: new URLSearchParams({
                '_token': csrfToken,
                'isFavourite': isFavourite
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.favouriteStatus === 1) {
                    favoriteButton.querySelector('i').classList.remove('bx-star');
                    favoriteButton.querySelector('i').classList.add('bxs-star');
                    favoriteButton.querySelector('span').textContent = 'Saved';
                } else {
                    favoriteButton.querySelector('i').classList.remove('bxs-star');
                    favoriteButton.querySelector('i').classList.add('bx-star');
                    favoriteButton.querySelector('span').textContent = 'Save Article';
                }
            })
            .catch(error => console.error('Error:', error));
    });
});