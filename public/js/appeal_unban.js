function showAppealUnbanPopup() {
    document.getElementById('unban-appeal-button').addEventListener('click', function () {
        const url = this.getAttribute('data-action-url');
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.text())
            .then(html => {
                const popupContainer = document.createElement('div');
                popupContainer.innerHTML = html;
                document.body.appendChild(popupContainer);
                openAppealPopup();
                submitAppealUnban();
            })
            .catch(error => console.error('Error loading pop-up:', error));
    });
}

showAppealUnbanPopup();

function openAppealPopup() {
    const popup = document.getElementById('appealUnbanPopup');
    if (popup) {
        popup.style.display = 'flex';
    } else {
        console.error('Popup element not found');
    }
}

function closeAppealPopup() {
    const popup = document.getElementById('appealUnbanPopup');
    if (popup) {
        popup.style.display = 'none';
        popup.remove();
    } else {
        console.error('Popup element not found');
    }
}

function submitAppealUnban() {
    const appealReason = document.getElementById('appealReason');
    const submitButton = document.getElementById('submirAppealUnban');
    const closeButton = document.getElementById('closePopup');
    const maxLength = 300;

    if (!submitButton) {
        console.error('Submit button not found');
        return;
    }

    const url = submitButton.getAttribute('data-action-url');
    console.log(url);
    if (!url) {
        console.error('data-action-url attribute not found on submit button');
        return;
    }

    appealReason.addEventListener('input', function () {
        const charCount = appealReason.value.length;
        if (charCount > maxLength) {
            appealReason.value = appealReason.value.substring(0, maxLength);
        }
        document.getElementById('charCountFeedback').textContent = `${charCount}/${maxLength} characters`;
    });

    closeButton.addEventListener('click', function () {
        closeAppealPopup();
    });

    submitButton.addEventListener('click', function (event) {
        event.preventDefault();
        const charCount = appealReason.value.length;
        if (charCount > maxLength) {
            alert('Reason for appeal cannot exceed 300 characters.');
            return;
        }

        const reason = appealReason.value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                appealReason: reason
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeAppealPopup();
                } else {
                    alert('Failed to submit appeal. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit appeal. See console for details.');
            });
    });
}