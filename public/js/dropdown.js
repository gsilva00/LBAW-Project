// Add event listeners to the buttons in the header that open dropdowns (Level 0)
function setupDropdown(buttonId) {
    const dropdownBtn = document.getElementById(buttonId);
    const dropdownMenu = dropdownBtn.nextElementSibling;

    if (!dropdownBtn || !dropdownMenu) {
        console.log(`Dropdown elements not found.`);
        return;
    }

    dropdownBtn.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!dropdownBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
}

// Initial setups
setupDropdown('profile-button');
setupDropdown('all-topics-button');
setupDropdown('search-button');
setupDropdown('search-select-button');


// Add event listeners to the buttons inside the search dropdown (Level 1)
function setupFilterDropdown() {
    const filterBtn = document.getElementById('filter-button');
    const filterMenu = filterBtn.parentElement.nextElementSibling;

    if (!filterBtn || !filterMenu) {
        console.log(`Filter dropdown elements not found.`);
        return;
    }

    filterBtn.addEventListener('click', function(event) {
        event.stopPropagation();
        filterMenu.classList.toggle('show');
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function(event) {
        if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
            filterMenu.classList.remove('show');
        }
    });
}

setupFilterDropdown();








// To disappear filter button depending on the selection of search type (eg.: article, user, comment)
document.addEventListener('DOMContentLoaded', function() {
    const filterButton = document.getElementById('filter-button');
    const searchSelectUser = document.getElementById('search-select-user');
    const searchSelectComment = document.getElementById('search-select-comment');
    const searchSelectArticle = document.getElementById('search-select-article');

    function toggleFilterButton() {
        if (searchSelectUser.checked || searchSelectComment.checked) {
            filterButton.style.display = 'none';
            searchSelectUser.parentElement.style.right = "24.5em";
        } else {
            filterButton.style.display = 'flex';
            searchSelectUser.parentElement.style.right = "29.5em";
        }
    }

    searchSelectUser.addEventListener('change', toggleFilterButton);
    searchSelectComment.addEventListener('change', toggleFilterButton);
    searchSelectArticle.addEventListener('change', toggleFilterButton);

    // Initial setup
    toggleFilterButton();
});