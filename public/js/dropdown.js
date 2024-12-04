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