document.addEventListener('DOMContentLoaded', function() {
  var dropdownButton = document.getElementById('profile-button');
  var dropdownMenu = document.querySelector('.dropdown-menu');

  dropdownButton.addEventListener('click', function() {
    dropdownMenu.classList.toggle('show');
  });

  // Close the dropdown if clicked outside
  window.addEventListener('click', function(event) {
    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
      dropdownMenu.classList.remove('show');
    }
  });
});