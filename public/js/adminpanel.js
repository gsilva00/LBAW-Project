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