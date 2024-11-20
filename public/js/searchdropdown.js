document.addEventListener('DOMContentLoaded', function() {
    var searchButton = document.getElementById('search-button');
    var searchDropdownMenu = document.querySelector('.dropdown-menu[aria-labelledby="search-button"]');

    searchButton.addEventListener('click', function() {
        searchDropdownMenu.classList.toggle('show');
    });

    document.getElementById('add-filters-button').addEventListener('click', function() {
        // Logic to show or hide filter options
        alert('Add filter options here');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!searchButton.contains(event.target) && !searchDropdownMenu.contains(event.target)) {
            searchDropdownMenu.classList.remove('show');
        }
    });
});