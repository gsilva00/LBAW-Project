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
        adder();
    }
    else {
        console.error('Error: .comments-list element not found');
    }
}


function upvoteComment() {
    document.querySelectorAll('.upvote-comment-button').forEach(button => {
        button.removeEventListener('click', handleUpvoteClick); // Remove any existing event listener
        button.addEventListener('click', handleUpvoteClick); // Add the new event listener
    });
}

function handleUpvoteClick(event) {
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
}

function downvoteComment() {
    document.querySelectorAll('.downvote-comment-button').forEach(button => {
        button.removeEventListener('click', handleDownvoteClick); // Remove any existing event listener
        button.addEventListener('click', handleDownvoteClick); // Add the new event listener
    });
}

function handleDownvoteClick(event) {
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

function showEditComment() {
    document.querySelectorAll('.bx-pencil').forEach(button => {
        button.closest('button').addEventListener('click', handleEditClick);
    });
}

function handleEditClick(event) {
    event.preventDefault();
    const commentElement = this.closest('.comment');
    const commentId = commentElement.id.match(/(?:comment-|reply-)(\d+)/)[1];
    const isReply = commentElement.dataset.isReply === 'true';
    const articleId = document.querySelector('meta[name="article-id"]').getAttribute('content');

    const url = `/comment/${commentId}/commentForm`;
    const state = isReply ? 'editReply' : 'editComment';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state: state, articleId: articleId })
    })
        .then(response => response.text())
        .then(html => {
            displayEditForm(html, commentElement, this);
        })
        .catch(error => {
            console.error('Error fetching the edit form:', error);
        });
}

function displayEditForm(html, commentElement, editButton) {
    const formContainer = document.createElement('div');
    formContainer.innerHTML = html;
    commentElement.appendChild(formContainer);

    // Change the button icon and text
    const icon = editButton.querySelector('i');
    const text = editButton.querySelector('span');
    icon.classList.remove('bx-pencil');
    icon.classList.add('bx-x');
    text.textContent = 'Cancel the edit';

    // Add event listener to revert changes on click
    const cancelEdit = function (event) {
        event.preventDefault();
        formContainer.remove();
        icon.classList.remove('bx-x');
        icon.classList.add('bx-pencil');
        text.textContent = 'Edit comment';
        editButton.addEventListener('click', handleEditClick);
        editButton.removeEventListener('click', cancelEdit);
    };

    editButton.removeEventListener('click', handleEditClick);
    editButton.addEventListener('click', cancelEdit);

    // Add event listener to handle form submission
    const form = formContainer.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        submitEditForm(form, commentElement, editButton, icon, text, cancelEdit);
    });
}

function submitEditForm(form, commentElement, editButton, icon, text, cancelEdit) {
    const formData = new FormData(form);
    const commentId = commentElement.id.match(/(?:comment-|reply-)(\d+)/)[1];
    const isReply = commentElement.dataset.isReply === 'true';
    const editUrl = `/comment/${commentId}/edit-comment`;

    formData.append('isReply', isReply);

    fetch(editUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                commentElement.innerHTML = data.commentsView;
                icon.classList.remove('bx-x');
                icon.classList.add('bx-pencil');
                text.textContent = 'Edit comment';
                editButton.addEventListener('click', handleEditClick);
                editButton.removeEventListener('click', cancelEdit);
                adder(); // Re-attach event listeners
            } else {
                console.error('Failed to edit comment:', data.message);
            }
        })
        .catch(error => {
            console.error('Error editing comment:', error);
        });
}



function showReplyForm() {
    document.querySelectorAll('.bx-message').forEach(button => {
        button.closest('button').addEventListener('click', handleReplyClick);
    });
}

function handleReplyClick(event) {
    event.preventDefault();
    const commentElement = this.closest('.comment');
    const commentId = commentElement.id.match(/(?:comment-|reply-)(\d+)/)[1];
    const articleId = document.querySelector('meta[name="article-id"]').getAttribute('content');
    const url = `/comment/${commentId}/commentForm`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state: 'reply', articleId: articleId })
    })
        .then(response => response.text())
        .then(html => {
            displayReplyForm(html, commentElement, this);
        })
        .catch(error => {
            console.error('Error fetching the reply form:', error);
        });
}

