function openPopup() {
    const popup = document.getElementById('popup');
    if (popup) {
        popup.style.display = 'flex';
    } else {
        console.error('Popup element not found');
    }
}

function closePopup() {
    const popup = document.getElementById('popup');
    if (popup) {
        popup.style.display = 'none';
        popup.remove();
    } else {
        console.error('Popup element not found');
    }
}

function proposeTagShow() {
    document.getElementById('propose-tag-container').addEventListener('click', function () {
        const url = document.getElementById('propose-tag-label').getAttribute('data-url');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
            .then(response => response.text())
            .then(html => {
                const popupContainer = document.createElement('div');
                popupContainer.innerHTML = html;
                document.body.appendChild(popupContainer);
                openPopup();
                submitTagProposal();
            })
            .catch(error => console.error('Error loading pop-up:', error));
    });
}

function submitTagProposal() {
    const tagInput = document.getElementById('popup-input');
    const submitButton = document.getElementById('submitTagButton');
    const closeButton = document.getElementById('close-popup');

    if (closeButton) {
        closeButton.addEventListener('click', function () {
            closePopup();
        });
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log('CSRF token:', csrfToken);

    submitButton.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default form submission

        const url = submitButton.getAttribute('data-action-url');
        console.log('URL:', url);

        const tagName = tagInput.value;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                name: tagName
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
                    closePopup();
                } else {
                    alert('Failed to submit tag proposal. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to submit tag proposal. See console for details.');
            });
    });
}
proposeTagShow();
