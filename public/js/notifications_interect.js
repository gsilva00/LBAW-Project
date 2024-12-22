document.addEventListener('DOMContentLoaded', function() {
    const newTab = document.getElementById('new-tab');

    if (newTab) {

    newTab.addEventListener('click', function() {
        if (!this.parentElement.classList.contains('active')) {
            fetch('/notifications/new/all')
                .then(response => response.text())
                .then(data => {
                    const contentDiv = document.getElementById('notificationTabsContent');
                    if (contentDiv) {
                        contentDiv.innerHTML = data;
                        this.parentElement.classList.add('active');
                        this.setAttribute('aria-selected', 'true');
                        document.getElementById('archived-tab').parentElement.classList.remove('active');
                        document.getElementById('archived-tab').setAttribute('aria-selected', 'false');

                        // Set "All" button as active
                        const allTab = document.getElementById('all-tab');
                        allTab.parentElement.classList.add('active');
                        allTab.setAttribute('aria-selected', 'true');
                        document.getElementById('upvotes-tab').parentElement.classList.remove('active');
                        document.getElementById('comments-tab').parentElement.classList.remove('active');
                        archiveNotification();
                    } else {
                        console.error('Error: Content div not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching new notifications:', error);
                });
        }
    });
}

    const archivedTab = document.getElementById('archived-tab');

    if (archivedTab) {
        
    archivedTab.addEventListener('click', function() {
        if (!this.parentElement.classList.contains('active')) {
            fetch('/notifications/archived/all')
                .then(response => response.text())
                .then(data => {
                    const contentDiv = document.getElementById('notificationTabsContent');
                    if (contentDiv) {
                        contentDiv.innerHTML = data;
                        this.parentElement.classList.add('active');
                        this.setAttribute('aria-selected', 'true');
                        document.getElementById('new-tab').parentElement.classList.remove('active');
                        document.getElementById('new-tab').setAttribute('aria-selected', 'false');

                        // Set "All" button as active
                        const allTab = document.getElementById('all-tab');
                        allTab.parentElement.classList.add('active');
                        allTab.setAttribute('aria-selected', 'true');
                        document.getElementById('upvotes-tab').parentElement.classList.remove('active');
                        document.getElementById('comments-tab').parentElement.classList.remove('active');
                        archiveNotification();
                    } else {
                        console.error('Error: Content div not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching archived notifications:', error);
                });
        }
    });
}

});




function filterNotifications() {
    const tabs = ['all', 'upvotes', 'comments'];

    tabs.forEach(tab => {
        document.getElementById(`${tab}-tab`).addEventListener('click', function() {
            console.log('clicked');
            if (!this.parentElement.classList.contains('active')) {
                newTab = document.getElementById('new-tab');

                if(newTab.parentElement.classList.contains('active')) {
                    type = 'new';
                }
                else{
                    type = 'archived';
                }

                fetch(`/notifications/${type}/${tab}`)
                    .then(response => response.text())
                    .then(data => {
                        const contentDiv = document.getElementById('notificationTabsContent');
                        if (contentDiv) {
                            contentDiv.innerHTML = data;
                            tabs.forEach(t => {
                                document.getElementById(`${t}-tab`).parentElement.classList.remove('active');
                            });
                            this.parentElement.classList.add('active');
                            this.setAttribute('aria-selected', 'true');
                            archiveNotification();
                        } else {
                            console.error('Error: Content div not found');
                        }
                    })
                    .catch(error => {
                        console.error(`Error fetching ${tab} notifications:`, error);
                    });
            }
        });
    });
}

filterNotifications();


function archiveNotification() {
    document.querySelectorAll('button.small-rectangle.greener#archive-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const notificationId = this.getAttribute('data-notification-id');
            fetch(`/notifications/archiving/${notificationId}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the notification card from the DOM
                        const notificationCard = document.querySelector(`.notification-card[notification_id="${notificationId}"]`);
                        if (notificationCard) {
                            notificationCard.remove();
                        }
                    } else {
                        console.error('Error archiving notification:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
}

archiveNotification();
