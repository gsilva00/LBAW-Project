document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('new-tab').addEventListener('click', function() {
        if (!this.classList.contains('active')) {
            fetch('/notifications/new')
                .then(response => response.text())
                .then(data => {
                    const contentDiv = document.getElementById('notificationTabsContent');
                    if (contentDiv) {
                        contentDiv.innerHTML = data;
                        this.classList.add('active');
                        this.setAttribute('aria-selected', 'true');
                        document.getElementById('archived-tab').classList.remove('active');
                        document.getElementById('archived-tab').setAttribute('aria-selected', 'false');
                    } else {
                        console.error('Error: Content div not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching new notifications:', error);
                });
        }
    });

    document.getElementById('archived-tab').addEventListener('click', function() {
        if (!this.classList.contains('active')) {
            fetch('/notifications/archived')
                .then(response => response.text())
                .then(data => {
                    const contentDiv = document.getElementById('notificationTabsContent');
                    if (contentDiv) {
                        contentDiv.innerHTML = data;
                        this.classList.add('active');
                        this.setAttribute('aria-selected', 'true');
                        document.getElementById('new-tab').classList.remove('active');
                        document.getElementById('new-tab').setAttribute('aria-selected', 'false');
                    } else {
                        console.error('Error: Content div not found');
                    }
                })
                .catch(error => {
                    console.error('Error fetching archived notifications:', error);
                });
        }
    });
});