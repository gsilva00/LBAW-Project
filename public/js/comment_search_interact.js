document.addEventListener('DOMContentLoaded', function () {
    const commentsTab = document.getElementById('comments-tab');
    const repliesTab = document.getElementById('replies-tab');
    const commentsDiv = document.getElementById('comments-searched');
    const repliesDiv = document.getElementById('replies-searched');

    commentsTab.addEventListener('click', function () {
        if (!commentsTab.classList.contains('active')) {
            commentsDiv.style.display = 'block';
            repliesDiv.style.display = 'none';
            commentsTab.classList.add('active');
            commentsTab.setAttribute('aria-selected', 'true');
            repliesTab.classList.remove('active');
            repliesTab.setAttribute('aria-selected', 'false');
        }
    });

    repliesTab.addEventListener('click', function () {
        if (!repliesTab.classList.contains('active')) {
            commentsDiv.style.display = 'none';
            repliesDiv.style.display = 'block';
            repliesTab.classList.add('active');
            repliesTab.setAttribute('aria-selected', 'true');
            commentsTab.classList.remove('active');
            commentsTab.setAttribute('aria-selected', 'false');
        }
    });
});



