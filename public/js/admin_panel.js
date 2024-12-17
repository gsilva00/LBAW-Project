function createWithPagination(formId, listId, buttonId, successMessage, errorMessage) {
    const form = document.getElementById(formId);
    const list = document.getElementById(listId);
    const button = document.getElementById(buttonId);

    // If any of the required elements are missing, return early
    if (!form || !list || !button) {
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
                    alert(successMessage); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
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
                        alert(data.message || errorMessage);
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


function seeMoreEntities(buttonId, listId) {
    const button = document.getElementById(buttonId);
    const list = document.getElementById(listId);

    if (!button || !list) {
        console.error(`Missing elements for '${listId}'`);
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

function toggleTrendingTag() {
    const tagList = document.getElementById('tag-list');

    if (!tagList) {
        console.error('Missing element: #tag-list');
        return;
    }

    // Handle click events for toggling trending status
    tagList.addEventListener('click', function (event) {
        const button = event.target;

        if (button.matches('.trending-tag-action')) {
            const form = button.closest('form');
            const url = form.action;
            const formData = new FormData(form);

            fetch(url, {
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
        }
    });
}


seeMoreEntities('load-more-users', 'user-list');
seeMoreEntities('load-more-topics', 'topic-list');
seeMoreEntities('load-more-tags', 'tag-list');

createWithPagination(
    'createFullUserForm',
    'user-list',
    'load-more-users',
    'User created successfully!',
    'Error creating user.'
);
createWithPagination(
    'createTopicForm',
    'topic-list',
    'load-more-topics',
    'Topic created successfully!',
    'Error creating topic.'
);
createWithPagination(
    'createTagForm',
    'tag-list',
    'load-more-tags',
    'Tag created successfully!',
    'Error creating tag.'
);

toggleTrendingTag();

