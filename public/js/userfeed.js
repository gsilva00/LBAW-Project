function addEventListeners() {
    document.querySelectorAll('input[type=radio][name=options]').forEach(radio => {
        radio.addEventListener('change', function() {
            const url = this.parentElement.getAttribute('data-url');
            loadArticles(url);
        });
    });

    // Load default articles on page load
    const defaultUrl = document.querySelector('.btn-secondary.active').getAttribute('data-url');
    loadArticles(defaultUrl);
}

function loadArticles(url) {
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('articles').innerHTML = data;
    })
    .catch(error => {
        alert('Failed to load articles.');
    });
}

addEventListeners();
