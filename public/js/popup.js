function closeMessage() {
    const messageButton = document.getElementById("close-message-button");
    if (messageButton) {
      const message = messageButton.parentElement;
      message.style.display = "none";
    }
}