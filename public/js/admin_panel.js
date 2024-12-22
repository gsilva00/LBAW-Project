function notAvailableContainer(message) {
    const container = document.createElement('div');
    container.className = 'not-available-container';
    container.innerHTML = `<p>${message}</p>`;
    return container;
}

function createWithPagination(formId, listId, buttonId, successMsg, errorMsg) {
    const form = document.getElementById(formId);
    const list = document.getElementById(listId);
    const button = document.getElementById(buttonId);

    // If any of the required elements are missing, return early
    if (!form || !list || !button) {
        console.warn('Missing elements for \'createWithPagination\'');
        return;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        console.log('Form submitted');

        const formData = new FormData(form);

        const entity = button.getAttribute('data-entity');
        const isValid = validateForm(formData, entity);
        if (!isValid) {
            alert('Invalid form data.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
            return;
        }

        // Handle pagination: `data-page-num` in button refers to the page to fetch next
        const currPageNum = (parseInt(button.getAttribute('data-page-num')) - 1).toString();
        formData.append('currPageNum', currPageNum);

        fetch(form.action, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(successMsg); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                    form.reset(); // Clear the form fields

                    if (data.newHtml) {
                        // console.log('New entity created, appending to list...');
                        list.insertAdjacentHTML('beforeend', data.newHtml); // Append new entity to the end of the list
                    }
                    else if (data.isAfterLast) {
                        // console.log("New entity created but not visible on the current page.");
                        if (button.style.display === 'none') {
                            button.style.display = 'block';
                        }
                        const noMoreMessage = list.querySelector('p');
                        if (noMoreMessage && noMoreMessage.textContent === 'No more entries to show.') {
                            noMoreMessage.remove();
                        }
                    }
                }
                else {
                    if (data.errors) {
                        displayErrors(data.errors);
                    }
                    else {
                        alert(data.message || errorMsg);
                    }
                }
            })
            .catch(error => console.error(`Error creating entity from ${formId}:`, error));
    });

    // Display error messages returned from the server
    function displayErrors(errors) {
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                alert(`${field}: ${errors[field].join(', ')}`);
            }
        }
    }
}

function validateForm(formData, entityType) {
    let isValid;

    switch (entityType) {
        case 'user':
            isValid = validateUserForm(formData);
            break;
        case 'topic':
            isValid = validateTopicForm(formData);
            break;
        case 'tag':
            isValid = validateTagForm(formData);
            break;
        default:
            console.error(`Unknown entity type: ${entityType}`);
            isValid = false;
    }

    return isValid;
}

function validateUserForm(formData) {
    const username = formData.get('username').trim();
    const displayName = formData.get('display_name').trim();
    const email = formData.get('email').trim();
    const password = formData.get('password').trim();

    const usernameRegex = /^[a-zA-Z0-9_-]+$/;
    const displayNameRegex = /^[a-zA-Z0-9 _-]+$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (username.length < 3 || username.length > 20) {
        alert('Username must be between 3 and 20 characters.');
        return false;
    }
    if (!usernameRegex.test(username)) {
        alert('Username should only contain letters, numbers, dashes, and underscores.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
        return false;
    }

    if (displayName.length < 3 || displayName.length > 20) {
        alert('Display name must be between 3 and 20 characters.');
    }
    if (!displayNameRegex.test(displayName)) {
        alert('Display Name should only contain letters, numbers, spaces, dashes, and underscores.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
        return false;
    }

    if (!emailRegex.test(email)) {
        alert('Please provide a valid email address.');
        return false;
    }

    if (password.length < 8) {
        alert('Password must be at least 8 characters long.');
        return false;
    }

    return true;
}
function validateTopicForm(formData) {
    const topicName = formData.get('name').trim();

    if (topicName === '') {
        alert('Topic name is required.');
        return false;
    }

    if (topicName.length > 30) {
        alert('Topic name must not exceed 30 characters.');
        return false;
    }

    return true;
}
function validateTagForm(formData) {
    const tagName = formData.get('name').trim();

    if (tagName === '') {
        alert('Tag name is required.');
        return false;
    }

    if (tagName.length > 30) {
        alert('Tag name must not exceed 30 characters.');
        return false;
    }

    return true;
}

// For AJAX delete and ban actions
function userAction() {
    const userList = document.getElementById('user-list');

    if (!userList) {
        console.warn('User list element not found.');
        return;
    }

    userList.addEventListener('submit', function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const action = form.getAttribute('data-action');

        if (action === 'delete') {
            if (!confirm('Are you sure you want to delete this account?')) {
                return;
            }
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    if (action === 'delete') {
                        form.closest('.profile-container-admin').remove();
                    }
                    else if (action === 'ban') {
                        const button = form.querySelector('button');
                        button.textContent = data.is_banned ? 'Unban User' : 'Ban User';
                        form.setAttribute('data-action', data.is_banned ? 'unban' : 'ban');
                    }
                }
                else {
                    alert(data.message || 'Action failed.');
                }
            })
            .catch(error => console.error('Error:', error));
    });
}

