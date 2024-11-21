document.addEventListener('DOMContentLoaded', function() {
    var searchButton = document.getElementById('search-button');
    var searchDropdownMenu = searchButton.nextElementSibling;

    searchButton.addEventListener('click', function() {
        searchDropdownMenu.classList.toggle('show');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!searchButton.contains(event.target) && !searchDropdownMenu.contains(event.target)) {
            searchDropdownMenu.classList.remove('show');
        }
    });
});