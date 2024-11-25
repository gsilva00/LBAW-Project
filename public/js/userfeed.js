function addEventListeners() {
    document.querySelectorAll('input[type=radio][name=feed-options]').forEach(radio => {
        radio.addEventListener('change', function() {
            for (let label of document.querySelectorAll('.feed-option')) {
                label.classList.remove('active');
            }
            
            optionLabel = this.parentElement;
            optionLabel.classList.add('active');
            const url = optionLabel.getAttribute('data-url');
            loadArticles(url);
        });
    });

    // Load default articles on page load
    const defaultUrl = document.querySelector('.feed-option.active').getAttribute('data-url');
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