function seeMoreEntities(listId, buttonId) {
    const list = document.getElementById(listId);
    const button = document.getElementById(buttonId);

    if (!list || !button) {
        console.warn('Missing elements for \'seeMoreEntities\'');
        return;
    }

    button.addEventListener('click', function () {
        const url = button.getAttribute('data-url');
        const pageNum = button.getAttribute('data-page-num');

        fetch(`${url}?page=${pageNum}`, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.newHtml) {
                    // When hasMorePages is false for the first time, at least one item is still returned (see AdminPanelController.php)
                    list.insertAdjacentHTML('beforeend', data.newHtml); // Append new content
                    button.setAttribute('data-page-num', (parseInt(pageNum) + 1).toString()); // Update page number

                    // Check if we need to hide the button
                    if (!data.hasMorePages) {
                        button.style.display = 'none';
                        list.insertAdjacentHTML('afterend', '<p>No more entries to show.</p>');
                    }
                }
                else {
                    console.error(`Error: No 'html' content returned for '${listId}'`); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                }
            })
            .catch(error => console.error(`Error fetching more data for '${listId}':`, error)); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
    });
}

// Setup toggle trending tag for the whole list
function toggleTrendingTag() {
    const tagList = document.getElementById('tag-list');

    if (!tagList) {
        console.warn('Missing element for \'toggleTrendingTag\'');
        return;
    }

    // Handle click events for toggling trending status
    tagList.addEventListener('submit', function (event) {
        event.preventDefault()

        const form = event.target;
        const button = form.querySelector('.trending-tag-action');
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Update button text and attribute based on the new trending status
                    button.textContent = data.is_trending ? 'Remove from Trending' : 'Add to Trending';
                    button.setAttribute('data-is-trending', data.is_trending);

                    alert(data.message); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                } else {
                    alert(data.message || 'Failed to toggle trending.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                }
            })
            .catch((error) => console.error('Error toggling trending status:', error)); // TODO BETTER ERROR HANDLING AND USER FEEDBACK

    });
}


// Handle tag proposal actions (accept/reject) for
function handleProposal() {
    const proposalList = document.getElementById('tag-proposal-list');
    const tagList = document.getElementById('tag-list');

    if (!proposalList || !tagList) {
        console.warn('Missing elements for \'handleProposal\'');
        return;
    }


    proposalList.addEventListener('submit', function (event) {
        event.preventDefault()

        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                    form.closest('.propose-tag-tile').remove();

                    if (data.newHtml) {
                        tagList.insertAdjacentHTML('beforeend', data.newHtml);
                    }

                    if (proposalList.children.length === 0) {
                        proposalList.insertAdjacentElement('afterend', notAvailableContainer('No pending tag proposals to list.'));
                    }
                }
                else {
                    alert('Failed to process the proposal.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                }
            })
            .catch(error => console.error('Error processing proposal:', error)); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
    });
}


function handleUnbanAppeal() {
    const appealList = document.getElementById('unban-appeal-list');

    if (!appealList) {
        console.warn('Missing elements for \'handleUnbanAppeal\'');
        return;
    }

    appealList.addEventListener('submit', function (event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    form.closest('.unban-appeal-tile').remove();

                    if (appealList.children.length === 0) {
                        appealList.insertAdjacentElement('afterend', notAvailableContainer('No pending unban appeals to list.'));
                    }
                }
                else {
                    alert('Failed to process the appeal.');
                }
            })
            .catch(error => console.error('Error processing appeal:', error));
    });
}


seeMoreEntities(
    'user-list',
    'load-more-users'
);
seeMoreEntities(
    'topic-list',
    'load-more-topics'
);
seeMoreEntities(
    'tag-list',
    'load-more-tags'
);
seeMoreEntities(
    'tag-proposal-list',
    'load-more-tag-proposals'
);
seeMoreEntities(
    'unban-appeal-list',
    'load-more-unban-appeals'
);

createWithPagination(
    'createFullUserForm',
    'user-list',
    'load-more-users',
    'User created successfully!',
    'Error creating user.',
);
createWithPagination(
    'createTopicForm',
    'topic-list',
    'load-more-topics',
    'Topic created successfully!',
    'Error creating topic.',
);
createWithPagination(
    'createTagForm',
    'tag-list',
    'load-more-tags',
    'Tag created successfully!',
    'Error creating tag.',
);

userAction();
toggleTrendingTag();
handleProposal();
handleUnbanAppeal();