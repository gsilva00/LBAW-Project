// Setup listeners for article-interaction buttons' events
function addInteractListeners() {
    const upvoteBtn = document.getElementById('upvote-button');
    const downvoteBtn = document.getElementById('downvote-button');
    const favouriteBtn = document.querySelector('.favourite');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (!upvoteBtn || !downvoteBtn || !favouriteBtn || !csrfToken) {
        console.error('Missing elements for \'Article Action\'');
        return;
    }

    upvoteBtn.addEventListener('click', (event) => {
        event.preventDefault();
        handleVote(upvoteBtn, 'upvote', csrfToken);
    });
    downvoteBtn.addEventListener('click', (event) => {
        event.preventDefault();
        handleVote(downvoteBtn, 'downvote', csrfToken);
    });

    favouriteBtn.addEventListener('click', (event) => {
        event.preventDefault();
        handleFavourite(favouriteBtn, csrfToken);
    });

    showReplies();

}

// Handle upvotes and downvotes
function handleVote(button, type, csrfToken) {
    const url = button.getAttribute(`data-${type}-url`);
    console.log(`${type} button clicked`);

    fetchPostRequest(url, {}, csrfToken)
        .then(data => updateVoteUI(data))
        .catch(error => console.error('Error:', error));
}

// Handle favourite/unfavourite actions
function handleFavourite(button, csrfToken) {
    const url = button.getAttribute('data-favourite-url');
    // console.log(`Favourite button clicked`);

    const isFavourite = button.querySelector('i').classList.contains('bxs-star');
    // console.log(`Favourite status: ${isFavourite}`);

    fetchPostRequest(url, { isFavourite: isFavourite }, csrfToken)
        .then(data => updateFavouriteUI(data))
        .catch(error => console.error('Error:', error));
}

// Update visuals of upvote and downvotes buttons and count
function updateVoteUI(data) {
    if (data.message) {
        alert(data.message); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
    }
    else {
        document.querySelector('.article-votes p strong').textContent = (data.article.upvotes - data.article.downvotes).toString();
        updateVoteIcons(data.voteStatus);
    }
}
// Function to update vote icons based on vote status
function updateVoteIcons(voteStatus) {
    const upvoteIcon = '#upvote-button i';
    const downvoteIcon = '#downvote-button i';
    if (voteStatus === 1) { // Upvoted
        toggleIcons(upvoteIcon, 'bx-upvote', 'bxs-upvote');
        toggleIcons(downvoteIcon, 'bxs-downvote', 'bx-downvote');
    }
    else if (voteStatus === -1) { // Downvoted
        toggleIcons(upvoteIcon, 'bxs-upvote', 'bx-upvote');
        toggleIcons(downvoteIcon, 'bx-downvote', 'bxs-downvote');
    }
    else { // Neutral
        toggleIcons(upvoteIcon, 'bxs-upvote', 'bx-upvote');
        toggleIcons(downvoteIcon, 'bxs-downvote', 'bx-downvote');
    }
}

// Update visuals of favourite button
function updateFavouriteUI(data) {
    const favIcon = '.favourite i';
    const favText = document.querySelector('.favourite span');

    if (data.favouriteStatus === 1) { // Added to favourites
        // console.log("Adding to favourites");
        toggleIcons(favIcon, 'bx-star', 'bxs-star');
        favText.textContent = 'Favourited';
    }
    else { // Removed from favourites
        // console.log("Removing from favourites");
        toggleIcons(favIcon, 'bxs-star', 'bx-star');
        favText.textContent = 'Favourite Article';
    }
}

// Helper function to toggle icon classes
function toggleIcons(icon, oldClass, newClass) {
    const element = document.querySelector(icon);
    element.classList.remove(oldClass);
    element.classList.add(newClass);
}

// fetch POST request
function fetchPostRequest(url, bodyData, csrfToken) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': csrfToken
        },
        body: new URLSearchParams(bodyData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(response.statusText);
        }
        return response.json();
    });
}


// Setup listener for AJAX comment submission
function addCommentFormListener() {
    const commentForm = document.getElementById('comment-form');
    const csrfToken = commentForm.querySelector('input[name="_token"]').value;

    if (!commentForm || !csrfToken) {
        console.error('Missing elements for \'Comment Submission\'');
        return;
    }

    commentForm.addEventListener('submit', function(event) {
        event.preventDefault();
        handleCommentSubmission(commentForm, csrfToken);
    });
}

function handleCommentSubmission(form, csrfToken) {
    const commentInput = form.querySelector('.comment-input');
    const commentText = commentInput.value.trim();

    if (commentText === '') {
        alert('Comment cannot be empty.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
        return;
    }

    const url = form.getAttribute('action');
    const bodyData = {
        '_token': csrfToken,
        'comment': commentText
    };

    fetchPostRequest(url, bodyData, csrfToken)
        .then(data => updateCommentsUI(data, commentInput))
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update comments. See console for details.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
        });
}

