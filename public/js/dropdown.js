document.addEventListener('DOMContentLoaded', function() {
  var dropdownButton = document.getElementById('profile-button');
  var dropdownMenu = dropdownButton.nextElementSibling;

  dropdownButton.addEventListener('click', function() {
    if (dropdownMenu != null) {
      dropdownMenu.classList.toggle('show');
    }
  });

  // Close the dropdown if clicked outside
  window.addEventListener('click', function(event) {
    if (dropdownMenu != null) {
    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.remove('show');
    }
    }
  });
});