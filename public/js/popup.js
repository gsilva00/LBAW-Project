// Clicking on the X icon on the user feedback closes it
function closeMessage() {
    const messageButton = document.getElementById("close-message-button");
    if (messageButton) {
      const message = messageButton.parentElement;
      message.style.display = "none";
    }
}