// Update the comments UI
function updateCommentsUI(data, commentInput) {
    const commentsSection = document.querySelector('.comments-section');
    const commentsList = commentsSection.querySelector('.comments-list');

    if (commentsList) {
        commentsList.innerHTML = data.commentsView;
        commentInput.value = '';
        upvoteComment();
        downvoteComment();
        showReplies();
        deleteButton();
    }
    else {
        console.error('Error: .comments-list element not found');
    }
}


function upvoteComment() {
    document.querySelectorAll('.upvote-comment-button').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const commentElement = this.closest('.comment');
            if (!commentElement) {
                console.error('Comment element not found.');
                return;
            }
            const isReply = commentElement.dataset.isReply === 'true';
            const commentId = this.dataset.commentId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = isReply ? `/reply/${commentId}/upvote-reply` : `/comment/${commentId}/upvote-comment`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    commentId: commentId,
                    isUpvoted: this.querySelector('i').classList.contains('bxs-upvote')
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.comment || data.reply) {
                        const item = data.comment || data.reply;
                        const upvoteCount = document.querySelector(`#${isReply ? 'reply-' : 'comment-'}${item.id} .upvote-count`);
                        if (upvoteCount) {
                            upvoteCount.textContent = item.upvotes - item.downvotes;
                        } else {
                            console.error(`Element with ID ${isReply ? 'reply-' : 'comment-'}${item.id} not found.`);
                        }

                        const upvoteIcon = this.querySelector('i');
                        const downvoteIcon = commentElement.querySelector('.downvote-comment-button i');
                        if (upvoteIcon && downvoteIcon) {
                            if (data.isUpvoted) {
                                upvoteIcon.classList.add('bxs-upvote');
                                upvoteIcon.classList.remove('bx-upvote');
                                downvoteIcon.classList.remove('bxs-downvote');
                                downvoteIcon.classList.add('bx-downvote');
                            } else {
                                upvoteIcon.classList.add('bx-upvote');
                                upvoteIcon.classList.remove('bxs-upvote');
                            }
                        } else {
                            console.error('Upvote or downvote icon not found.');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to upvote comment. See console for details.');
                });
        });
    });
}

function downvoteComment() {
    document.querySelectorAll('.downvote-comment-button').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const commentElement = this.closest('.comment');
            if (!commentElement) {
                console.error('Comment element not found.');
                return;
            }
            const isReply = commentElement.dataset.isReply === 'true';
            const commentId = this.dataset.commentId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = isReply ? `/reply/${commentId}/downvote-reply` : `/comment/${commentId}/downvote-comment`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    commentId: commentId,
                    isDownvoted: this.querySelector('i').classList.contains('bxs-downvote')
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.comment || data.reply) {
                        const item = data.comment || data.reply;
                        const upvoteCount = document.querySelector(`#${isReply ? 'reply-' : 'comment-'}${item.id} .upvote-count`);
                        if (upvoteCount) {
                            upvoteCount.textContent = item.upvotes - item.downvotes;
                        } else {
                            console.error(`Element with ID ${isReply ? 'reply-' : 'comment-'}${item.id} not found.`);
                        }

                        const downvoteIcon = this.querySelector('i');
                        const upvoteIcon = commentElement.querySelector('.upvote-comment-button i');
                        if (downvoteIcon && upvoteIcon) {
                            if (data.isDownvoted) {
                                downvoteIcon.classList.add('bxs-downvote');
                                downvoteIcon.classList.remove('bx-downvote');
                                upvoteIcon.classList.remove('bxs-upvote');
                                upvoteIcon.classList.add('bx-upvote');
                            } else {
                                downvoteIcon.classList.add('bx-downvote');
                                downvoteIcon.classList.remove('bxs-downvote');
                            }
                        } else {
                            console.error('Upvote or downvote icon not found.');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to downvote comment. See console for details.');
                });
        });
    });
}

function showReplies() {
    console.log('showReplies');
    const buttons = document.querySelectorAll('.see-replies-button');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const repliesContainer = this.nextElementSibling;
            const chevron = button.querySelector('i');
            chevron.classList.toggle('bx-chevron-down');
            chevron.classList.toggle('bx-chevron-up');
            repliesContainer.classList.toggle('show');
        });
    });
}


function deleteButton() {
    document.querySelectorAll('.bx-trash').forEach(button => {
        button.closest('button').addEventListener('click', function (event) {
            event.preventDefault();
            const commentElement = this.closest('.comment');
            if (!commentElement) {
                console.error('Comment element not found.');
                return;
            }
            const id = commentElement.id;
            const match = id.match(/(?:comment-|reply-)(\d+)/);
            const commentId = match ? match[1] : null;
            if (!commentId) {
                console.error('Comment ID not found.');
                return;
            }
            const isReply = commentElement.dataset.isReply === 'true';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = isReply ? `/reply/${commentId}/delete-reply` : `/comment/${commentId}/delete-comment`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        commentElement.outerHTML = data.commentsView;
                    } else {
                        console.error('Failed to delete comment:', data.message);
                        alert('Failed to delete comment. See console for details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete comment. See console for details.');
                });
        });
    });
}



addInteractListeners();
addCommentFormListener();
upvoteComment();
downvoteComment();
showReplies();
deleteButton();







