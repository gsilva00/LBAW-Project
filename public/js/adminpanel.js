// 'See more' functionality in user list
function seeMoreUsers() {
    const button = document.getElementById('see-more-users');
    const userList = document.getElementById('user-list');

    if (button && userList) {
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
                        userList.insertAdjacentHTML('beforeend', '<p>No more users to show.</p>');
                    }
                })
                .catch(error => console.error('Error fetching more users:', error));
        });
    }
    else {
        console.error('Missing elements for \'see more\' users');
    }
}

seeMoreUsers();


// Create full user functionality
function createFullUser() {
    const form = document.querySelector('form'); // Adjust the selector if needed to target the correct form

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        // Frontend validation
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
                    alert('User created successfully!');
                    form.reset();
                    // Optionally, you could add the new user to the user list dynamically here.
                } else {
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
        const displayNameRegex = /^[a-zA-Z0-9_-]+$/;

        if (!usernameRegex.test(username) || !displayNameRegex.test(displayName)) {
            alert('Username and Display Name should only contain letters, numbers, dashes, and underscores.');
            return false;
        }

        if (!email) {
            alert('Email is required.');
            return false;
        }

        if (!password || password.length < 8) {
            alert('Password should be at least 8 characters long.');
            return false;
        }

        return true;
    }

    function displayErrors(errors) {
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                alert(`${field}: ${errors[field].join(', ')}`);
            }
        }
    }
}

createFullUser();