function displayReplyForm(html, commentElement, replyButton) {
    const formContainer = document.createElement('div');
    formContainer.innerHTML = html;
    commentElement.appendChild(formContainer);

    // Change the button icon and text
    const icon = replyButton.querySelector('i');
    const text = replyButton.querySelector('span');
    icon.classList.remove('bx-message');
    icon.classList.add('bx-x');
    text.textContent = 'Cancel reply';

    // Add event listener to revert changes on click
    const cancelReply = function (event) {
        event.preventDefault();
        formContainer.remove();
        icon.classList.remove('bx-x');
        icon.classList.add('bx-message');
        text.textContent = 'Reply';
        replyButton.addEventListener('click', handleReplyClick);
        replyButton.removeEventListener('click', cancelReply);
    };

    replyButton.removeEventListener('click', handleReplyClick);
    replyButton.addEventListener('click', cancelReply);

    // Add event listener to handle form submission
    const form = formContainer.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        submitReplyForm(form, commentElement, replyButton, icon, text, cancelReply);
    });
}

function submitReplyForm(form, commentElement, replyButton, icon, text, cancelReply) {
    const formData = new FormData(form);
    const commentId = commentElement.id.match(/(?:comment-|reply-)(\d+)/)[1];
    const replyUrl = `/comment/${commentId}/reply`;

    fetch(replyUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let repliesContainer = document.querySelector(`[data-reply-container][data-comment-id="comment-${commentId}"]`);
                if (!repliesContainer) {
                    // Create the replies container
                    repliesContainer = document.createElement('div');
                    repliesContainer.classList.add('reply');
                    repliesContainer.setAttribute('data-reply-container', '');
                    repliesContainer.setAttribute('data-comment-id', `comment-${commentId}`);
                    commentElement.parentNode.insertBefore(repliesContainer, commentElement.nextSibling);

                    // Create the "See replies" button
                    const seeRepliesButton = document.createElement('button');
                    seeRepliesButton.classList.add('small-rectangle', 'see-replies-button');
                    seeRepliesButton.setAttribute('title', 'See replies');
                    seeRepliesButton.innerHTML = `<i class='bx bx-chevron-down remove-position'></i><span data-reply-count="${commentId}">1 Answer</span>`;
                    commentElement.parentNode.insertBefore(seeRepliesButton, repliesContainer);

                    // Attach event listener to the new "See replies" button
                    seeRepliesButton.addEventListener('click', function () {
                        const chevron = seeRepliesButton.querySelector('i');
                        chevron.classList.toggle('bx-chevron-down');
                        chevron.classList.toggle('bx-chevron-up');
                        repliesContainer.classList.toggle('show');
                    });
                }

                // Append the new reply
                const newReply = document.createElement('div');
                newReply.innerHTML = data.replyView;
                repliesContainer.appendChild(newReply);

                // Update the reply count
                let replyCountElement = document.querySelector(`[data-reply-count="${commentId}"]`);
                if (replyCountElement) {
                    let replyCount = parseInt(replyCountElement.textContent.match(/\d+/)[0]);
                    replyCount++;
                    replyCountElement.textContent = `${replyCount} ${replyCount > 1 ? 'Answers' : 'Answer'}`;
                }

                icon.classList.remove('bx-x');
                icon.classList.add('bx-message');
                text.textContent = 'Reply';
                replyButton.addEventListener('click', handleReplyClick);
                replyButton.removeEventListener('click', cancelReply);
                adder(); // Re-attach event listeners
                form.closest('div').remove(); // Remove the form container
            } else {
                console.error('Failed to reply to comment:', data.message);
            }
        })
        .catch(error => {
            console.error('Error replying to comment:', error);
        });
}

function reattachSeeRepliesListeners() {
    const buttons = document.querySelectorAll('.see-replies-button');
    buttons.forEach(button => {
        button.removeEventListener('click', toggleReplies); // Remove any existing event listener
        button.addEventListener('click', toggleReplies); // Add the new event listener
    });
}

function toggleReplies() {
    const repliesContainer = this.nextElementSibling;
    const chevron = this.querySelector('i');
    chevron.classList.toggle('bx-chevron-down');
    chevron.classList.toggle('bx-chevron-up');
    repliesContainer.classList.toggle('show');
}

function adder() {
    addInteractListeners();
    addCommentFormListener();
    upvoteComment();
    downvoteComment();
    reattachSeeRepliesListeners();
    deleteButton();
    showEditComment();
    showReplyForm();
}

adder();




