function setupDropdown(buttonId) {
  const dropdownButton = document.getElementById(buttonId);
  const dropdownMenu = dropdownButton.nextElementSibling;
  if (!dropdownButton || !dropdownMenu) {
    console.log(`Dropdown elements not found for ${buttonId}.`);
    return;
  }

  dropdownButton.addEventListener('click', function() {
    dropdownMenu.classList.toggle('show');
  });

  // Close the dropdown if clicked outside
  window.addEventListener('click', function(event) {
    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.remove('show');
    }
  });
}

// Initial setups
setupDropdown('profile-button');
setupDropdown('all-topics-button');