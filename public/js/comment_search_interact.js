document.addEventListener('DOMContentLoaded', function () {
    const commentsTab = document.getElementById('comments-tab');
    const repliesTab = document.getElementById('replies-tab');
    const commentsDiv = document.getElementById('comments-searched');
    const repliesDiv = document.getElementById('replies-searched');

    if (commentsTab !== null && repliesTab !== null) {
        commentsTab.addEventListener('click', function () {
            if (!commentsTab.classList.contains('active')) {
                commentsDiv.style.display = 'block';
                repliesDiv.style.display = 'none';
                commentsTab.parentElement.classList.add('active');
                repliesTab.parentElement.classList.remove('active');
            }
        });

        repliesTab.addEventListener('click', function () {
            if (!repliesTab.classList.contains('active')) {
                commentsDiv.style.display = 'none';
                repliesDiv.style.display = 'block';
                repliesTab.parentElement.classList.add('active');
                commentsTab.parentElement.classList.remove('active');
            }
        });
    }
});



