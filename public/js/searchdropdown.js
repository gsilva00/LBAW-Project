document.addEventListener('DOMContentLoaded', function() {
    const searchButton = document.getElementById('search-button');
    const searchDropdownMenu = searchButton.nextElementSibling;

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

document.addEventListener('DOMContentLoaded', function() {
    const filterButton = document.getElementById('filter-button');
    const filterDropdownMenu = filterButton.parentElement.nextElementSibling;

    filterButton.addEventListener('click', function(event) {
        event.stopPropagation();
        filterDropdownMenu.classList.toggle('show');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!filterButton.contains(event.target) && !filterDropdownMenu.contains(event.target)) {
            filterDropdownMenu.classList.remove('show');
        }
    });
});