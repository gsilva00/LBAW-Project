// 'See more' functionality in user list
function seeMoreUsers() {
    const button = document.getElementById('load-more-users');
    const userList = document.getElementById('user-list');

    if (!button || !userList) {
        console.error('Missing elements for \'see more\'');
        return;
    }

    button.addEventListener('click',function () {
        const url = button.getAttribute('data-url');
        const pageNum = button.getAttribute('data-page-num');

        fetch(`${url}?page=${pageNum}`, {
            method: "GET"
        })
        .then(response => response.json())
        .then(data => {
            // When hasMorePages is false for the first time, at least one user is still returned (see AdminPanelController.php)
            userList.insertAdjacentHTML('beforeend', data.html);
            button.setAttribute('data-page-num', (parseInt(pageNum) + 1).toString());

            if (!data.hasMorePages) {
                button.style.display = 'none';
                userList.insertAdjacentHTML('afterend', '<p>No more users to show.</p>');
            }
        })
        .catch(error => console.error('Error fetching more users:', error));
    });
}

seeMoreUsers();

// Admin's create user
function createFullUser() {
    const form = document.getElementById('createFullUserForm');
    const userList = document.getElementById('user-list');
    const button = document.getElementById('load-more-users');

    if (!form || !userList || !button) {
        console.error('Missing user form elements');
        return;
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        // data-page-num in button refers to the page the button will fetch, not the current one being displayed
        const currentPageNum = (parseInt(button.getAttribute('data-page-num')) - 1).toString();
        formData.append('currentPageNum', currentPageNum);

        if (!validateFormData(formData)) {
            return;
        }

        fetch(form.action, {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
                    form.reset(); // Reset form fields content

                    if (data.newUserHtml) {
                        userList.insertAdjacentHTML('beforeend', data.newUserHtml);
                    }
                    else if (data.isAfterLast) {
                        console.log("New user is added but not visible on the current page.");

                        if (button.style.display === 'none') {
                            button.style.display = 'block';
                        }

                        const noMoreUsersMessage = userList.querySelector('#users-section > p');
                        if (noMoreUsersMessage && noMoreUsersMessage.textContent === 'No more users to show.') {
                            noMoreUsersMessage.remove();
                        }
                    }
                }
                else {
                    displayErrors(data.errors);
                }
            })
            .catch(error => console.error('Error creating user:', error));
    });

    function validateFormData(formData) {
        const username = formData.get('username');
        const displayName = formData.get('display_name');
        const email = formData.get('email');
        const password = formData.get('password');

        const usernameRegex = /^[a-zA-Z0-9_-]+$/;
        const displayNameRegex = /^[a-zA-Z0-9 _-]+$/;

        if (!usernameRegex.test(username)) {
            alert('Username should only contain letters, numbers, dashes, and underscores.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
            return false;
        }
        if (!displayNameRegex.test(displayName)) {
            alert('Display Name should only contain letters, numbers, spaces, dashes, and underscores.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
            return false;
        }
        if (!email) {
            alert('Email is required.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
            return false;
        }
        if (!password || password.length < 8) {
            alert('Password should be at least 8 characters long.'); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
            return false;
        }

        return true;
    }

    function displayErrors(errors) {
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                console.log("Entered displayErrors function");
                alert(`${field}: ${errors[field].join(', ')}`); // TODO BETTER ERROR HANDLING AND USER FEEDBACK
            }
        }
    }
}

createFullUser();